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
        $user = (new User)->where(['uname'=>$req->uname,'password'=>$req->password])->first();
        // dd($user);
        if($user){
            $_SESSION['uid'] = $user['uid'];
            $_SESSION['uname'] = $user['uname'];
            message('登陆成功',1,Route('index.chat'),2);
        }else{
            return back();
        }
    }
    
    function regist(){
        return view('login.regist');
    }
    
    function doregist(Request $req){
        $data = $req->all();
        $user = new User;
        $a = $user->where('uname',$req->uname)->first();
        if(!$a){
            $user->fill($data);
            $user->tel_num = '';
            $user->reg_time = date('Y-m-d G:i:s');
            $user->insert();
            message('注册成功',1,Route('index.login'),2);
        }else{
            return back();
        }
        
    }
    function test(){


    }

}

?>