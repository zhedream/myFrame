<?php


// return array(
//     "type"=>"mysql",
//     "host"=>"localhost",
//     "port"=>"3306",
//     "charset"=>"utf8",
//     "dbname"=>"myframe",
//     "user"=>"root",
//     "pwd"=>"123qwe"
// );

return array(
    //    key    value
    'mode'=> env('mode','dev'),
    'APP_URL' => env('APP_URL','http://lhz.ngrok.xiaomiqiu.cn'),
    'db' => array(
        'type' => "mysql",
        'host' => '127.0.0.1',    //数据服务器主机名（IP、域名）,localhost 本机的特殊的域名
        'port' => 3306,           //Web端口默认为 80  MySQL服务器的默认端口 3306
        'user' => "root",         //数据库用户名
        'pwd' => '',          //数据密码
        'dbname' => 'blog',  //数据库名称
        'charset' => 'utf8',      //数据库的默认编码
        'prefix' => ''        //数据表前缀
    ),
    'redis' => array(
        'scheme' => 'tcp',
        'host' => '127.0.0.1',
        'port' => 6379,
    ),
    'email' => array(
        'host' => 'smtp.163.com', // 服务器地址
        'port' => 25, // 端口
        'name' => '者之梦(管理员)', // nick name
        'username' => 'l19517863@163.com', // 邮箱账户
        'password' => 'l18396315377', // 账户密码 或 授权码
    ),
    'upload' => array(
        //设置文件上传允许的后缀1
        'allow_suffix' => ['jpg', 'jpeg', 'gif', 'png', 'bmp'],
        'upload_dir' => UPLOAD_PATH,
        'water_img' => PUBLIC_PATH . 'logo.png'
    ),
    'pageSize' => array(

        'admin_pageSize' => 2, /* 前台 */
        'home_pageSize' => 2 /* 后台 */


    )
);


?>