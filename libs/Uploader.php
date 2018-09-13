<?php

namespace libs;

//Uploader::new();

class Uploader {


    private static $instance = null; // 实例化单例 对象

    private function __construct() {
        $this->_ext = $GLOBALS['config']['upload']['allow_suffix'];
    }

    /**
     * @return mixed
     */
    public function getExt() {
        return $this->_ext;
    }

    private function __clone() {
    }

    /**
     * @return Uploader|null
     */
    public static function new() {
        if (self::$instance == null) {
            self::$instance = new self();
            return self::$instance;
        }
        return self::$instance;
    }

    private $_root = UPLOAD_PATH;
    private $_ext;


}


