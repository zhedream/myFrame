<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类
use core\Route;

class Privilege extends Model {
    
    protected $table = 'privilege';
    protected $fillable = ['pri_name','url_path','parent_id'];

    function getBasePrivilege(){


        $gets = Route::$gets;
        $posts = Route::$posts;
        $base = array_merge($gets,$posts);
        $base = array_reduce($base,function($return,$iteration){
            $return[$iteration['lockName']] = $iteration['locked'];
            return $return;
        });

        return $base;
        
    }


}