<?php 
namespace app\controllers;
use Core\HomeController;
use Core\DB;
use Core\RD;
use app\Models\TestModel;
class TestController extends HomeController{

    function redis(){
        echo 'this is TestController';
        $redis = RD::getRD();
        echo $redis->get('name');
    }

    function mysql(){
        echo 'this is TestController';
        var_dump( DB::findOne("select * from dy_user where id=?",[1]));
    }

    function mail($data){


        var_dump($data);

    }

}

 ?>