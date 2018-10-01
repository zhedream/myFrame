<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Category extends Model {
    
    protected $table = 'categorys';
    protected $fillable = ['name','pid','path'];

    function getAdd(){
        $data = self::findAll('select *,concat(path,"-",id) dpath from categorys order by dpath');
        foreach ($data as $key => $value) {
            preg_match_all('/-/',$value['dpath'],$sum);
            $count = count($sum[0]);
            $str="";
            for ($i=0; $i < $count-1; $i++) { 
                $str.="-";
            }
            $str.="$i|";
            $data[$key]['name'] =  $str.$value['name'];
        }

        return $data;
    }

}