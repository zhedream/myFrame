<?php

namespace Core;

use \PDO;
use Core\DB;
use Core\RD;

Model::ModelRun();

class Model {

    static $pdo = null;
    static $redis = null;
    var $table = null;

    function __construct() {
        self::db();
        self::rd();
        // self::$table = $this->table() ;


        $this->table = $this->table();
    }

    static function ModelRun() {
        self::db();
        self::rd();
    }

    function table($option = 1) {

        $class = get_called_class();
        // echo $class."<br>";
        // $class = end(explode('\\', $class)); // 存在异常
        $class = explode('\\', $class);
        $class = end($class);

        $class = lcfirst($class) . 's';
        $class = preg_replace_callback('/([A-Z])+/',function($matches){
            return "_".strtolower($matches[1]);
        },$class);
        
        $prefix = $GLOBALS['config']['db']['prefix'];
        //拼接表名
        return $prefix. $class;

    }

    private static function db() {
        if (self::$pdo == NULL) {
            self::$pdo = DB::getDB();
        }
    }

    private static function rd() {
        if (self::$redis == NULL) {
            self::$redis = RD::getRD();
        }
    }

    static function findAll($sql, $data = []) {
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute($data)) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);// PDO::FETCH_ASSOC  //  PDO::FETCH_NUM
            $arr = $stmt->fetchAll();
            return $arr;
        }
        return false;
    }

    static function findOne($sql, $data = []) {
        // if (self::$pdo === NULL) self::db();
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute($data)) {
            $stmt->setFetchMode(PDO::FETCH_ASSOC);//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr;
        }
        return false;
    }

    static function findOneFirst($sql, $data = []) {
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute($data)) {
            $stmt->setFetchMode();//PDO::FETCH_ASSOC
            $arr = $stmt->fetch();
            return $arr[0];
        }
        return false;
    }

    /**
     * 返回 所有数据的第一个字段  一维数组
     */
    static function findOneFirsts($sql, $data = []) {
        $stmt = self::$pdo->prepare($sql);
        if ($stmt->execute($data)) {
            $stmt->setFetchMode(PDO::FETCH_NUM);//PDO::FETCH_ASSOC
            $arr = $stmt->fetchAll();
            $data = [];
            foreach ($arr as $key => $value) {
                $data[] = $value[0];
            }
            return $data;
        }
        return false;
    }

    static function exec($sql, $data = []) {
        // dd($data);
        $stmt = self::$pdo->prepare($sql);
        return @$stmt->execute($data);
    }

    /**
     * update 语句
     * 0. 表名 = 类名+s;
     * 1. 更改的字段 与 值 ['name'=>'名字']
     * 2. 更改的条件 与 值 ['id'=>7]
     */
    function exec_update(array $data, array $condition) {
        // \ob_clean();
        $keys = array_keys($data); // 所有设置的 字段
        $vals = array_values($data);// 所有设置的 字段值
        // var_dump($keys,$vals,end($keys));die;
        $wherekeys = array_keys($condition); // 条件字段
        $wherevals = array_values($condition); // 条件值
//        dd($condition);
        $set = '';
        foreach ($keys as $key => $value) {
            if ($value == end($keys))
                $set .= "`$value`=? ";
            else
                $set .= "`$value`=?, ";
            // echo $value."->";
        }
        // die;
        // dd($set);
        $where = '';
        foreach ($wherekeys as $key => $value) {
            if ($key == end($wherekeys))
                $where .= "`$value`=? ";
            else
                $where .= "`$value`=?, ";
        }
        // dd($where);
        $data = [];

        foreach ($vals as $key => $value) {
            // array_unshift($data,$value);
            $data[] = $value;
        }

        foreach ($wherevals as $key => $value) {
            // array_unshift($data,$value);
            $data[] = $value;
        }
        $table = $this->table();
        // dd($table);
        $table = "`$table`";
        $sql = "UPDATE {$table} SET {$set} WHERE {$where}";
//        dd($sql);
        return self::exec($sql, $data);
    }

    /**
     * insert 语句
     * 0. 表名 = 类名+s;
     * 1. 更改的字段 与 值 ['name'=>'名字']
     */
    function exec_insert(array $data) {

        $keys = array_keys($data); // 插入设置的 字段
        $vals = array_values($data);// 插入设置的 字段值
        // var_dump($keys,$vals);die;


        $fillkeys = '';
        foreach ($keys as $key => $value) {
            if ($value == end($keys))
                $fillkeys .= "`$value` ";
            else
                $fillkeys .= "`$value`, ";
            // echo $value."->";
        }

        $fillarea = '';
        foreach ($keys as $key => $value) {
            if ($value == end($keys))
                $fillarea .= "? ";
            else
                $fillarea .= "?, ";
        }

        $data = [];
        foreach ($vals as $key => $value) {
            // array_unshift($data,$value);
            $data[] = $value;
        }

        $table = $this->table(2);
        $table = "`$table`";
        $sql = "INSERT INTO {$table} ({$fillkeys}) VALUES ({$fillarea})";
        // var_dump($sql,$data);die;
        // dd($sql);
        return self::exec($sql, $data);
    }

    function exec_delete(array $condition){

        $wherekeys = array_keys($condition); // 条件字段
        $wherevals = array_values($condition); // 条件值
//        dd($condition);
        $where = '';
        foreach ($wherekeys as $key => $value) {
            if ($key == end($wherekeys))
                $where .= "`$value`=? ";
            else
                $where .= "`$value`=?, ";
        }
        // dd($where);
        $data = [];
        foreach ($wherevals as $key => $value) {
                    // array_unshift($data,$value);
                    $data[] = $value;
        }

        $table = $this->table();
        // dd($table);
        $table = "`$table`";
        $sql = "DELETE FROM {$table} WHERE {$where}";
        // dd($sql);
        // dd($data);
        return self::exec($sql, $data);
    }

    /**
     * 事务 SQL   注意 InnoDB 才支持 事务
     * 1.传入 [
     * [$sql1,$data1],
     * [$sql2,$data2],
     * ...
     * ]
     */
    static function Transaction($Action) {

        self::$pdo->beginTransaction();
        foreach ($Action as $v) {
            if (!self::exec($v[0], $v[1])) {
                self::$pdo->rollBack();//事务回滚 ， 貌似  可以 不添加
                return false;
            }
        }
        self::$pdo->commit();//提交(确认)
    }

    static function TransactionCall(callable $Action) {
        self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); // 报错模式 非严格
        self::$pdo->beginTransaction();
        
        if($Action()){
            
             self::$pdo->commit();//提交(确认)
             return true;
        }
    }

    /**
     * 开启了事务不提交 可测试 Sql 语句,不会插入 数据库
     */
    static function testSql($Action) {
        // die('AAA');
        // dd($Action);
        self::$pdo->beginTransaction();
        foreach ($Action as $v)
            // dd($v);
            if (!self::exec($v[0], $v[1]))
                return false;

        self::$pdo->rollBack();
        return true;
    }

    public function __call($name, $arr) {

        echo "该模型" . __CLASS__ . "不存在方法" . $name . lm;

    }

    public static function __callstatic($name, $arr) {

        echo "该模型" . __CLASS__ . "不存在静态方法" . $name . lm;

    }


}


?>