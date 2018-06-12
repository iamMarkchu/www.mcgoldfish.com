<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index(Request $request)
    {
        $result = $this->user->with('roles')->paginate($request->input('pageSize', 30));
        return response()->api($result);
    }

    public function show($id)
    {
        $user = $this->user->find($id);
        if ($this->user->hasAnyRole(Role::all()))
        {
            $user->roles = $user->roles();
        } else {
            $user->roles = [];
        }
        return response()->api($user);
    }

    public function update(Request $request, $id)
    {
        $user = $this->user->find($id);
        if ($request->has('role_names'))
        {
            $user->syncRoles($request->input('role_names'));
        }
        return response()->api();
    }
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function settings(Request $request)
    {
        return view('auth.settings');
    }
}
