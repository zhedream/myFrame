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
		'db'=>array(
            'type'=>"mysql",
            'host'=>'localhost',    //数据服务器主机名（IP、域名）,localhost 本机的特殊的域名
            'port'=>3306,           //Web端口默认为 80  MySQL服务器的默认端口 3306
            'user'=>"root",         //数据库用户名
            'pwd'=>'',          //数据密码
            'dbname'=>'dytt',  //数据库名称
            'charset'=>'utf8',      //数据库的默认编码
            'prefix'=>'dy_'        //数据表前缀
		),
		'upload'=>array(
				//设置文件上传允许的后缀
				'allow_suffix'=>['jpg','jpeg','gif','png','bmp'],
				'upload_dir'=>UPLOAD_PATH,
				'water_img'=>PUBLIC_PATH.'logo.png'
		),
		'pageSize'=>array(

			'admin_pagesize'=>2, /* 前台 */
			'home_pagesize'=>2 /* 后台 */


		)
	);






?>