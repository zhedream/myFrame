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
        if( RD::waitOut('mailout',$email)){
            RD::iqueue('sendmail',[$email,$password,$code]);
            return true;
        }
        else
            return false;
    }

    static function usersave($user){
        self::exec("insert into mbg_authors (email,name,password) values(?,?,?)",[$user[0],getChar(2),md5($user[1])]);
    }



}