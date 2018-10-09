<?php

namespace app\controllers;

use core\Request;
use app\models\Brand;

class BrandController extends Controller {

    // 显示列表
    function index() {
        $brand = new Brand;
        $data = $brand->get();
        view('brand.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('brand.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $brand = new Brand;
        $brand->exec_insert($data);
        message('数据添加成功',1,Route('brand.index'),3);
        // redirect(Route('brand.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $brand = new Brand;
        $brand->where($id)
            ->delete();
        message('数据删除成功',1,Route('brand.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $brand = new Brand;
        $data = $brand->where($id)->get()[0];
        view('brand.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $brand = new Brand;
        $brand->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('brand.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>