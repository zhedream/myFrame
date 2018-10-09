<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Goods extends Model {
    
    protected $table = 'goods';
    protected $fillable = ['goods_name','logo','is_on_sale','description','cat1_id','cat2_id','cat3_id','brand_id'];


}