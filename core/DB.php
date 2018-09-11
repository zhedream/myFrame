<?php

namespace Core;
use \PDO;
DB::client();
class DB{

    static $pdo = null;

    function __construct(){
		
		self::client();
    }

    static function getDB(){
        if (self::$pdo === NULL) {
            // echo '2<br>';
            self::client();
            return self::$pdo;
        }
        else{
            // echo '3<br>';
            return self::$pdo;
        }
    }
    static function client(){
		if (self::$pdo == NULL) {
            $conf = $GLOBALS['config']['db'];
            $dsn = "mysql:host=".$conf['host'].";dbname=".$conf['dbname'];
            try{
                self::$pdo = new PDO($dsn,$conf['user'],$conf['pwd']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // 设置报错提示
                self::$pdo->exec("set names utf8");
            }catch(PDOException $e){
                echo "数据库连接失败！".$e->getMessage();
            }
		}
    }

    static function findAll($sql,$data=[]){
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC
            $arr = $stmt->fetchAll();
            return $arr;
        }
            return false;
    }
    static function findOne($sql,$data=[]){
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr;
        }
            return false;
    }

    /**
     * 查询一个字段的 值
     */
    static function findOneFirst($sql,$data=[]){
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode();//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr[0];
        }
        return false;
    }

    /**
     * 查询表信息
     * 1. 表名
     */
    function desctable($table){
        return self::findAll('desc '.$table);
    }

    /**
     * 查询建表语句
     * 1. 表名
     */
    function showcreatetable($table){
        return self::findAll('show create table '.$table);
    }

    /**
     * 执行非查询sql
     * 1. 预处理 sql
     * 2. 数据
     */
    static function exec($sql,$data=[]){
        $stmt = self::$pdo->prepare($sql);
        return $stmt->execute($data);
    }

    /**
     * 事务 SQL   注意 InnoDB 才支持 事务
     * 1.传入 [
     * [$sql1,$data1],
     * [$sql2,$data2],
     * ...
     * ]
     */
    static function Transaction($Action){

        self::$pdo->beginTransaction();
        foreach ($Action as $v) {
            if(!self::exec($v[0],$v[1])){
                self::$pdo->rollBack();//事务回滚 ， 貌似  可以 不添加
                return false;
            }
        }
        self::$pdo->commit();//提交(确认)
    }

    /**
     * 开启了事务不提交 可测试 Sql 语句,不会插入 数据库
     */
    static function testSql($Action){
        
        if (self::$pdo === NULL){ self::client(); echo '修复连接';}
        self::$pdo->beginTransaction();
        foreach ($Action as $v) 
            if(!self::exec($v[0],$v[1]))
                return false;
        self::$pdo->rollBack();
    }

}







?>