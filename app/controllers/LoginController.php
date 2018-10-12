<?php

namespace app\controllers;

use core\Request;
use app\Requests\LoginRequest;
use app\Models\Admin;

class LoginController extends Controller {

    public function index(){
        
        view('login.index');
    }

    public function login(Request $req){
        $data = $req->all();
        var_dump($data);
        $data['password'] = md5($req->password);
        $admin = new Admin;
        $admin->fill($data);
        $data = $admin->where($admin->getFillData())->get()[0];

        if($data){
            
            $_SESSION['amdin_id'] = $data['id'];
            $_SESSION['username'] = $data['username'];
            $_SESSION['authorization'] = []; // 获取 授权码
            
            redirect('/');
        }else{
            back();

        }
        // var_dump($data,$_SESSION);die;
        // dd($data,false);
    }

    public function logout(){
        
        $_SESSION['amdin_id'] = null;
        $_SESSION['username'] = null;
        $_SESSION['authorization'] = null;

        redirect('/login/index');

    }

}

?>