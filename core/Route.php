<?php

namespace core;

use core\Request;
use core\ReflexMethod; // 自定义 反射类
use core\reflexs\ReflexDispatchMethod; // 自定义 反射类

class Route {

    private static $self = null;

    private function __construct() {
    }

    private function __clone() {
    }

    static function new() {
        if (self::$self === null)
            self::$self = new self;
        return self::$self;
    }
    
    static $csrfPass = ['alipay.notify', 'wxpay.notify','user.doavatar']; //csrf 白名单
    static $method; // 请求方式
    static $pathinfo; // 请求路径
    static $map = []; // 名称映射

    static $lastUrl; // 命名中转
    static $gets = []; //保存GET 路由
    static $posts = [];

    static $currentRouteInfo = []; //
    static $currentRouteVar = []; //

    static $routeName; // 请求路由 名称

    static function initDispatch() {
        // goto a; // 原始路由
        self::$method = $_SERVER['REQUEST_METHOD'];
        self::$pathinfo = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';

        echo '<hr>';
        echo $_SERVER['PATH_INFO'];
        echo '<hr>';
        echo self::$method;
        echo '<hr>';
        // echo self::$pathinfo;
        // echo '<hr>';

        if (self::$method == 'GET') {
            foreach (self::$gets as $key => $value) {

                $patt = "/" . $value['patt'] . "/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                // var_dump($matches);die;
                // dd($isMatched);
                if ($isMatched) {
                    self::$currentRouteInfo = $value; // 路由信息
                    self::$currentRouteVar = $matches;// 路由变量
                    self::$routeName = isset($value['name']) ? $value['name'] : null;
                    // echo "<hr>".self::$pathinfo."该路由为GET注册路由,控制器{$value['controller']},方法{$value['action']}, 正则{$value['patt']} <hr>";
                    $controller = new $value['controller'];
                    $ac = $value['action'];

                    $ref = new ReflexDispatchMethod ($controller,$ac); // 反射 方法
                    $ref->invokeArgs($controller);
                    
                    return;
                }
            }
        } else if (self::$method == 'POST') {
            // var_dump(self::$pathinfo);die;
            

            foreach (self::$posts as $key => $value) {

                $patt = "/" . $value['patt'] . "/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                if ($isMatched) {
                    // var_dump($value,$matches);die;
                    self::$currentRouteInfo = $value; // 路由信息
                    self::$currentRouteVar = $matches;// 路由变量
                    self::$routeName = isset($value['name']) ? $value['name'] : null; // 路由名
                    // echo "<hr>".self::$pathinfo."该路由为POST注册路由,控制器{$value['controller']},方法{$value['action']}, 正则{$value['patt']} ,路由名称 {$value['name']} <hr>";
                    // die;

                    if (!in_array(self::$routeName, self::$csrfPass)) {
                        if (!isset($_POST['_token'])) {
                            echo json_encode([
                                'err' => 007,
                                'msg' => '请求无效,无令牌'
                            ]);
                            return;
                        }
        
                        if ($_POST['_token'] != $_SESSION['_token']) {
                            // var_dump($_SESSION['_token']);
                            echo json_encode([
                                'session' => $_SESSION,
                                'err' => 007,
                                'msg' => '请求超时,令牌过期'
                            ]);
                            return;
                        }
                    }
                    
                    $controller = new $value['controller'];
                    $ac = $value['action'];

                    $ref = new ReflexDispatchMethod ($controller,$ac); // 反射 方法
                    $ref->invokeArgs($controller);
                    // die("<br>END");
                    return;
                }
            }

        }

        view("error");

