<?php

namespace app\Models;
use Core\BaseModel;

class TestModel extends BaseModel{

    function getUserInfo(){
        return [
            'name'=>'者之梦'
        ];
    }
}