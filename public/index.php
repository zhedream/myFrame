<?php
session_start();
define("ACCESS",true);// 入口标识
define('ROOT', dirname(__FILE__) . '/../');
require_once ROOT."/Core/App.php";
app::run();
?>