<?php 
namespace app\controllers;
use Core\HomeController;
use core\Request;
use Core\DB;
use app\Models\Test;
use app\Models\Article;
class BlogController extends HomeController{

	function index(){
		
		$data =  ( Test::findOne('select * from dy_film_type'));

		$this->assign('data',$data);
		$this->assign('name','这里是BlogController');
		$this->display('testbootsrap.html');
		
	}

	function dis(Request $req,$id){
		$article = new Article;
		$article->increase($id);

	}

	function jump(){
		$this->success_jump("home","index","index");

	}

}

 ?>