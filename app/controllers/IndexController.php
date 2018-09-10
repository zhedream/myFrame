<?php 
namespace app\controllers;
use Core\HomeController;
use app\Models\Test;
use core\RD;
class IndexController extends HomeController{

	/**
     * Matches /blog exactly
     *
     * @Route("/blog", name="blog_list")
     */
	function index(){
		echo "Index.php<br>";
		$blogs = RD::chache('index',3600,function(){
            return Test::findAll('select * from articles limit 20');
        });
		
		view('index',['blogs'=>$blogs]);
	}
	
	function jump(){
		$this->success_jump("home","index","index");

	}

}

 ?>