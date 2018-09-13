<?php

namespace app\Models;

use Core\Model;
use libs\Snowflake;

class Order extends Model {

    /**
     * 创建订单
     *
     * @return 成功返回订单号 否则 false
     */
    function insert($data) {
        $flaker = new Snowflake(1023);
        $sn = $flaker->nextId();
        $order = [
            'sn' => $sn,
            'money' => $data['money'],
            'user_id' => $_SESSION['user_id'],
            'created_at' => date('Y-m-d g:i:s'),
        ];
        // dd($order);
        // dd(self::exec_insert($order));
        if (self::exec_insert($order)) {
            return $sn;
        }
        return false;

    }

    function get_list() {
        $table = $this->table();
        if (isset($_SESSION['user_id']))
            return Order::findAll("select * from " . $table . " where user_id=" . $_SESSION['user_id']);
        return false;
    }

    /**
     * BY sn
     */
    function findBysn($sn) {
        $table = $this->table();
        // dd('select * from '.$table.'where `sn`=?');
        return self::findOne('select * from ' . $table . ' where `sn`=?', [$sn]);
    }

    function update($order, $condition) {

        return $this->exec_update($order, $condition);
    }
}