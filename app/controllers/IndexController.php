<?php

namespace app\controllers;

use core\Request;

use app\models\User;
class IndexController extends Controller {

    // 显示列表
    function index() {
        
        view('index',['info'=>'welcome to myFrame']);
    }
    function chat(){
        
        view('chat.index');
    }

    function user(){
        
        $u = new User;
        $data = $u->get();
        dd($data);
    }

}

?>