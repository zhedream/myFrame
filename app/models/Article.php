<?php

namespace app\Models;
use Core\Model;
use core\RD;

class Article extends Model{

    static function get($id){

        return RD::chache('Articles:'.$id,60,function()use($id){
            return self::findOne("select * from mbg_articles where id=?",[$id]);
        });
    }

    function increase($id){
        ob_clean(); // 清空缓存区
        if(self::$redis->hexists ('Hash:Aricles:display',$id))
            return self::$redis->hincrby('Hash:Aricles:display',$id,1);
        
        $num = self::findOneFirst('select display from mbg_articles where id=?',[$id]);
        if($num!==null){
            
            self::$redis->hset('Hash:Aricles:display',$id,(int)$num);
            return self::$redis->hincrby('Hash:Aricles:display',$id,1);
        }
        return false;
    }

    
}