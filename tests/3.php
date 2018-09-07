<?php
function otest1 ($a) 
{ 
echo( '一个参数' ); 
} 
function otest2 ( $a, $b) 
{ 
echo( '二个参数' ); 
} 
function otest3 ( $a ,$b,$c) 
{ 
echo( '三个啦' ); 
} 
function otest () 
{ 
$args = func_get_args(); 
$num = func_num_args(); 
call_user_func_array( 'otest'.$num, $args ); 
} 
otest(1,2);