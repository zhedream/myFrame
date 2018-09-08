<?php
class A{
public static function __callStatic($name, $arguments)
{
echo "{$name}静态方法不存在!\n";
}

public function test()
{
echo "test 方法\n";
}

public static function test2()
{
echo "test2 方法\n";
}

private static function test3()
{
echo "test3 方法\n";
}

protected static function test4()
{
echo "test4 方法\n";
}
}

A::test();
A::test2();
A::test3();
A::test4();
A::test5();
echo "--\n";
var_dump(A::test);
var_dump(A::test2);
var_dump(A::test3);