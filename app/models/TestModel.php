<?php

namespace app\Models;
use Core\BaseModel;

class TestModel extends BaseModel{

    static function getUserInfo(){
        return [
            'name'=>'者之梦'
        ];
    }
}