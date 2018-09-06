<?php
namespace core;
use \Predis\Client as redis;
use app\Models\Article;
RD::getRD();
class RD{

    private static $redis = null;
    private function __construct(){self::client();}
    private function __clone(){}

    private static function client(){
        if (self::$redis === NULL) {
            echo '<br>client<br>';
            // $conf = (include ROOT."Config/config.php")['redis'];
            $conf = $GLOBALS['config']['redis'];

            try{
                return self::$redis = new redis([
                    'scheme' => $conf['scheme'],
                    'host'   => $conf['host'],
                    'port'   => $conf['port'],
                ]);
            }catch(PDOException $e){
                echo "Redis连接失败！".$e->getMessage();
            }
		}
    }

    /**
     * 获取redis对象
     */
    public static function getRD(){
        if (self::$redis === NULL) 
            self::client();
        return self::$redis;
    }
    /**
     * redis 缓存
     * 1.键
     * 2.过期时间（秒）
     * 3.值 匿名函数 return 数据
     */
    public static function chache(string $key,int $minutes, callable $call){

            // 返回 1 0
        $key = "String:".$key;
        if( self::$redis->exists($key)){
            return json_decode( self::$redis->get($key),true); // 存在键 则返回
        }
        $str = json_encode( $call());
        self::$redis->setex($key,$minutes,$str);
        return json_decode( self::$redis->get($key),true);
    }

    /**
     * 时效等待 等待时间过期 如发邮件 60s 只能一次
     * 
     * 1. 键: 时效类型名称
     * 2. key
     * 3. 内容信息
     * 4. 时效时间 int 60
     * return 是否等待 存在则返回FLASE 不存在则设置存在返回 值 
     */
    public static function waitOut(string $type,string $key, $message = true,int $minutes = 60){

        $message = json_encode( $message);
        $key = "String:timeout:".$type.":".($key);

        if(self::$redis->exists ($key)){
            return false;
        }
        return self::$redis->setex($key,$minutes, $message);
    }
    /**
     * 设置 消息 时效
     * 1. 消息类型 名称
     * 2. key
     * 3. 数据
     * 4. 过期时间 
     */
    public static function setTimeOut(string $type,string $key, $message = true,int $minutes = 60){

        $message = json_encode( $message);
        $key = "String:timeout:".$type.":".($key);

        return self::$redis->setex($key,$minutes,$message);

    }
    /**
     * 抓取(确认) 时效 消息
     * 1. 类型 名称
     * 2. 消息
     * 3. 是否弹出 bool
     */
    public static function getTimeOut(string $type,string $key,bool $pop = false){

        // $message = json_encode( $message);
        $key = "String:timeout:".$type.":".($key);
        if(self::$redis->exists ($key)){
            $data = self::$redis->get ($key);
            if($pop)
                self::$redis->del($key);
            return json_decode($data,true);
        }
            return false;

    }

    /**
     * 加入redis List 消息队列
     * 1. 键:队列名称
     * 2. 消息
     * 3. 过期时间 int -1
     * return 该键队列长度
     */
    public static function iqueue(string $key,$message, int $minutes = -1){
        $key = "List:".$key;
        return self::$redis->lpush($key,json_encode( $message));
    }
    /**
     * 弹出队列
     * 1. 键: 队列名称
     * return 
     */
    public static function oqueue(string $key){
        $key = "List:".$key;
        return json_decode( self::$redis->rpop($key),true);

    }
    /**
     * 阻塞弹出队列
     * 1. 键: 队列名称
     * return mixed
     */
    public static function boqueue(string $key){
        $key = "List:".$key;
        return json_decode( self::$redis->brpop($key,0)[1],true);
    }

}






?>