<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Privilege extends Model {
    
    protected $table = 'privilege';
    protected $fillable = ['pri_name','url_path','parent_id'];


}