<?php

namespace app\controllers;

use core\Request;
use app\models\Article;
use app\models\ArticleCategory;
use app\models\User;

class ArticleController extends Controller {

    // 显示列表
    function index() {
        // dd($_SERVER);
        $user = new User;
        $data = $user->paginate(2);
        dd($data);

        $article = new Article;
        if(isset($_GET['search-sort']) && is_numeric($_GET['search-sort'])){
            $article->where('article_category_id',(int)$_GET['search-sort']);
        }

        
        
        $data = $article->leftjoin('article_category','article.article_category_id','=','article_category.id')
            // ->get();
            ->paginate(2);
        dd($data);
        $articleCategory = new ArticleCategory;
        $categories = $articleCategory->get();
        // dd($categories);
        view('article.index',['data'=>$data['data'],'categories'=>$categories]);
    }

    // 显示 添加页
    function add(){
        
        view('article.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $article = new Article;
        $article->fill($data);
        $article->exec_insert($article->getFillData());
        message('数据添加成功',1,Route('article.index'),3);
        // redirect(Route('article.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $article = new Article;
        $article->where($id)
            ->delete();
        message('数据删除成功',1,Route('article.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $article = new Article;
        $data = $article->where($id)->get()[0];
        view('article.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $article = new Article;
        $article->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('article.index'),3);
        
    }

    // 搜索
    function search(Request $req,$id){
    }

}

?>