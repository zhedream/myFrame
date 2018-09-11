<?php

/**
 *  测试 调用 非静态 继承 函数
 * 
 *  可以调用 有警告
 * 
 *  ca
 * 
 * 
 */
class A{

    function aa(){

        echo 'this is a';
    }

    private function bb(){
        echo 'this is b';
    }

    // 禁止重写 cc 方法
    final function cc(){
        echo 'this is c';
    }
}

class B extends A{


    // function aa(){
    //     echo 'this is aa';
    // }

    static function __callStatic($name,$pa){
        // echo $name;die;
    }

    function cc(){
        echo 'this is cc';
    }
}

$a = new B;

B::aa();
B::bb();







?>