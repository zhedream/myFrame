<?php

namespace Core;

use \PDO;
use Core\DB;
use Core\RD;

Model::ModelRun();

class Model {

    private static $pdo = null;
    private static $redis = null;

    protected $table = null;
    protected $fillable = null;
    protected $fillData; // 填充的数据

    protected $select = "SELECT * ";
    protected $from = null;

    protected $where = null;
    protected $whereKeys = null;
    protected $whereVals = null;
    protected $leftJoin = null;
    protected $groupBy = null;
    protected $having = null;
    protected $orderBy = null;
    protected $limit = null;


    function __construct() {
        self::db();
        self::rd();
        $this->table = $this->table();
    }

    // 钩子 函数
    protected function _before_write() {
    }

    protected function _after_write() {
    }

    protected function _before_delete() {
    }

    protected function _after_delete() {
    }

    static function ModelRun() {
        self::db();
        self::rd();
    }

    function table($option = 1) {
        if ($this->table) {
            return $this->table;
        }
        $class = get_called_class();
        // echo $class."<br>";
        // $class = end(explode('\\', $class)); // 存在异常
        $class = explode('\\', $class);
        $class = end($class);

        $last = substr($class, -1);
        if ($last == 's')
            $class = $class;
        else
            $class = $class . 's';

        $class = lcfirst($class);
        $class = preg_replace_callback('/([A-Z])+/', function ($matches) {
            return "_" . strtolower($matches[1]);
        }, $class);

        $prefix = $GLOBALS['config']['db']['prefix'];
        //拼接表名
        return $prefix . $class;

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
        // dd($sql);
        $stmt = self::$pdo->prepare($sql);
        // return @$stmt->execute($data);
        return $stmt->execute($data);
    }

    function insert() {
        if ($this->fillData) {
            // var_dump($this->fillData);die;
            return $this->exec_insert($this->fillData);
        } else
            throwE('请先使用 fill 填充数据', 'insert');
    }

    function update($condition = []) {
        // 默认 以 where id  可以传入 条件
        // var_dump($this->where);die;
        // var_dump($this->whereKeys);die;
        return $this->exec_update($this->fillData, $this->where);
    }

    function delete() {
        // var_dump($this->where);die;
        // var_dump($this->whereKeys);die;
        // var_dump($this->whereVals);die;
        return $this->exec_delete($this->where);
    }

    /**
     * 自动 update OR insert
     * ( 存在 $this->where  update  否则 insert )
     */
    function save() {
    }

    /**
     * 自动填充数据
     * 1. 数据
     * 2. 填充模式
     */
    function fill($data, $must = false) {
        // dd($data);
        // var_dump($data);
        if ($this->fillable) {
            $tem = [];
            if ($must) {

                foreach ($this->fillable as $key)
                    $tem[$key] = $data[$key];

            } else {

                foreach ($data as $key => $val)
                    if (in_array($key, $this->fillable))
                        $tem[$key] = $val;
            }
            // dd($tem);
            $this->fillData = $tem;
        } else {
            throwE(get_called_class() . '的$fillable 不能为空', 'fill');
        }
        return $this;

    }

    /**
     * update 语句
     * 0. 表名 = 类名+s;
     * 1. 更改的字段 与 值 ['name'=>'名字']
     * 2. 更改的条件 与 值 ['id'=>7]
     */
    function exec_update(array $data, $where) {
        // \ob_clean();
        // \ob_clean();
        $keys = array_keys($data); // 所有设置的 字段
        $vals = array_values($data);// 所有设置的 字段值

        //dd($condition);
        $set = '';
        foreach ($keys as $key => $value) {
            if ($value == end($keys))
                $set .= "`$value`=? ";
            else
                $set .= "`$value`=?, ";

            // echo $value."->";
        }

        // dd($where);
        $data = [];
        if (!$this->whereVals) {
            $this->whereVals = [];
        }
        foreach ($vals as $key => $value) {
            // array_unshift($data,$value);
            $data[] = $value;
        }
        $this->whereVals = array_merge($data, $this->whereVals);

        
        $table = $this->table();
        // dd($table);
        $table = "`$table`";
        $sql = "UPDATE {$table} SET {$set} {$where}";
    //    var_dump($sql, $this->whereVals);die;
        return self::exec($sql, $this->whereVals);
    }

