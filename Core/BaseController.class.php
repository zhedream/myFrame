<?php

namespace Core;

class BaseController{

    public $smarty;

    function __construct(){
        $this->smarty = new \smarty;
        $this->smarty->template_dir = APP_PATH.PLAT."\/View/".CONTROLLER."/";
        $this->smarty->compile_dir = APP_PATH.PLAT."\/View_c/";
        $this->smarty->caching = false;
        $this->smarty->cache_dir = APP_PATH.PLAT."\/Cache/";
        $this->smarty->left_delimiter = "<{";
        $this->smarty->right_delimiter = "}>";
    }

    function assign($name,$data){
        $this->smarty->assign($name,$data);
    }
    function display($name){
        $this->smarty->display($name);
    }
    public function __call($name,$arr){

        echo "控制器".__CLASS__."不存在方法".$name.lm;

    }
    public static function __callstatic($name,$arr){

        echo "控制器".__CLASS__."不存在静态方法".$name.lm;

    }
}









?>