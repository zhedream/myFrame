<?php

namespace app\controllers;

use core\Request;

class IndexController extends Controller {

    // 显示列表
    function index() {
        
        view('index.index');
    }
    function chat(){
        
        view('chat.index');
    }

    // 显示 添加页
    function add(){
        
        view('index.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $index = new Index;
        $index->fill($data);
        $index->exec_insert($index->getFillData());
        message('数据添加成功',1,Route('index.index'),3);
        // redirect(Route('index.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $index = new Index;
        $index->where($id)
            ->delete();
        message('数据删除成功',1,Route('index.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $index = new Index;
        $data = $index->where($id)->get()[0];
        view('index.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $index = new Index;
        $index->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('index.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>