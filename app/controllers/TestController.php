<?php 
namespace app\controllers;
use Core\HomeController;
use Core\DB;
use Core\RD;
use libs\Mail;
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

        // var_dump($data);
        echo 'this is TestController';
        $mail = new Mail;
        echo $mail->send('激活邮件1','点击这里激活','l19517863@126.com');

    }

}

 ?>