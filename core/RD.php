<?php
namespace core;
use \Predis\Client as redis;
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

}






?>