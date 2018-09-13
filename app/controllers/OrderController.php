<?php

namespace app\controllers;

use Core\Controller;
use core\Request;
use app\models\Order;

class OrderController extends Controller {

    function list() {
        if (!isset($_SESSION['email'])) {
            message('未登陆', 1, Route('user.login'));
            die;
        }

        $order = new Order;
        //    dd($order->get_list());
        $orders = $order->get_list();
        view('user.order', [
            'orders' => $orders,
        ]);
    }

}

?>