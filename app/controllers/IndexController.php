<?php

namespace app\controllers;

use core\Request;

class IndexController extends Controller {

    // 显示列表
    function index() {

        view('index',['info'=>'welcome to myFrame']);
    }

}

?>