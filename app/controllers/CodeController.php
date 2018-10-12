<?php

namespace app\controllers;

use core\Request;
use Gregwar\Captcha\CaptchaBuilder;
use libs\Captcha;

class CodeController extends Controller {

    function getCaptcha(){
        // header('Content-type: image/jpeg');
        // $builder = new CaptchaBuilder;  
        // $builder->build();
        
        // $Captcha = $builder->getPhrase();//获取验证码字符串 小写
        // // session(['Captcha'=>$Captcha]);//保存session
        // return $builder->output();//输出图片
        // header('Content-type: image/jpeg');
        
        Captcha::img_EN(4);
        $_SESSION['Captcha'] =Captcha::$str;
        // dd($_SESSION);
    }

}

?>