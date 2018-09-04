<?php

namespace app\Models;
use Core\BaseModel;
use core\RD;

class Article extends BaseModel{

    function increase($id){

        // $this->redis;
        echo self::$redis->get('name');
        $data = RD::chache('key',60,function()use($id){
            return self::findOne("select * from mbg_articles where id=".$id);
        });

        var_dump($data);

    }
}