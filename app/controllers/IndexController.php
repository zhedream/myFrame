<?php

namespace app\controllers;

use core\Request;
use app\models\User;

class IndexController extends Controller {

    // 显示列表
    function index() {
        
        view('index.index');
    }
    function chat(){
        view('chat.index');
    }

    function login(){

        return view('login.login');
    }

    function dologin(Request $req){
        $data = $req->all();
        $user = (new User)->get();
        dd($user);
        dd($data);
    }
    
    function regist(){
        return view('login.regist');
    }
    
    function doregist(Request $req){
        $data = $req->all();
        dd($data);
        $user = new User;

        $user;
        dd($user);
    }
    function test(){


    }

}

?>