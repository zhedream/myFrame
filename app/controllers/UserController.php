<?php

namespace app\controllers;

use core\Request;
use app\Requests\UserRequest;
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
        $user->exec_insert($data);
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
    function update(UserRequest $req,$id) {
        // dd($req);
        $data = $req->all();
        var_dump($data,$id);
        // die;
        // $user = new User;
        // $user->where($id)
        //     ->fill($data)
        //     ->update();
        // message('数据更改成功',1,Route('user.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>