<?php

if(php_sapi_name() != 'cli')
    die('使用错误');
require __DIR__.'/vendor/autoload.php';

// var_dump($argv);

if($argv[1]=='serve'){
    echo 'http://localhost:9999';
    exec("php -S localhost:9999 -t public/");
}
if($argv[1]=='index'){
    exec("php public/index.php static index");
    echo '更新完毕 http://www.my.com/index.html';
}
if($argv[1]=='contents'){
    exec("php public/index.php static contents");
    echo 'content更新完毕 http://www.my.com';
}

if($argv[1]=='q'){
    if($argv[2]=='mail')
        exec("php public/index.php queue sendmail",$data);

    if($argv[2]=='other')
        exec("php public/index.php queue sendmail",$data);
    
}




?>