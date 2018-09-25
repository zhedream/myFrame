<?php

namespace app\Models;

use core\RD; // redis 类
use core\DB; // DB 类

class Temp extends Model {

    function get() {
        return 'Welcome To MyFrame';
    }
}