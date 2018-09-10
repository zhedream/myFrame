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
			$blogs = $article->allUserBlog($_SESSION['user_id']);
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
		// jj($_POST);

		if($article->store()){


			message('发布成功',1,Route('blog.index'));

		}
		
	}

	function del(){

		$article = new Article;
		$user_id = $_SESSION['user_id'];
		$id = $_POST['id'];
		// jj($_POST);
		$re = DB::findOneFirst('select Count(*) from articles where user_id=? and id=?',[$user_id,$id]);
		// dd($re);
		// jj($re);
		if($re){
			
			$a = $article->del($id);
			$article->allUserBlog($_SESSION['user_id'],true);
			message('删除成功:'.$a,1,Route('blog.index'));

		}

	}

	function edit(Request $req,$id){

		if(isset($_SESSION['email'])){
			$article = new Article;
			$blog = Article::findOne('select * from articles where user_id=? and id=?',[$_SESSION['user_id'],$id]);
			// jj($blog);
			if($blog){
				view('blog.edit',['blog'=>$blog]);
				return;
			}
			else
			echo json_encode([
				'err'=>007,
				'msg'=>'this is BlogController edit',
			]);
		}
		
		echo json_encode([
			'err'=>007,
			'msg'=>'登陆信息过期,请重新登陆'
		]);
		die;

		

	}
	function doedit(Request $req,$id){

		$article = new Article;
		$blog = Article::findOne('select * from articles where user_id=? and id=?',[$_SESSION['user_id'],$id]);
		if($blog){
			jj($req);
		}

	}

}

 ?>