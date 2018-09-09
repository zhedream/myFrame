<?php 
namespace app\controllers;
use Core\HomeController;
use core\Request;
use Core\DB;
use app\Models\Test;
use app\Models\Article;
class BlogController extends HomeController{

	function index(){
		if($_SESSION['email']){
			$article = new Article;
			$blogs = $article->allUserBlog($_SESSION['id']);
			view('blog.index',[
				'blogs'=>$blogs
			]);
			// echo 'this is BLog index';

		}else{
			message('未登录',1,Route('user.login'));
		}
		
		
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

	function create(){
        view('blog.create');
	}
	
	function store(){
		$article = new Article;

		// var_dump($_POST);
		jj($_POST);

	}

}

 ?>