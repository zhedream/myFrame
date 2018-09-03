<?php 
namespace app\controllers;
use Core\HomeController;
use Core\DB;
use core\RD;
use app\Models\TestModel;
class IndexController extends HomeController{

	/**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list")
     */
	function index(){
		echo "qwe";
		$redis = RD::getRD();
		$redis->setex('asdf',123,120);
		$blogs = DB::findAll('select * from mbg_articles');
		view('index',['blogs'=>$blogs]);
		
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