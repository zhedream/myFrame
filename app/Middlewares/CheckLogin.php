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
    public function handle($request,Closure $next){   
        if(!isset($_SESSION['amdin_id'])){
            // echo '前置中间件:未登陆';
            // dd($_SESSION);
            return redirect('/login/index');
            // return message('请重新登陆',1,'/');
        }else{
            
            // echo '前置中间件:已登陆';
        }
        return $next();
    }
}
