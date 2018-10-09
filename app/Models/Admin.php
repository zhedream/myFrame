<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Admin extends Model {
    
    protected $table = 'admin';
    protected $fillable = ['username','password'];


}