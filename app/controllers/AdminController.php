<?php

namespace app\controllers;

use core\Request;
use app\models\Admin;

class AdminController extends Controller {

    // 显示列表
    function index() {
        $admin = new Admin;
        $data = $admin->get();
        view('admin.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('admin.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $admin = new Admin;
        $admin->exec_insert($data);
        message('数据添加成功',1,Route('admin.index'),3);
        // redirect(Route('admin.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $admin = new Admin;
        $admin->where($id)
            ->delete();
        message('数据删除成功',1,Route('admin.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $admin = new Admin;
        $data = $admin->where($id)->get()[0];
        view('admin.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $admin = new Admin;
        $admin->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('admin.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>