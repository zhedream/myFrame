<?php

namespace app\Models;
use Core\BaseModel;
use core\RD;

class Article extends BaseModel{

    static function get($id){

        return RD::chache('Articles:'.$id,60,function()use($id){
            return self::findOne("select * from mbg_articles where id=?",[$id]);
        });
    }

    function increase($id){
        
        if(self::$redis->hexists ('Hash:Aricles:display',$id)){
            return self::$redis->hincrby('Hash:Aricles:display',$id,1);
        }
        $num = self::findOneFirst('select display from mbg_articles where id=?',[$id]);
        // var_dump($num);
        if($num!==null)
            return self::$redis->hset('Hash:Aricles:display',$id,(int)$num+1);
        return false;
    }
}