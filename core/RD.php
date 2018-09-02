<?php
namespace core;
use \Predis\Client as redis;
RD::client();
class RD{

    static $redis = null;

    function __construct(){
        self::client();
    }

    static function client(){
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
                echo "{$dbname}数据库连接失败！".$e->getMessage();
            }
		}
    }

    static function getRD(){
        // if (self::$redis === NULL) self::db();
        if (self::$redis === NULL) {
            // echo '2<br>';
            self::client();
            return self::$redis;
        }
        else{
            // echo '3<br>';
            return self::$redis;
        }
    }

}






?>