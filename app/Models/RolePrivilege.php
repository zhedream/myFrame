<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class RolePrivilege extends Model {
    
    protected $table = 'role_privilege';
    protected $fillable = ['pri_id','role_id'];


}