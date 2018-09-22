<?php

namespace app\controllers;

use Core\Controller;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\Temp;
use app\Models\Heart;

class TaskController extends Controller {

    function HeartRead() {
        $H = new Heart;
        $H->readHeart();
    }

    function HeartWrite() {
        $H = new Heart;
        $data = $H->writeHeart();
        dd($data,false);
    }

}

?>