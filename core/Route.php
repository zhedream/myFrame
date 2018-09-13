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
    static $csrfPass = ['/alipay/notify','/wxpay/notify']; //csrf 白名单
    static $method; // 请求方式
    static $pathinfo; // 请求路径
    static $map = []; // 名称映射
    
    static $lastUrl; // 命名中转
    static $gets=[]; //保存GET 路由
    static $posts=[];

    static $routeName; // 请求路由 名称

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
            foreach (self::$gets as $key => $value) {

                $patt = "/".$value['patt']."/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                // var_dump($matches);
                
                if($isMatched){
                    self::$routeName = isset($value['name'])?$value['name']:null;
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
            // var_dump(self::$pathinfo);die;
            if(!in_array(self::$pathinfo,self::$csrfPass)){
                if(!isset($_POST['_token'])){
                    echo json_encode( [
                            'err'=>007,
                            'msg'=>'请求无效,无令牌'
                    ]);
                    return ;
                }
                    
                if($_POST['_token']!=$_SESSION['_token']){
                    // var_dump($_SESSION['_token']);
                    echo json_encode( [
                            'session'=>$_SESSION,
                            'err'=>007,
                            'msg'=>'请求超时,令牌过期'
                        ]);
                        return ;
                }
            }

            foreach (self::$posts as $key => $value) {

                $patt = "/".$value['patt']."/";
                // preg_match()
                $isMatched = preg_match($patt, self::$pathinfo, $matches);
                // var_dump($matches);
                if($isMatched){
                    self::$routeName = isset($value['name'])?$value['name']:null;
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

        view("error");

        die('页面不见了');
        a:;
        echo "goto";

    }

    /**
     * 注册 get 路由
     * 1. 地址
     * 2. 分发控制器方法
     */
    static function get($url,$path){
        $self = self::new();

        foreach (self::$gets as $key => $value)
            if($value['url']==$url)
                throwE("GET路由地址( {$url} )已存在",'get');
                
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

        self::$lastUrl = [
            'method'=>'get',
            'url'=>$url,
        ];
        // self::$lastUrl = &end(self::$gets);

        return $self;
        
    }

    /**
     * 注册 post 路由
     * 1. 地址
     * 2. 分发控制器方法
     */
    static function post($url,$path){
        $self = self::new();
        foreach (self::$posts as $key => $value)
            if($value['url']==$url)
                throwE("POST路由地址( {$url} )已存在",'get');
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

        self::$lastUrl = [
            'method'=>'post',
            'url'=>$url,
        ];
        
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

        self::$map[$name] = self::$lastUrl;

        if(self::$lastUrl['method']=='get')
            self::$gets[count(self::$gets)-1]['name'] = $name;
        else
            self::$posts[count(self::$posts)-1]['name'] = $name;

    }

    /**
     * 生产路由 URL
     */
    function makeUrl($name,$data = [],$full = false){
        
        // extract($data);
        if(!isset(self::$map[$name])){
            throwE('不存在路由名称'.$name,'Route'); // name -> Route  
        }
        // var_dump( self::$map[$name]);
        $url =  self::$map[$name]['url'];

        foreach ($data as $key => $val) {

            $patt = "/"."\{$key\}"."/";
            $url = preg_replace($patt,$val,$url);
        }

        if(preg_match('/\{.*\}/', $url, $matches)){
            throwE('请检查路由参数','Route');
        }

        if($full){
            $app_url = $GLOBALS['config']['APP_URL'];
            return $app_url.$url; 
        }
        return ($url);
        
    }


    

}





?>