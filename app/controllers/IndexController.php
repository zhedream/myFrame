<?php 
namespace app\controllers;
use Core\HomeController;
use Core\DB;
use app\Models\TestModel;
class IndexController extends HomeController{


	function index(){
		
		$data =  ( TestModel::findOne('select * from dy_film_type'));

		$this->assign('data',$data);
		$this->assign('name','刘浩哲');
		$this->display('testbootsrap.html');

	}

	function jump(){
		$this->success_jump("home","index","index");

	}

	function testbootsrap(){
		$this->display("testbootsrap.html");
	}
}

 ?>