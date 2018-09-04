<?php 
namespace app\controllers;
use Core\HomeController;
use app\Models\TestModel;
use core\Request;
use Core\DB;
class UserController extends HomeController{

	function index(){
		
		$data =  ( TestModel::findOne('select * from mbg_articles'));

		$this->assign('data',$data);
		$this->assign('name','User-> index');
		$this->display('testbootsrap.html');
		
	}

}

 ?>