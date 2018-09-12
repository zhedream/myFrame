<?php
namespace app\Models;
use Core\Model;
use libs\Snowflake;
class Order extends Model{

    /**
     * 创建订单
     * 
     * @return 成功返回订单号 否则 false
     */
    function insert($data){
        $flaker = new Snowflake(1023);
        $sn =  $flaker->nextId();
        $order = [
            'sn'=>$sn,
            'money'=>$data['money'],
            'user_id'=>$_SESSION['user_id']
        ];
        // dd($order);
        // dd(self::exec_insert($order));
        if( self::exec_insert($order)){
            return $sn;
        }
        return false;

    }
}