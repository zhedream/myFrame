<?php

if(php_sapi_name() != 'cli')
    die('使用错误');
require __DIR__.'/vendor/autoload.php';

// var_dump($argv);

if($argv[1]=='serve'){
    echo 'http://localhost:9999';
    exec("php -S localhost:9999 -t public/");
}
if($argv[1]=='index2html'){
    exec("php public/index.php test index2html");
    echo '更新完毕 http://www.my.com/index.html';
}
if($argv[1]=='content2html'){
    system("php public/index.php test content2html");
    echo 'content更新完毕 http://www.my.com';
}

if($argv[1]=='aa'){
    
    // if($argv[2]=='sendmail'){
        system('dir');
        // var_dump( exec("mkdir aa"));
        // echo '开启邮件进程';
    // }
}




?>