<?php


/**
 *  加载视图
 *  参数一、加载的视图的文件名
 *  参数二、向视图中传的数据
 */
function view($viewFileName, $data = [])
{
    // 解压数组成变量
    extract($data);
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
    exit;
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
 * type 0:alert   1:显示单独的消息页面  2：在下一个页面显示
 * 说明：$seconds 只有在 type=1时有效，代码几秒自动跳动
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







?>