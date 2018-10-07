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
    public function handle($request,Closure $next){   

        $ex =  method_exists($request,'authorize');
        $ex2 =  method_exists($request,'rules');
        if($ex && $ex2){
            echo '前置中间件:需要验证表单<br>';

            $auth = $request->authorize();
            if($auth){
                $rules = $request->rules();
                // dd($rules);
                foreach ($rules as $key => $val) {
                    // var_dump($request->all());
                    $tem = $request->$key.lm;
                    // echo $tem;
                        // 验证项目
                    foreach ($val as $k => $v) {
                        if(is_string($v)){
                            if($v == 'required'){

                            }
                        }
                        if(is_callable($v)){

                            $re = $v($tem);
                            if($re)
                                echo '函数验证'.$key."结果:通过".lm;
                            else{
                                
                                echo '函数验证'.$key."结果:失败".lm;
                                // return ;
                            }
                        }
                    }
                }

            }else{

                echo('权限不足'); 
                return ;

            }

            


        }

        
        return $next();
    }
}
