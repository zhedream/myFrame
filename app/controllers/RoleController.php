<?php

namespace app\controllers;

use core\Request;
use app\models\Role;

class RoleController extends Controller {

    // 显示列表
    function index() {
        $role = new Role;
        $data = $role->get();
        view('role.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('role.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $role = new Role;
        $role->exec_insert($data);
        message('数据添加成功',1,Route('role.index'),3);
        // redirect(Route('role.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $role = new Role;
        $role->where($id)
            ->delete();
        message('数据删除成功',1,Route('role.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $role = new Role;
        $data = $role->where($id)->get()[0];
        view('role.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $role = new Role;
        $role->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('role.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>