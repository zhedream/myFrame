<?php
session_start();
define("ACCESS",true);// 入口标识
require_once "./Core/App.class.php";
app::run();
?>