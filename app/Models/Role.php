<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class Role extends Model {
    
    protected $table = 'role';
    protected $fillable = ['role_name'];


}