<?php
namespace core;
use core\Request;
class Route{

    private static $self = null;
    private function __construct(){}
    private function __clone(){}

    static function new(){
        if(self::$self===null)
            self::$self = new self;
        return self::$self;
    }
    
    static $method;
    static $pathinfo;
    static $map = [];
    
    static $lastUrl;
    static $gets=[];
    static $posts=[];

    static function initDispatch(){
        // goto a; // 原始路由
        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] :'/';

        // echo '<hr>';
        // echo $_SERVER['PATH_INFO'];
        // echo '<hr>';
        // echo self::$method;
        // echo '<hr>';
        // echo self::$pathinfo;
        // echo '<hr>';

        if(self::$method == 'GET'){
            // print_r($_GET);
            foreach (self::$gets as $key => $value) {

                $patt = "/".$value['patt']."/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                // var_dump($matches);
                
                if($isMatched){
                    // echo "<hr>".self::$pathinfo."该路由为GET注册路由,控制器{$value['controller']},方法{$value['action']}, 正则{$value['patt']} <hr>";
                    $controller = new $value['controller'];
                    $ac = $value['action'];
                        // 分发 路由
                    // $controller->$ac(isset($matches[1])?$matches[1]:null,new Request($value,$matches));
                    $data = $controller->$ac(new Request($value,$matches),isset($matches[1])?$matches[1]:null);
                    // die("<br>END");
                    return;
                }
            }
        }
        else if(self::$method == 'POST'){
            // print_r($_POST);
            foreach (self::$posts as $key => $value) {

                $patt = "/".$value['patt']."/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                // var_dump($matches);
                if($isMatched){
                    // echo "<hr>".self::$pathinfo."该路由为POST注册路由,控制器{$value['controller']},方法{$value['action']}, 正则{$value['patt']} <hr>";
                    $controller = new $value['controller'];
                    $ac = $value['action'];
                    // $controller->$ac(isset($matches[1])?$matches[1]:null,new Request($value,$matches));
                    $controller->$ac(new Request($value,$matches),isset($matches[1])?$matches[1]:null);
                    // die("<br>END");
                    return;
                }
            }

        }

        // view("error");

        die('未知');
        a:;
        echo "goto";

    }

    static function get($url,$path){
        $self = self::new();
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

        $pathinfo =  explode('/', $url);


        // var_dump($pathinfo);
        $patt = "^";
        if(count( $pathinfo)>0 && $pathinfo[1]!=""){
        for ($i=1; $i < count( $pathinfo); $i++) { 
            if(preg_match('/\{.*\}/', $pathinfo[$i], $matches))
                $patt .= "\/(\d+)";
            else
                $patt .= "\/".$pathinfo[$i];
        }
            $patt .= "\/?$";
        }
        else
        {
            $patt = "^\/$";
        }

        // die;

        self::$gets[] = [
            'url'=>$url,
            'controller'=>$controller,
            'action'=>$action,
            'patt'=>$patt,
        ];
        // return;
        // echo "<hr>";
        // echo "GET路由注册成功：url->( {$url} ),控制器->( {$controller} ),方法->( {$action}  ) 正则{$patt}<br>";
        // echo '<hr>';
        self::$lastUrl = $url;

        return $self;
        
    }


    static function post($url,$path){
        $self = self::new();
        try{
            foreach (self::$posts as $key => $value)
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

        $pathinfo =  explode('/', $url);


        // var_dump($pathinfo);
        $patt = "^";
        if(count( $pathinfo)>0 && $pathinfo[1]!=""){
        for ($i=1; $i < count( $pathinfo); $i++) { 
            if(preg_match('/\{.*\}/', $pathinfo[$i], $matches))
                $patt .= "\/(\d+)";
            else
                $patt .= "\/".$pathinfo[$i];
        }
            $patt .= "\/?$";
        }
        else
        {
            $patt = "^\/$";
        }

        // die;

        self::$posts[] = [
            'url'=>$url,
            'controller'=>$controller,
            'action'=>$action,
            'patt'=>$patt,
        ];
        // return;
        // echo "<hr>";
        // echo "POST路由注册成功：url->( {$url} ),控制器->( {$controller} ),方法->( {$action}  ) 正则{$patt}<br>";
        // echo '<hr>';

        self::$lastUrl = $url;
        
        return $self;
    }

    /**
     *  加载视图
     *  参数一、加载的视图的文件名
     *  参数二、向视图中传的数据
     */
    static function view($viewFileName, $data = []){
        view($viewFileName, $data);

    }

    /**
     * 为添加的路由 命名
     * 1. 名称
     */
    function name($name){
        self::$map[] = [
            'url'=>self::$lastUrl,
            'name'=>$name
        ];
        echo $name;

    }


    

}





?>