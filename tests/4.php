<?php
namespace test;
Class ClassA 
{ 
     function get($a){
        var_dump($a);
        return new self;
        // return $this;
    }

     function name($a){
        echo 'name'.$a;
        return 'OVER';
    }

    public static function __callstatic($name,$arr){

        echo "该模型".__CLASS__."不存在静态方法".$name;
        // var_dump($arr);
        // call_user_func_array(__NAMESPACE__ .'\Route::aa', $arr);
        @call_user_func_array(array(__NAMESPACE__ .'\ClassA',$name), $arr); 

    }
} 

$user = [
    'name'=>'lhz',
    'age'=>18,
];
ClassA::get($user)->name('user');

die;
$a = new ClassA;

$a->get('asdf');