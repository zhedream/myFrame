<?php 

namespace Core;
use \PDO;
use Core\DB;
use Core\RD;
class baseModel{

    static $pdo = null;

	function __construct(){
        baseModel::db();
        $this->a= 2;
	}

    public function getTableName(){
        //$config;
        $config = $GLOBALS['config'];
        //拼接表名
        return $config['db']['prefix'].$this->table;

    }
    
    private static function db(){
		if (self::$pdo == NULL) {
                self::$pdo = DB::getDB();
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

    public function __call($name,$arr){

        echo "该模型".__CLASS__."不存在方法".$name.lm;

    }
    
    public static function __callstatic($name,$arr){

        echo "该模型".__CLASS__."不存在静态方法".$name.lm;

    }



}




 ?>