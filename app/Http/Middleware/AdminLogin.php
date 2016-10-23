<?php

namespace App\Http\Middleware;

use Closure;

class AdminLogin
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
        //如果没有用户进行登录则返回让用户进行登录
        if(!session('user')){
            return redirect('admin/login');
        }
        return $next($request);
    }
}
