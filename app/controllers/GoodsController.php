<?php

namespace app\controllers;

use core\Request;
use app\models\Goods;

class GoodsController extends Controller {

    // 显示列表
    function index() {
        $goods = new Goods;
        $data = $goods->get();
        view('goods.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('goods.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $goods = new Goods;
        $goods->exec_insert($data);
        message('数据添加成功',1,Route('goods.index'),3);
        // redirect(Route('goods.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $goods = new Goods;
        $goods->where($id)
            ->delete();
        message('数据删除成功',1,Route('goods.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $goods = new Goods;
        $data = $goods->where($id)->get()[0];
        view('goods.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $goods = new Goods;
        $goods->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('goods.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>