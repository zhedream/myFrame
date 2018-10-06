<?php
namespace core;

class Middleware
{

    static $stack;

    public function run($app){
        
        // make 中间栈
        
        $pipes = $this->makeStack();
        
        $firstSlice = function() use($app) {
            echo "(6)请求向路由器传递，返回响应.".'<br>';
            $app();
        };
    
        $pipes = array_reverse($pipes);
        // $pipes = array_reverse($pipes);
        // var_dump($pipes);die;
                                    // 去皮
        $go = array_reduce($pipes, $this->getSlice(),$firstSlice);
        $go();
        
    }
    
    public function makeStack(){

        $pipes = [
            // "CheckForMaintenanceMode"=>\CheckForMaintenanceMode::class,
            \App\Middlewares\CheckLogin::class,
            // \EncryptCookies::class,
            // "AddQueuedCookiesToResponse",
            // "StartSession",
            // "ShareErrorsFromSession",
            // "VerifyCsrfToken",
            // "CheckLogin",
            // "Checkout",
        ];


        return $pipes;

    }

    function getSlice(){

        return function($stack, $pipe)
        {
            return function() use ($stack, $pipe)
            {   
                
                // echo $pipe."----";
                $p = new $pipe;
                // 反射 与 依赖注入 未完待续
                return $p->handle($stack);
            };
        };
    }



}