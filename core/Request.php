<?php

namespace core;

use core\Route;

class Request {


    public $routevar = [];
    public $posts;
    public $gets;

    public $test = "这是Request 测试变量";

    function __construct($path, $matches2) {
        $this->gets = $_GET;
        $this->posts = $_POST;

        preg_match_all('/\{(.*)\}/U', $path['url'], $matches);
        foreach ($matches[1] as $key => $value) {
            $this->routevar[$value] = $matches2[$key + 1];
        }
    }

    function get($key) {

    }

    function all() {
        // dd(Route::$method);
        if (Route::$method == 'POST') {
            $data = $this->posts;
            unset($data['_token']);
            return ($data);
        } else if (Route::$method == 'GET')
            return ($this->gets);
    }


}


?>