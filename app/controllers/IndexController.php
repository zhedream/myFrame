<?php 
namespace app\controllers;
use Core\HomeController;
use app\Models\TestModel;
use core\RD;
class IndexController extends HomeController{

	/**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list")
     */
	function index(){
		echo "Index.php<br>";
		var_dump(TestModel::findOne('select * from mbg_articles where id=2'));
		$redis = RD::getRD();
		$redis->setex('asdf',123,120);
		$blogs = TestModel::findAll('select * from mbg_articles');
		view('index',['blogs'=>$blogs]);

		$loger = new \libs\Log('index');
		$loger->log('success阿瑟东');
		
	}
	
	function aa(){
		$data = TestModel::getUserInfo();
		$this->assign('data',$data);
		$this->display('a/a.html');
	}

	function jump(){
		$this->success_jump("home","index","index");

	}

	function testbootsrap(){
		$this->display("testbootsrap.html");
	}
}

 ?>