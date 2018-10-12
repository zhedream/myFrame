<?php

namespace app\controllers;

use core\Request;
use app\models\Privilege;

class PrivilegeController extends Controller {

    // 显示列表
    function index() {
        $privilege = new Privilege;
        $data = $privilege->tree();
        // $data = $privilege->get();
        // dd($data);
        view('privilege.index',['data'=>$data]);
    }

    function base(){
        
        $privilege = new Privilege;
        $base = $privilege->getBasePrivilege();
        view('privilege.base',['data'=>$base]);
    }

    // 显示 添加页
    function add(){
        
        $privilege = new Privilege;
        $base = $privilege->getBasePrivilege();
        $data = $privilege->tree();
        // dd($data);
        // die;
        view('privilege.create',['privileges'=>$base,'data'=>$data]);
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        // dd($data);
        $privilege = new Privilege;
        $privilege->fill($data);
        $privilege->exec_insert($privilege->getFillData());
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