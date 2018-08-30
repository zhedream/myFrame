<?php

namespace Core;
use \PDO;
class DB{

    static $pdo = null;

    function __construct(){
		
		self::db();
    }
    private static function db(){
		if (self::$pdo == NULL) {
            $db = (include "Config/config.php")['db'];
            $dsn = "mysql:host=".$db['host'].";dbname=".$db['dbname'];
            try{
                self::$pdo = new PDO($dsn,$db['user'],$db['pwd']);
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION); // 设置报错提示
                self::$pdo->exec("set names utf8");
            }catch(PDOException $e){
                echo "{$dbname}数据库连接失败！".$e->getMessage();
            }
		}
    }

    static function findAll($sql,$data=[]){
        if (self::$pdo === NULL) self::db();
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC
            $arr = $stmt->fetchAll();
            return $arr;
        }
            return false;
    }
    static function findOne($sql,$data=[]){
        if (self::$pdo === NULL) self::db();
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr;
        }
            return false;
    }
    static function findOneFirst($sql,$data=[]){
        if (self::$pdo === NULL) self::db();
        $stmt = self::$pdo->prepare($sql);
        if($stmt->execute($data)){
            $stmt->setFetchMode();//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr[0];
        }
        return false;
    }
    static function exec($sql,$data=[]){
        if (self::$pdo === NULL) self::db();
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

        if (self::$pdo === NULL) self::db();

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
        if (self::$pdo === NULL) self::db();
        self::$pdo->beginTransaction();
        foreach ($Action as $v) 
            if(!self::exec($v[0],$v[1]))
                return false;
        self::$pdo->rollBack();
    }

}




?>