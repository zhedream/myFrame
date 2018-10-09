<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class AdminRole extends Model {
    
    protected $table = 'admin_role';
    protected $fillable = ['role_id','admin_id'];


}