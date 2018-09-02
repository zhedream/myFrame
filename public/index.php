<?php
session_start();
define("ACCESS",true);// 入口标识
define('ROOT', dirname(__FILE__) . '/../');
define("lm","<br>"); // <br>
require_once ROOT."/Core/App.php"; // 核心APP 入口
require_once ROOT."/Core/corefn.php"; // 核心辅助全局函数
require_once ROOT."/route/web.php"; // 引入路由
app::run();
?>