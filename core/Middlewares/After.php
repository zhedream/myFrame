<?php

namespace core\Middlewares;

use Closure;

class After
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
        $return = $next();
        // echo '<br>后置中间件:后置处理日志记录，请求分析<br>';
        return $return;
    }
}
