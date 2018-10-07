<?php

namespace core\Middlewares;

use Closure;

class ValidateFromInput
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
        echo '前置中间件:验证表单<br>';
        $auth = $request->authorize();
        $rule = $request->rules();
        var_dump($auth,$rule);die;
        return $next();
    }
}