        die('页面不见了');
        a:;
        echo "goto";

    }

    /**
     * 获得类的方法参数，只获得有类型的参数
     * @param  [type] $className   [description]
     * @param  [type] $methodsName [description]
     * @return [type]              [description]
     */
    protected static function getMethodParams($className, $methodsName = 'insert') {

        // 通过反射获得该类
        $class = new \ReflectionClass($className);
        $paramArr = []; // 记录参数，和参数类型

        // 判断该类是否有构造函数
        if ($class->hasMethod($methodsName)) {
            // 获得构造函数
            $construct = $class->getMethod($methodsName);

            // 判断构造函数是否有参数
            $params = $construct->getParameters();

            if (count($params) > 0) {

                // 判断参数类型
                foreach ($params as $key => $param) {

                    if ($paramClass = $param->getClass()) {

                        // 获得参数类型名称
                        $paramClassName = $paramClass->getName();

                        // 获得参数类型
                        $args = self::getMethodParams($paramClassName);
                        $paramArr[] = (new \ReflectionClass($paramClass->getName()))->newInstanceArgs($args);
                    }
                }
            }
        }

        return $paramArr;
    }

    /**
     * 注册 get 路由
     * 1. 地址
     * 2. 分发控制器方法
     */
    static function get($url, $path) {
        $self = self::new();

        foreach (self::$gets as $key => $value)
            if ($value['url'] == $url)
                throwE("GET路由地址( {$url} )已存在", 'get');

        list($controller, $action) = explode('@', $path);
        $controller = str_replace('/', '\\', $controller);

        $pathinfo = explode('/', $url);


        // var_dump($pathinfo);
        $patt = "^";
        if (count($pathinfo) > 0 && $pathinfo[1] != "") {
            for ($i = 1; $i < count($pathinfo); $i++) {
                if (preg_match('/\{.*\}/', $pathinfo[$i], $matches))
                    $patt .= "\/(\d+)";
                else
                    $patt .= "\/" . $pathinfo[$i];
            }
            $patt .= "\/?$";
        } else {
            $patt = "^\/$";
        }

        // die;

        self::$gets[] = [
            'url' => $url,
            'controller' => $controller,
            'action' => $action,
            'patt' => $patt,
        ];
        // return;
        // echo "<hr>";
        // echo "GET路由注册成功：url->( {$url} ),控制器->( {$controller} ),方法->( {$action}  ) 正则{$patt}<br>";
        // echo '<hr>';

        self::$lastUrl = [
            'method' => 'get',
            'url' => $url,
        ];
        // self::$lastUrl = &end(self::$gets);

        return $self;

    }

    /**
     * 注册 post 路由
     * 1. 地址
     * 2. 分发控制器方法
     */
    static function post($url, $path) {
        $self = self::new();
        foreach (self::$posts as $key => $value)
            if ($value['url'] == $url)
                throwE("POST路由地址( {$url} )已存在", 'get');
        list($controller, $action) = explode('@', $path);
        $controller = str_replace('/', '\\', $controller);

        $pathinfo = explode('/', $url);

        // var_dump($pathinfo);
        $patt = "^";
        if (count($pathinfo) > 0 && $pathinfo[1] != "") {
            for ($i = 1; $i < count($pathinfo); $i++) {
                if (preg_match('/\{.*\}/', $pathinfo[$i], $matches))
                    $patt .= "\/(\d+)";
                else
                    $patt .= "\/" . $pathinfo[$i];
            }

            $patt .= "\/?$";
        } else {
            $patt = "^\/$";
        }

        // die;

        self::$posts[] = [
            'url' => $url,
            'controller' => $controller,
            'action' => $action,
            'patt' => $patt,
        ];
        // return;
        // echo "<hr>";
        // echo "POST路由注册成功：url->( {$url} ),控制器->( {$controller} ),方法->( {$action}  ) 正则{$patt}<br>";
        // echo '<hr>';

        self::$lastUrl = [
            'method' => 'post',
            'url' => $url,
        ];

        return $self;
    }

    /**
     *  加载视图
     *  参数一、加载的视图的文件名
     *  参数二、向视图中传的数据
     */
    static function view($viewFileName, $data = []) {

        view($viewFileName, $data);
    }

    /**
     * 为添加的路由 命名
     * 1. 名称
     */
    function name($name) {
        
        if(in_array($name,array_keys(self::$map))){
            throwE('路由名称重复','name');
        }

        self::$map[$name] = self::$lastUrl;

        if (self::$lastUrl['method'] == 'get')
            self::$gets[count(self::$gets) - 1]['name'] = $name;
        else
            self::$posts[count(self::$posts) - 1]['name'] = $name;
    }   

    /**
     * 生产路由 URL
     */
    function makeUrl($name, $data = [], $full = false) {

        // extract($data);
        if (!isset(self::$map[$name])) {
            throwE('不存在路由名称' . $name, 'Route'); // name -> Route
        }
        // var_dump( self::$map[$name]);
        $url = self::$map[$name]['url'];

        foreach ($data as $key => $val) {

            $patt = "/" . "\{$key\}" . "/";
            $url = preg_replace($patt, $val, $url);
        }

        if (preg_match('/\{.*\}/', $url, $matches)) {
            // dd($matches);
            throwE('请检查路由参数,存在未解析的路由参数'.$matches[0], 'Route');
        }

        if ($full) {
            $app_url = $GLOBALS['config']['APP_URL'];
            return $app_url . $url;
        }
        return ($url);

    }

    /**
     * 获取当前路由的名称  五路由返回false
     */
    function getRouteName(){
        var_dump(self::$map);
    }


}


?>