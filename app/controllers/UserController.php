<?php 
namespace app\controllers;
use Core\HomeController;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\User;
class UserController extends HomeController{

	function regist(Request $req,$id){
		
		echo 'this is UserController regist';
		view('user.regist');

	}

	function doregist(Request $req,$id){
		$email = $_POST['email'];
		$password = 123123;
		$code = md5($email+rand(10000,99999));
		
		User::store($email,$password,$code);

	}

	function active(Request $req,$id){
		echo date("Y-m-d H:i:s");
		echo '激活成功'.$_GET['code'];
		var_dump( RD::getTimeOut('userActive',$_GET['code'],true));
	}

	function login(Request $req,$id){
		echo 'this is UserController login';
		view('user.login');

	}

	function dologin(Request $req,$id){
		echo 'this is UserController dologin';
	
	}

}

 ?>