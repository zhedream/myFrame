<?php
ini_set('date.timezone', 'PRC');
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://127.0.0.1:6379?database=3');
session_start();
define("ACCESS", true);// 入口标识
define('ROOT', dirname(__FILE__) . '/../'); // 根目录
define("lm", "<br>"); // <br>
require_once ROOT . "/Core/App.php"; // 核心APP 入口
require_once ROOT . "/Core/CoreFn.php"; // 核心辅助全局函数
require_once ROOT . "/route/web.php"; // 引入路由
//var_dump(ROOT . "/route/web.php");die();
app::run(isset($argv) ? $argv : []);
