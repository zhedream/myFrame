<?php

namespace app\controllers;

use core\Request;
use app\models\User;

class UserController extends Controller {

    // 显示列表
    function index() {
        $user = new User;
        $data = $user->get();
        view('user.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('user.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $user = new User;
        $user->fill($data);
        $user->exec_insert($user->getFillData());
        message('数据添加成功',1,Route('user.index'),3);
        // redirect(Route('user.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $user = new User;
        $user->where($id)
            ->delete();
        message('数据删除成功',1,Route('user.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $user = new User;
        $data = $user->where($id)->get()[0];
        view('user.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $user = new User;
        $user->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('user.index'),3);
        
    }

    function login(){
        view('user.login');
    }

    function dologin(Request $req){
        $data = $req->all();
        // dd($data);
        $user = new User;
        $data = $user->where('email',$req->email)
        ->where('password',$req->password)
        ->get()[0];
        if($data){
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['name'] = $data['name'];

            message('登陆成功',1,'/index/index',2);
            return ;
        }
        message('密码错误',1,'/user/login',2);
    }

    function reg(){
        view('user.register');
    }

    function doreg(Request $req){
        $data = $req->all();
        // dd($data);
        if($data['code']==$_SESSION['Captcha']){
            
            $user = new User;
            $user->fill($data);
            $user->exec_insert($user->getFillData());
            message('注册成功',1,'/user/login',3);
        }else{
                    
            message('验证码错误',1,'/user/reg',3);
            var_dump($data,$_SESSION);die;
        }

      

    }
}

?>