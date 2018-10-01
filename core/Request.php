<?php

namespace core;

use core\Route;

Request::run();

class Request {

    protected static $rawData;
    protected static $routeVar = [];
    protected static $posts = [];
    protected static $gets = [];

    public $test = "这是Request 测试变量";

    function __construct() {
        $this->_before_construct();

        // throwE('qwe');
        $a = self::getRawData();

        // dd(self::$routeVar);
        $this->_after_construct();
    }

    /**
     * @return mixed
     */
    public static function getRawData() {
        if (self::$rawData)
            return self::$rawData;
        else {

            self::$rawData = file_get_contents('php://input');
            return self::$rawData;
        }
    }

    public static function run() {
        self::getRouteVar();
        self::getRawData();
    }



    // 钩子 函数
    protected function _before_all() {
    }

    protected function _after_call() {
    }

    protected function _before_construct() {
    }

    protected function _after_construct() {
    }

    function all() {
        $this->_before_all();
        // dd(Route::$method);
        if (Route::$method == 'POST') {
            $posts = self::$posts;
            $gets = self::$gets;
            $all = array_merge_recursive($gets, $posts);
            // dd($all);
            return ($all);
        } else if (Route::$method == 'GET')
            return (self::$gets);

        $this->_after_all();
    }

    public static function getRouteVar() {

        if (self::$routeVar)
            return self::$routeVar;
        else {
            $path = Route::$currentRouteInfo;
            $matches2 = Route::$currentRouteVar;
            self::$gets = $_GET;
            self::$posts = $_POST;
            preg_match_all('/\{(.*)\}/U', $path['url'], $matches);
            foreach ($matches[1] as $key => $value) {
                self::$routeVar[$value] = $matches2[$key + 1];
            }
            return self::$routeVar;
        }

    }


    public function __get($name) {

        if (Route::$method == 'POST') {

            if (self::$posts[$name])
                return self::$posts[$name];
            else if (self::$gets[$name])
                return (self::$gets[$name]);

        } else if (Route::$method == 'GET') {

            if (self::$gets[$name])
                return self::$gets[$name];
        }
    }



    /**
     * @return array
     */
    public static function getPosts() {
        return self::$posts;
    }

    /**
     * @return array
     */
    public static function getGets() {
        return self::$gets;
    }


}


?>