<?php
namespace core;
use \Predis\Client as redis;
use app\Models\Article;
// RD::client();
class RD{

    private static $redis = null;
    private function __construct(){self::client();}
    private function __clone(){}

    private static function client(){
        if (self::$redis === NULL) {
            // echo '<br>client<br>';
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



}






?>