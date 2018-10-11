<?php

namespace app\controllers;

use core\Request;
use app\models\ArticleCategory;

class ArticleCategoryController extends Controller {

    // 显示列表
    function index() {
        $articlecategory = new ArticleCategory;
        $data = $articlecategory->get();
        view('articlecategory.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('articlecategory.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $articlecategory = new ArticleCategory;
        $articlecategory->fill($data);
        $articlecategory->exec_insert($articlecategory->getFillData());
        // message('数据添加成功',1,Route('articlecategory.index'),3);
        redirect(Route('articlecategory.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $articlecategory = new ArticleCategory;
        $articlecategory->where($id)
            ->delete();
        message('数据删除成功',1,Route('articlecategory.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $articlecategory = new ArticleCategory;
        $data = $articlecategory->where($id)->get()[0];
        view('articlecategory.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $articlecategory = new ArticleCategory;
        $articlecategory->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('articlecategory.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>