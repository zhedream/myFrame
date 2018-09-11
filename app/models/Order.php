<?php
namespace app\Models;
use Core\Model;
use libs\Snowflake;
class Order extends Model{

    /**
     * 创建订单
     */
    function makes(){
        $flaker = new Snowflake(1234);
    }
}