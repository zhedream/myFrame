<?php

namespace libs;


/**
 * 代码生成器
 */
class Make {

    public $isView = false;
    public $group = false;

    public $cspace = null; // 控制器 命名空间
    public $mspace = null; // 模型 命名空间

    public $cname = null; // 控制器名 小写
    public $mname = null; // 模型名 小写
    public $cFname = null; // 控制器名 大写
    public $mFname = null; // 模型名 大写

    public $cdir = null; // 控制器 路径
    public $mdir = null; // 模型 路径

    public $fields = []; // 表 字段
    
    function controller($name) {
        // dd($name);
        list($namespace,$fileName) = $this->parsePath($name);
        $this->cspace = $namespace;

        $name = strtolower($fileName);
        $this->cname = $name;
        $this->cFname = $fileName;

        $dir = ROOT.$namespace;
        is_dir($dir) OR mkdir($dir, 0777, true);
        
        if(file_exists(ROOT.$namespace.'/'.$fileName.'Controller.php')){
            echo '存在'.$fileName.'Controller.php';
            return $this;
        }

        ob_start();
        include(ROOT . 'templates/TempController.php');
        $str = ob_get_clean();
        file_put_contents(ROOT.$namespace.'/'.$fileName.'Controller.php', "<?php\r\n".$str);
        $this->cdir = ROOT.$namespace.'/'.$fileName.'Controller.php';
        return $this;
    }

    function model($name) {

        list($namespace,$fileName) = $this->parsePath($name);
        $this->mspace = $namespace;

        $name = strtolower($fileName);
        $this->mname = $name; // 小写
        $this->mFname = $fileName; // 大写

        $dir = ROOT.$namespace;
        is_dir($dir) OR mkdir($dir, 0777, true);

        if(file_exists(ROOT.$namespace.'/'.$fileName.'.php')){
            echo '存在'.$fileName.'.php';
            return $this;
        }

        ob_start();
        include(ROOT . 'templates/Temp.php');
        $str = ob_get_clean();
        file_put_contents(ROOT.$namespace.'/'.$fileName.'.php', "<?php\r\n".$str);
        $this->mdir = ROOT.$namespace.'/'.$fileName.'.php';
        return $this;
    }

    function view($name) {

        is_dir(ROOT . 'views/'.$name) OR mkdir(ROOT . 'views/'.$name, 0777);
        // create.html
        ob_start();
        include(ROOT . 'templates/create.html');
        $str = ob_get_clean();
        if(file_exists(ROOT.'views/'.$name.'/create.html'))
            echo '存在'.$name.'/create.html';
        else
            file_put_contents(ROOT.'views/'.$name.'/create.html', $str);
        // edit.html
        ob_start();
        include(ROOT . 'templates/edit.html');
        $str = ob_get_clean();
        if(file_exists(ROOT.'views/'.$name.'/edit.html'))
            echo '存在'.$name.'/edit.html';
        else
            file_put_contents(ROOT.'views/'.$name.'/edit.html', $str);
        // index.html
        ob_start();
        include(ROOT . 'templates/index.html');
        $str = ob_get_clean();
        if(file_exists(ROOT.'views/'.$name.'/index.html'))
            echo ('存在'.$name.'/index.html');
        else
            file_put_contents(ROOT.'views/'.$name.'/index.html', $str);
    }

    function group($name) {
        $this->group = true;
        $this->model($name);
        $this->controller($this->mFname);
        $this->view($this->mname);

    }

    /**
     * 解析 命名空间 文件名
     */
    function parsePath($name){
        $mode =  debug_backtrace()[1]['function'];
        // dd($mode);
        $namespace = "app\\".$mode."s";
        
        if(preg_match('/\//',$name)){
            // 存在 命名空间
            $name = preg_replace('/\//','\\',$name);
            $name = $namespace."\\".$name;
            $index = strrpos($name,'\\');
            $namespace = substr($name,0,$index);
            $fileName = substr($name,$index+1);
            // dd($fileName);

        }else{

            $fileName = $name;
        }
        return [$namespace,$fileName];
    }

}