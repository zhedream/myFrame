<?php

namespace app\controllers;

use Core\Controller;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\Temp;

class StaticController extends Controller {

    function index() {
        $blogs = RD::chache('index', 60, function () {
            return DB::findAll('select * from articles limit 20');
        });
        ob_start();
        view('index', ['blogs' => $blogs, '_static' => '_static']);
        $str = ob_get_contents();
        // 生成静态页
        file_put_contents(ROOT . '/public/index.html', $str);
        // 清空缓冲区
        ob_clean();
    }

    function contents() {
        $blogs = RD::chache('contents', 3600, function () {
            return DB::findAll('select * from articles');
        });
        ob_start();
        foreach ($blogs as $key => $value) {
            view('blog.content', ['blog' => $value, '_static' => '_static']);
            $str = ob_get_contents();
            file_put_contents(ROOT . '/public/content/' . $value['id'] . '.html', $str);
            ob_clean();
        }
    }

}

?>