    function exec_update_old(array $data, array $condition) {
        // \ob_clean();
        $keys = array_keys($data); // 所有设置的 字段
        $vals = array_values($data);// 所有设置的 字段值
        // var_dump($keys,$vals,end($keys));die;
        $wherekeys = array_keys($condition); // 条件字段
        $wherevals = array_values($condition); // 条件值
        //dd($condition);
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
        dd($sql);
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
        // $fillkeys = implode(',',$keys);
        // dd($fillkeys);
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

        $table = $this->table();
        $table = "`$table`";
        $sql = "INSERT INTO {$table} ({$fillkeys}) VALUES ({$fillarea})";
        // var_dump($sql,$data);die;
        // dd($sql);
        return self::exec($sql, $data);
    }

    function exec_delete($where) {

        // $wherekeys = array_keys($condition); // 条件字段
        // $wherevals = array_values($condition); // 条件值
        // // dd($condition);
        // $where = '';
        // foreach ($wherekeys as $key => $value) {
        //     if ($key == end($wherekeys))
        //         $where .= "`$value`=? ";
        //     else
        //         $where .= "`$value`=?, ";
        // }
        // // dd($where);
        // $data = [];
        // foreach ($wherevals as $key => $value) {
        //     // array_unshift($data,$value);
        //     $data[] = $value;
        // }

        $table = $this->table();
        // dd($table);
        $table = "`$table`";
        $sql = "DELETE FROM {$table} {$where}";
        return self::exec($sql, $this->whereVals);
    }

    function exec_select() {
    }

    final function select($data) {
        $this->select = 'SELECT *';

        return $this;
    }

    final function from() {
        if (!$this->from)
            $this->from = " FROM " . "`" . $this->table() . "` ";

        return $this;
    }

    // --------------   WHERE 
    final function where() {

        $args = func_get_args();
        // dd($args);
        $num = func_num_args();
        if ($num == 1) {
            // whereID()
            if (is_int($args[0]) or is_string($args[0]))
                return call_user_func_array([__NAMESPACE__ . '\Model', "whereId"], $args);

            if (is_array($args[0]))
                return call_user_func_array([__NAMESPACE__ . '\Model', "whereArr"], $args);
        }
        return call_user_func_array([__NAMESPACE__ . '\Model', "where" . $num], $args);
    }

    final function whereId($id) {
        // dd($id);
        $where = " AND `id`=? ";
        // $where = " AND `id`=" . $id;
        // 储存 条件值
        if (!$this->whereVals) {

            $this->whereVals = [];
            $this->whereKeys = [];
        }
        $this->whereVals[] = $id;
        $this->whereKeys[] = 'id';

        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;
    }

    /**
     * 待更新
     * for 数组 的长度 再进行 拼接 语句
     */
    final function whereArr($condition) {
        $wherekeys = array_keys($condition); // 条件字段
        $wherevals = array_values($condition); // 条件值
        // dd($condition);
        $where = '';
        // 第一次 where 为空
        if (!$this->where) {

            foreach ($condition as $key => $value) {
                if ($key == end($wherekeys))
                    $where .= " AND `$key`=? ";
                    // $where .= " AND `$key`=$value ";
                else
                    $where .= " AND `$key`=? ";
                    // $where .= " AND `$key`=$value ";
            }
            $this->where = "WHERE 1 " . $where;

        } else {

            foreach ($condition as $key => $value) {
                if ($key == end($wherekeys))
                    $where .= " AND `$key`=? ";
                    // $where .= " AND `$key`=$value ";
                else
                    $where .= " AND `$key`=? ";
                    // $where .= " AND `$key`=$value ";
            }

            $this->where .= $where;

        }

        // 储存 条件值
        if (!$this->whereVals) {
            $this->whereVals = [];
        }
        foreach ($condition as $key => $value) {
            $this->whereVals[] = $value;
        }
        return $this;
    }

