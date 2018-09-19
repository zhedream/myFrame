<?php

namespace core;


class Response {

    private static $_instance = null; // 实例化单例 对象

    private function __construct() {}
    private function __clone() {}

    public static function new() {
        if (self::$_instance == null) {
            self::$_instance = new self();
            return self::$_instance;
        }
        return self::$_instance;
    }

    function download($filePath,$fileName) {
        // 告诉浏览器这是一个二进程文件流
        Header("Content-Type: application/octet-stream");
        // 请求范围的度量单位
        Header("Accept-Ranges: bytes");
        // 告诉浏览器文件尺寸
        Header("Accept-Length: " . filesize($filePath));
        // 开始下载，下载时的文件名
        Header("Content-Disposition: attachment; filename=" . $fileName);

        // 读取服务器上的一个文件并以文件流的形式输出给浏览器
        readfile($filePath);
    }


}


?>