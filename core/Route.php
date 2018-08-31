<?php
namespace core;

class Route{
    static $method;
    static $pathinfo;

    static $gets=[];
    static $posts=[];

    static function initDispatch(){
        // goto a; // 原始路由
        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] :'/';

        // echo '<hr>';
        // echo self::$method;
        // echo '<hr>';
        // echo self::$pathinfo;
        // echo '<hr>';

        if(self::$method == 'GET'){
            // print_r($_GET);
            foreach (self::$gets as $key => $value) {
                if($value['url']==self::$pathinfo){
                    // echo self::$pathinfo."该路由为注册路由,控制器{$value['controller']},方法{$value['action']}";
                    $controller = new $value['controller'];
                    $ac = $value['action'];
                    $controller->$ac();
                    return;
                }
            }
        }
        else if(self::$method == 'POST'){
            // print_r($_POST);
            foreach (self::$posts as $key => $value) {
                if($value['url']==self::$pathinfo){
                    // echo self::$pathinfo."该路由为注册路由,控制器{$value['controller']},方法{$value['action']}";
                    $controller = new $value['controller'];
                    $ac = $value['action'];
                    $controller->$ac();
                    return;
                }
            }

        }

        view("error");
        // echo '<hr>';
        // print_r($_SERVER);

        die();
        a:;
        echo "goto";

    }

    static function get($url,$path){
        
        try{
            foreach (self::$gets as $key => $value)
                if($value['url']==$url)
                    throw new \Exception("路由地址( {$url} )已存在",0); // 处理错误信息 的 对象
        }catch(\Exception $e){
            echo "<hr>出错文件:&nbsp".$e->getFile()."<hr>";
            echo "错误信息:&nbsp".$e->getMessage()."<hr>";
            echo "错误行号:&nbsp".$e->getLine()."<hr>";
            die;
        }
        list($controller,$action) = explode('@', $path);
        $controller = str_replace('/', '\\', $controller);

        self::$gets[] = [
            'url'=>$url,
            'controller'=>$controller,
            'action'=>$action,
        ];
        return;
        echo "<hr>";
        echo "路由注册成功：url->( {$url} ),控制器->( {$controller} ),方法->( {$action} )";
        echo '<hr>';
    }


    static function post(){


    }

/**
 *  加载视图
 *  参数一、加载的视图的文件名
 *  参数二、向视图中传的数据
 */
    static function view($viewFileName, $data = []){
        view($viewFileName, $data);

    }


    

}





?>