    final function where2($key, $val) {

        $where = " AND `$key`=? ";
        // $where = " AND `$key`=$val ";

        // 储存 条件值
        if (!$this->whereVals)
            $this->whereVals = [];
        $this->whereVals[] = $val;

        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;
    }

    final function where3($key, $sign, $val) {

        $where = " AND `$key` $sign ? ";
        // $where = " AND `$key` $sign $val ";
        // 储存 条件值
        if (!$this->whereVals)
            $this->whereVals = [];
        $this->whereVals[] = $val; // add val

        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;
    }

    // -------------  OR WHERE   
    final function orWhere() {

        $args = func_get_args();
        // dd($args);
        $num = func_num_args();
        return call_user_func_array([__NAMESPACE__ . '\Model', "orWhere" . $num], $args);

    }

    function orWhere1($condition) {

        $wherekeys = array_keys($condition); // 条件字段
        $wherevals = array_values($condition); // 条件值
        // dd($condition);
        $where = $this->where;
        foreach ($condition as $key => $value) {
            if ($key == end($wherekeys))
                $where .= "OR `$key`=? ";
                // $where .= "OR `$key`=$value ";
            else
                $where .= "OR `$key`=? ";
                // $where .= "OR `$key`=$value ";
        }

        // 储存 条件值
        if (!$this->whereVals) {
            $this->whereVals = [];
        }
        foreach ($condition as $key => $value) {
            $this->whereVals[] = $value;
        }

        $this->where = $where;
        // dd($where);
        return $this;
    }

    function orWhere2($key, $val) {

        $where = " OR `$key`=? ";
        // $where = " OR `$key`=$val ";
        // 储存 条件值
        if (!$this->whereVals)
            $this->whereVals = [];
        $this->whereVals[] = $val;

        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;
    }

    function orWhere3($key, $sign, $val) {
        $where = " OR `$key` $sign ? ";
        // $where = " OR `$key` $sign $val ";
        // 储存 条件值
        if (!$this->whereVals)
            $this->whereVals = [];
        $this->whereVals[] = $val; // add val

        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;
    }

    // ---------------  WHERE IN
    final function whereIn() {

        $args = func_get_args();
        $num = func_num_args();
        // dd($args);
        if (is_array($args[1])) {
            return call_user_func_array([__NAMESPACE__ . '\Model', "whereInArr"], $args); // 数组 数据
        }
        if (is_callable($args[1])) {
            // $args[1] = 123;
            // var_export($args[1]);
            // die;
            return call_user_func_array([__NAMESPACE__ . '\Model', "whereInCall"], $args); // 回调 数据/对象
        }
        if (is_string($args[1])) {
            return call_user_func_array([__NAMESPACE__ . '\Model', "whereInSql"], $args); // 回调 数据/对象
        }

        die;
    }

    // 不进行 预处理 !!
    function whereInArr($k, $arr, $not = false) {

        $keys = array_keys($arr); // 获取 索引
        if (!$this->whereVals)
            $this->whereVals = [];

        $val = "(";
        foreach ($arr as $key => $value) {
            if ($key == end($keys))
                $val .= "$value";
            else
                $val .= "$value,";

            // $this->whereVals[] = $value; // add val
        }
        $val .= ")";

        if ($not)
            $where = " AND `$k` NOT IN $val ";
        else
            $where = " AND `$k` IN $val ";
        // $this->where .=  $where; // link sql
        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        return $this;

    }

    function whereInCall($k, $call, $not = false) {
        // var_dump($call);die;
        $model = get_called_class();
        $m = new $model;
        $call($m);
        $sql = $m->toSql();
        $data = $m->whereVals;
        // dd($sql);

        if ($not)
            $where = " AND `$k` NOT IN ($sql) ";
        else
            $where = " AND `$k` IN ($sql) ";

        // $this->where .= $where;
        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        $this->whereVals = array_merge($this->whereVals, $m->whereVals);
        // $

        // var_dump($m);
        // dd($this,false);
        // 获取 当前 查询 模型 的    sql  与 变量
        return $this;
    }

