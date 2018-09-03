<?php

if(php_sapi_name() != 'cli')
    die('使用错误');
require __DIR__.'/vendor/autoload.php';
var_dump($argv);

if($argv[1]=='serve'){
    echo 'http://localhost:9999';
    exec("php -S localhost:9999 -t public/");
}




?>