<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Article extends Model {
    
    protected $table = 'article';
    protected $fillable = ['title','content','link','article_category_id'];


}