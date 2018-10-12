<?php

namespace app\models;

use core\RD; // redis 类
use core\DB; // DB 类

class User extends Model {
    
    protected $table = 'users';
    protected $fillable = ['phone','email','name','password'];


}