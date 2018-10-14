<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Article extends Model {
    
    protected $table = 'article';
    protected $fillable = ['title','content','link','article_category_id'];

    function search(){
        $article = new self;
        if(isset($_GET['search-sort']) && is_numeric($_GET['search-sort'])){
            $article->where('article_category_id',(int)$_GET['search-sort']);
        }

        if( isset($_GET['keywords']) && $_GET['keywords']!=''){
            $keyW = $_GET['keywords'];
            
            $article->group(function($q)use($keyW){
                $q->orWhere('content','LIKE',"%$keyW%")
                ->orWhere('title','LIKE',"%$keyW%");
            });
        }

        $data = $article->leftjoin('article_category','article.article_category_id','=','article_category.id')
            ->select('article.*','article_category.cat_name')
            ->paginate(3);
        return $data;
    }

}