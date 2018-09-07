<?php

class sum{
    private static $self = null;
    private function __construct(){}
    private function __clone(){}
    public $num1;
    public $num2;

    static function new(){
        if(self::$self===null)
            self::$self = new self;
        return self::$self;
    }
    
    static function  get ($n){
        $self = self::new();
        $self->num1=$n;
        return $self;
    }
    
    public function name($n){
        $this->num2=$n;
        return $this;
    }
    
    
    public function result(){
    
    return $this->num1+$this->num2;
    
    }

    public static function __callstatic($name,$arr){

        echo "该模型".__CLASS__."不存在静态方法".$name;
        // var_dump($arr);
        // call_user_func_array(__NAMESPACE__ .'\Route::aa', $arr);
        @call_user_func_array(array(__NAMESPACE__ .'\sum',$name), $arr); 

    }

}

$res = sum::get(2)->name(3)->result();
echo $res;
die;
$sum=new sum();
$res=$sum->num1(2)->num2(3)->result();
echo $res;   //输出5


?>