<?php


/**
 *  加载视图
 *  参数一、加载的视图的文件名
 *  参数二、向视图中传的数据
 */
function view($viewFileName, $data = [])
{
    // 解压数组成变量
    // ob_clean();
    extract($data);
    // var_dump($blogs);
    // var_dump($_static);
    $path = str_replace('.', '/', $viewFileName) . '.html';
    // 加载视图
    require(ROOT . 'views/' . $path);
}



/**
 *  获取当前 URL 上所有的参数，并且还能排除掉某些参数
 *  参数：要排除的变量
 */
function getUrlParams($except = [])
{
    // ['odby','odway']
    // 循环删除变量
    foreach($except as $v)
    {
        unset($_GET[$v]);
    }

    $str = '';
    foreach($_GET as $k => $v)
    {
        $str .= "$k=$v&";
    }

    return $str;

}
/**
 * 
 * php 跳转
 */
function redirect($url)
{
    header('Location:' . $url);
    // exit;
}

/**
 * 返回上一个页面
 */
function back()
{
    redirect( $_SERVER['HTTP_REFERER'] );
}

/**
 * 提示消息的函数
 * type 0:alert   
 * 1. 消息 
 * 2. 类型
 * 3. 地址
 * 4. 跳转时间 type 1 使用
 */
function message($message, $type, $url, $seconds = 5)
{
    if($type == 0)
    {
        echo "<script>alert('{$message}');location.href='{$url}';</script>";
        exit;

    }
    else if($type == 1)
    {
        // 加载消息页面
        ob_clean();
        view('common.success', [
            'message' => $message,
            'url' => $url,
            'seconds' => $seconds
        ]);
    }
    else if($type==2)
    {
        // 把消息保存到 SESSION
        $_SESSION['_MESS_'] = $message;
        // 跳转到下一个页面
        redirect($url);
    }
}

function getChar($num)  // $num为生成汉字的数量
    {
        $b = '';
        for ($i=0; $i<$num; $i++) 
        {
            // 使用chr()函数拼接双字节汉字，前一个chr()为高位字节，后一个为低位字节
            $a = chr(mt_rand(0xB0,0xD0)).chr(mt_rand(0xA1, 0xF0));
            // 转码
            $b .= iconv('GB2312', 'UTF-8', $a);
        }
        return $b;
    }

/**
 * 获取当前路由 名称
 */
function routeName(){
    return core\Route::$routeName;
}

/**
 * 生产url
 * 1. 路由名称
 * 2. 路由参数
 */
function Route($name,$data = [],$full = false){
    
    $router =  core\Route::new();
    return $router->makeUrl($name,$data,$full);

}

/**
 * 过滤XSS（在线编辑器填写的内容不能使用该函数过滤）
 * 1. 过滤内容
 */
function e($content)
{
    return htmlspecialchars($content);
}

/**
 *  使用 htmlpurifer 选择过滤(性能慢只用于富文本)
 * 1. 过滤内容
 */
function hpe($content)
{
    // 一直保存在内存中(直到脚本执行结束)
    static $purifier = null;
    if($purifier === null)
    {
        $config = \HTMLPurifier_Config::createDefault();
        $config->set('Core.Encoding', 'utf-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        $config->set('Cache.SerializerPath', ROOT.'cache');
        $config->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,ol[start],li,p[style],br,span[style],img[width|height|alt|src],*[style|class],pre,hr,code,h2,h3,h4,h5,h6,blockquote,del,table,thead,tbody,tr,th,td');
        $config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,margin,width,height,font-family,text-decoration,padding-left,color,background-color,text-align');
        $config->set('AutoFormat.AutoParagraph', TRUE);
        $config->set('AutoFormat.RemoveEmpty', TRUE);
        $purifier = new \HTMLPurifier($config);
    }
    return $purifier->purify($content);
}

function csrf()
{
    if(!isset($_SESSION['_token']))
    {
        // 生成一个随机的字符串
        $_token = md5( rand(1,99999) . microtime() );
        $_SESSION['_token'] = $_token;
    }
    return $_SESSION['_token'];
}

// 生成令牌隐藏域
function csrf_field()
{
    $csrf = isset($_SESSION['_token']) ? $_SESSION['_token'] : csrf();
    echo "<input type='hidden' name='_token' value='{$csrf}'>";
}

/**
 * 抛出 异常
 */
function Exception($str){

    $callinfo = debug_backtrace()[0];
    $file = $callinfo['file'];
    $line = $callinfo['line'];
    try{
        throw new \Exception($str,0); // 处理错误信息 的 对象
    }catch(\Exception $e){
        echo "<hr>出错文件:&nbsp".$file."<hr>";
        echo "错误信息:&nbsp".$e->getMessage()."<hr>";
        echo "错误行号:&nbsp".$line."<hr>";
        die;
    }
}

function jj($data,$option = true){
    ob_clean();
    $callinfo = debug_backtrace()[0];
    $file = $callinfo['file'];
    $line = $callinfo['line'];
    $data['callinfo'] = ['file'=>$file,'line'=>$line];
    // array_unshift($data,$aa);

    if($option)
        echo json_encode($data,true);
    else
        echo json_encode($data);
    
    die;

}


function dd($data,$option = true){
    ob_clean();
    var_dump($data);
    die;

}






?>