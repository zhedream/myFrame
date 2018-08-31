<?php 
namespace app\controllers;
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