    function whereInSql($k, $sql, $not = false) {
    }

    // -------------- OR WHERE IN
    final function orWhereIn() {

        $args = func_get_args();
        $num = func_num_args();
        // dd($args);
        if (is_array($args[1])) {

            return call_user_func_array([__NAMESPACE__ . '\Model', "orWhereInArr"], $args); // 数组 数据
        }
        if (is_callable($args[1])) {

            return call_user_func_array([__NAMESPACE__ . '\Model', "orWhereInCall"], $args); // 回调 数据/对象
        }
        if (is_string($args[1])) {

            return call_user_func_array([__NAMESPACE__ . '\Model', "whereInSql"], $args); // 回调 数据/对象
        }

        die;
    }

    function orWhereInArr($k, $arr, $not = false) {

        $keys = array_keys($arr); // 获取 索引
        if (!$this->whereVals)
            $this->whereVals = [];

        $val = "(";
        foreach ($arr as $key => $value) {
            if ($key == end($keys))
                $val .= "$value";
            else
                $val .= "$value,";

            // $this->whereVals[] = $value; // add val
        }
        $val .= ")";

        if ($not)
            $where = " OR `$k` NOT IN $val ";
        else
            $where = " OR `$k` IN $val ";

        $this->where .= $where; // link sql
        
        return $this;

    }

    // 不使用  预处理
    function orWhereInCall($k, $call, $not = false) {
        // var_dump($call);die;
        $model = get_called_class();
        $m = new $model;
        $call($m);
        $sql = $m->toSql();
        $data = $m->whereVals;
        // dd($sql);

        if ($not)
            $where = " OR `$k` NOT IN ($sql) ";
        else
            $where = " OR `$k` IN ($sql) ";

        // $this->where .= $where;
        if (!$this->where) {
            $this->where = "WHERE 1 " . $where;
        } else {
            $this->where .= $where;
        }

        $this->whereVals = array_merge($this->whereVals, $m->whereVals);
        // $

        // var_dump($m);
        // dd($this,false);
        // 获取 当前 查询 模型 的    sql  与 变量
        return $this;
    }

    function orWhereInSql() {
    }


    final function like() {
    }

    final function orLike() {
    }

    // 大括号
    final function group() {
    }

    final function orGroup() {
    }

    final function leftJoin() {
        return $this;
    }

    final function groupBy() {
        return $this;
    }

    final function having() {
        return $this;
    }

    final function orderBy() {
        return $this;
    }

    final function limit() {
        return $this;
    }

    function toSql($fill = false) {
        $this->from();
        $sql = $this->select
            . $this->from
            . $this->where
            . $this->leftJoin
            . $this->groupBy
            . $this->having
            . $this->orderBy
            . $this->limit;

        if ($fill) {
            // 如果为真 把 ？ 替换 成 data
        }
        // dd($sql);
        return $sql;
    }

    final function get() {
        $this->from();
        $sql = $this->select
            . $this->from
            . $this->where
            . $this->leftJoin
            . $this->groupBy
            . $this->having
            . $this->orderBy
            . $this->limit;
//        var_dump($sql,$this->whereVals);die;
        return $this->findAll($sql, $this->whereVals);
    }

    final function sqlReset() {
        $this->select = "SELECT * ";
        $this->from = null;

        $this->where = null;
        $this->whereKeys = null;
        $this->whereVals = null;
        $this->leftJoin = null;
        $this->groupBy = null;
        $this->having = null;
        $this->orderBy = null;
        $this->limit = null;
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

        if ($Action()) {

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

    public function __set($name, $val) {
        $this->fillData[$name] = $val;
    }

    public function __get($name) {
        return $this->fillData[$name];
    }


}


?>