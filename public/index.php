<?php
session_start();
define("ACCESS",true);// 入口标识
define('ROOT', dirname(__FILE__) . '/../');
require_once ROOT."/Core/App.php";
require_once ROOT."/Core/corefn.php"; // 核心辅助函数
require_once ROOT."/route/web.php";
app::run();
?>