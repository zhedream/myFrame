<?php 
namespace app\controllers;
use Core\HomeController;
use core\Request;
use Core\DB;
use app\Models\Test;
use app\Models\Article;
class BlogController extends HomeController{

	function index(){

		echo 'this is BLog index';
		
	}


	function get(Request $req,$id){
		var_dump( Article::get($id));

	}

	function increase(Request $req,$id){
		$article = new Article;
		echo json_encode([
			'display'=>$article->increase($id),
			'email'=>$_SESSION['email'],
		]);

	}

	function jump(){
		$this->success_jump("home","index","index");
	}

}

 ?>