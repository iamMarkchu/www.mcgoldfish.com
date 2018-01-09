<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class PageVisitLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        DB::table('page_visits')->insert([
            'ip' => $request->server('REMOTE_ADDR'),
            'visit_time' => date('Y-m-d H:i:s'),
            'user_agent' => $request->server('HTTP_USER_AGENT'),
            'referrer' => $request->server('HTTP_REFERER'),
            'request_uri' => $request->fullUrl(),
            'route_name'  => $request->route()->getName(),
        ]);
        return $next($request);
    }
}
