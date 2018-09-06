<?php 
namespace app\controllers;
use Core\HomeController;
use core\Request;
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
        var_dump( DB::findOne("select * from mbg_articles where id=?",[2]));
    }

    function mail($data){

        // var_dump($data);
        echo 'this is TestController';
        $mail = new Mail;
        echo $mail->send('激活邮件1','点击这里激活','l19517863@126.com');

    }

    function user(Request $req,$id){
		echo "Request->".$req->test."<br>";
		echo "第一个路由参数->".$id."<br>";
	    var_dump($req->routevar);
    }
    
    function aa(){
		$data = TestModel::getUserInfo();
		$this->assign('data',$data);
		$this->display('a/a.html');
	}

    function content2html(){
        echo 'content2html<br>';
        $blogs = DB::findAll('select * from mbg_articles');
        // var_dump($blogs);
        // die();
        ob_start();
        foreach ($blogs as $key => $value) {
            $this->assign('blog',$value);
            $this->display('blog/content.html');

            $str = ob_get_contents();
            // 生成静态页
            file_put_contents(ROOT.'/public/content/'.$value['id'].'.html', $str);
            // 清空缓冲区
            ob_clean();
        }

    }
    function index2html(){

        $blogs = DB::findAll('select * from mbg_articles');
        ob_start();
        
        // $this->assign('blogs',$blogs);
        // $this->display('index.html');

        view('index',['blogs'=>$blogs]);
        $str = ob_get_contents();
        // 生成静态页
        file_put_contents(ROOT.'/public/index.html', $str);
        // 清空缓冲区
        ob_clean();

    }

    function a(){
        echo 'asdf';
    }

}

 ?>