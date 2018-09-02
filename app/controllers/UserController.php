<?php 
namespace app\controllers;
use core\Request;
use Core\HomeController;
use Core\DB;
use app\Models\TestModel;
class UserController extends HomeController{

	function index(){
		
		$data =  ( TestModel::findOne('select * from dy_film_type'));

		$this->assign('data',$data);
		$this->assign('name','User-> index');
		$this->display('testbootsrap.html');
		
	}

	function user(Request $req,$id){
		echo "Request->".$req->test."<br>";
		echo "第一个路由参数->".$id."<br>";
	    var_dump($req->routevar);
	}
	function ab(Request $req,$id){
		// echo "AB";
		var_dump($req->routevar['id']);
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