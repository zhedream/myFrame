<?php
if(!defined("ACCESS")){
    echo "未经过 主入口<br>";
    header("location:../index.php");
}
require_once ROOT."Core/Loader.php";

use core\Route;

class App{

    public static function run(){

        self::initCharset();
        self::initDir();
        self::initError();
        Route::initDispatch();
    }

    private static function initCharset(){
        header("Content-type:text/html;charset=utf-8");
    }
    public static function initDir(){
        //目录斜线
        define("DS",DIRECTORY_SEPARATOR);
        //根目录
        // define("ROOT",getcwd() . DS);
        //主程序目录
        define("APP_PATH",ROOT . "app" . DS);
        //Home目录
        define("Home_PATH",APP_PATH . "Home" . DS);
        //Admin目录
        define("Admin_PATH",APP_PATH . "Admin" . DS);
        //Model目录
        define("Model_PATH",APP_PATH . "Model" . DS);
        //PUBLIC目录
        define("PUBLIC_PATH",ROOT . "Public" . DS);
        //UPLOAD目录
        define("UPLOAD_PATH",ROOT . "Upload" . DS);
        //VENdOR目录
        define("VENDOR_PATH",ROOT . "Vendor" . DS);
        //配置目录
        define("CONFIG_PATH",ROOT . "Config" . DS);

        $GLOBALS['config'] = include CONFIG_PATH ."config.php";

    }

    private static function initError(){

        @ini_set("display",1);
        @ini_set("error_reporting","E_ALL");

    }
        // 路由
    private static function initDispatch(){

        Route::initURL();
        $ac = ACTION;
        $cName = CONTROLLER."Controller";
        $cPath = APP_PATH.PLAT."controllers/". $cName .".php";

        if(file_exists($cPath)){
            
            $Controller= 'app\\'.PLAT."controllers\\".$cName;
            echo $Controller.lm;
            $controllerObj = new $Controller;
            // $controllerObj = new app\controllers\indexController;
            
            if(method_exists($controllerObj,$ac)){
                if(Loader::$is_debug)
                echo "存在方法APP".lm;
                $controllerObj->$ac();
            }else{

                if(Loader::$is_debug)
                var_dump(get_class_methods($controllerObj));
                $a = get_class_methods($controllerObj)[0];
                if(Loader::$is_debug)
                echo "{$ac}方法不存在,将掉用{$a}方法".lm;
                $controllerObj->$a();
            }
        }else{

            echo "控制器不存在,将跳转<br>";
            // die('END');
            $Controller= PLAT."\\Controller\\"."IndexController";
            $controllerObj = new $Controller;
            $controllerObj->error_jump(PLAT,"index","index");
        }


    }

}



?>