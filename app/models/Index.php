<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Index extends Model {

    function welcome(){
        return 'Welcome To MyFrame!';
    }
    
    function insert($data) {
        
        $data = [
            'key'=>'',
        ];
        
        $data = self::exec_insert($data);
        if ($data) {
            return true;;

        }else{
            return false;

        }

    }

    function delete($id) {

        $condition = [
            'id'=>$id,
        ];
        return self::exec_delete($condition);
        
    }

    function update($id,$data){

        $data = [
            'key'=>'',
        ];

        $condition = [
            'id'=>$id,
        ];

        return self::exec_update($data,$condition);
    }



}