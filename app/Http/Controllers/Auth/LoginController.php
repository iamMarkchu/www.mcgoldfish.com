<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * @var string
     */
    protected $loginAfterUrl = 'login-after-url';
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * The user has been authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function authenticated(Request $request)
    {
        if ($request->filled('callback'))
        {
            $this->redirectTo = $request->get('callback');
        }
        if ($request->filled('from'))
        {
            $this->redirectTo .= '#'.$request->get('from');
        }
        return redirect()->intended($this->redirectTo);
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return \Illuminate\Http\Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('github')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $user = $this->findOrCreateUser(
            Socialite::driver('github')->user()
        );
        Auth::login($user);
        return redirect()->intended($this->redirectTo);
    }

    public function findOrCreateUser($githubUser)
    {
        $user = User::firstOrNew(
            ['github_id' => $githubUser->getId()]
        );
        if ($user->exists)  return $user;

        // 通过邮件查找
        $user = $user->where(['email' => $githubUser->getEmail()])->first();
        if ($user->exists)
        {
            if(empty($user->github_id))
            {
                $user->github_id = $githubUser->getId();
                $user->save();
            }
            return $user;
        }

        $user->fill([
            'name' => $githubUser->getName(),
            'email' => $githubUser->getEmail(),
            'avatar' => $githubUser->getAvatar(),
            'password' => bcrypt(env('DEFAULT_PASSWORD')),
        ])->save();
        return $user;
    }
}
