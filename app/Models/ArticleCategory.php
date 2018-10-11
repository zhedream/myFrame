<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class ArticleCategory extends Model {
    
    protected $table = 'article_category';
    protected $fillable = ['cat_name'];


}