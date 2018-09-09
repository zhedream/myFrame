<?php 
namespace app\controllers;
use Core\Controller;
use core\Request;
use Core\DB;
use app\Models\Test;
class MockController extends Controller{

	public function users()
    {
        // 20个账号

        for($i=0;$i<20;$i++)
        {
            $email = rand(50000,99999999999).'@126.com';
            $password = md5('123123');
            $name = getChar(2);
            DB::exec("INSERT INTO mbg_authors (email,name,password) VALUES(?,?,?)",[$email,$name,$password]);
        }
    }

    public function blog()
    {

        // 清空表，并且重置 ID

        for($i=0;$i<300;$i++)
        {
            $title = getChar( rand(20,100) ) ;
            $description = getChar( rand(20,100) ) ;
            $content = getChar( rand(100,600) );
            $display = rand(10,500);

            $accessable = ['public','private'];
            $random_keys=array_rand($accessable,1);
            $accessable = $accessable[$random_keys];

            $type = rand(1,11);
            $date = rand(1233333399,1535592288);
            $date = date('Y-m-d H:i:s', $date);
            $user_id = rand(1,20);
            DB::exec("INSERT INTO mbg_articles (title,`description`,content,display,accessable,type,created_at,user_id) VALUES(?,?,?,?,?,?,?,? )"
                ,[$title,$description,$content,$display,$accessable,$type,$date,$user_id]);

        }
    }

}

 ?>