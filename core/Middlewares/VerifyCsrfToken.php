<?php

namespace core\Middlewares;

use core\Route;
use Closure;

class VerifyCsrfToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \core\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        
        // if (!in_array(Route::$routeName, Route::$csrfPass)) {
        //     if (!isset($_POST['_token'])) {
        //         die( json_encode([
        //             'err' => 007,
        //             'msg' => '请求无效,无令牌'
        //         ]));
        //     }
        //     if ($_POST['_token'] != $_SESSION['_token']) {
        //         // var_dump($_SESSION['_token']);
        //         die (json_encode([
        //             'session' => $_SESSION,
        //             'err' => 007,
        //             'msg' => '请求超时,令牌过期'
        //         ]));
        //     }
        // }

        echo '前置中间件:检查token<br>';

        return $next();
    }
}
