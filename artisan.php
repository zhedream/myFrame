<?php

if(php_sapi_name() != 'cli')
    die('使用错误');
require __DIR__.'/vendor/autoload.php';
var_dump($argv);
die;
exec("mkdir $argv[1]");




?>