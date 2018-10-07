<?php

namespace app\Middlewares;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request,Closure $next)
    {   
        echo '前置中间件:检查登陆状态<br>';
        return $next();
    }
}
