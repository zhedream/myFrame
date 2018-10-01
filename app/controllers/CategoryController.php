<?php

namespace app\controllers;

use core\Request;
use app\models\Category;

class CategoryController extends Controller {

    // 显示列表
    function index() {
        $category = new Category;
        $data = $category->findAll('select *,concat(path,"-",id) dpath from categorys order by dpath');
        view('category.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        $category = new Category;
        $data = $category->getAdd();
        view('category.create',['data'=>$data]);
    }

    // 添加
    function insert(Request $req,$id) {

        $type = $req->type;
        $name = $req->name;
        // jj($_POST);
        // var_dump($name,$type);die;
        // jj($data);

        $category = new Category;
        
        if($req->type=='0'){
            $category->pid = 0;
            $category->path = 0;
        }else{
            $arr = explode("#",$type);
            $category->pid = $arr[0];
            $category->path = $arr[1]."-".$arr[0];  

        }
        $category->name = $name;
        // jj($category->getFillData());
        $category->insert();
        message('数据添加成功',1,Route('category.index'),3);
        // redirect(Route('category.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $category = new Category;
        $category->where($id)
            ->delete();
        message('数据删除成功',1,Route('user.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $category = new Category;
        $data = $category->where($id)->get()[0];
        view('category.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $category = new Category;
        $category->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('category.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>