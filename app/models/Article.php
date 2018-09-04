<?php

namespace app\Models;
use Core\BaseModel;
use core\RD;

class Article extends BaseModel{

    function increase($id){

        var_dump( self::findOne("select * from mbg_articles where id=".$id));

    }
}