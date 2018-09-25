<?php

namespace app\controllers;

use app\Models\Temp;

class IndexController extends Controller {

    function index() {
        $t = new Temp;
        $info = $t->get();
        view('index',['info'=>$info]);
    }

}

?>