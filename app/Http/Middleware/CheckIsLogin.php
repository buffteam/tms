<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class CheckIsLogin
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
        $log_token = $_COOKIE['log_token'];
        // 查看是否存在log_token cookie
        if (!isset($log_token)) {
            return redirect('/login');
        }

        $tokenData =  DB::table('users_token')->where('token',$log_token)->select('uid','token_expired')->first();
//        dump($tokenData->token_expired);
        // 如果过期了跳转到登录
        if (time() > $tokenData->token_expired) {
            return redirect('/login');
        }
        return $next($request);
    }
}
