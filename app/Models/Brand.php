<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Brand extends Model {
    
    protected $table = 'brands';
    protected $fillable = ['brand_name','logo'];


}