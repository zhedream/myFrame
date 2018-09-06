<?php

namespace app\Models;
use Core\BaseModel;
use core\RD;

class User extends BaseModel{

    static function get($id){

        return RD::chache('Users:'.$id,30,function()use($id){
            return self::findOne("select * from mbg_authors where id=?",[$id]);
        });
    }

    static function store($email,$password,$code){
        if(RD::waitOut('mailout',$email)){
            RD::iqueue('sendmail',[$email,$password,$code]);
            echo "邮件已发送,请查收";
        }
        else
            echo "60秒后，才能再次发送";

    }

}