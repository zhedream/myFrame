<?php

namespace app\controllers;

use core\Request;
use app\models\Privilege;

class PrivilegeController extends Controller {

    // 显示列表
    function index() {
        $privilege = new Privilege;
        $data = $privilege->get();
        view('privilege.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('privilege.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $privilege = new Privilege;
        $privilege->exec_insert($data);
        message('数据添加成功',1,Route('privilege.index'),3);
        // redirect(Route('privilege.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $privilege = new Privilege;
        $privilege->where($id)
            ->delete();
        message('数据删除成功',1,Route('privilege.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $privilege = new Privilege;
        $data = $privilege->where($id)->get()[0];
        view('privilege.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $privilege = new Privilege;
        $privilege->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('privilege.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>