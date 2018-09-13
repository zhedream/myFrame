<?php

namespace app\controllers;

use Core\HomeController;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\User;
use app\Models\Order;

class UserController extends HomeController {

    function regist(Request $req, $id) {

        if (isset($_SESSION['email']))
            redirect('/');

        view('user.regist');

    }

    function doregist(Request $req, $id) {
        $email = $_POST['email'];
        $password = 123123;
        $num = User::findOneFirst('select count(*) from users where email=?', [$email]);
        // dd($num);
        if ($num) {

            return message('该账号已注册', 1, '/user/login');
        }
        $code = md5($email + rand(10000, 99999));
        if (User::store($email, $password, $code))
            message('激活邮件已发送请注意查收', 1, '/user/login');
        else
            message('激活邮件已发送,未收到请重新注册发送', 1, '/user/login');

    }

    function active(Request $req, $id) {
        // echo '激活成功'.$_GET['code'];
        $user = RD::getTimeOut('userActive', $_GET['code'], true);
        var_dump($user);
        if ($user) {
            User::usersave($user);
            message('激活成功,正在跳转登陆', 1, '/user/login');
        } else
            message('账号已激活,或连接已失效,如有需要请重新发送', 1, '/user/login');

    }

    function login(Request $req, $id) {
        if (isset($_SESSION['email']))
            redirect('/');
        view('user.login');
    }

    function logout() {

        $_SESSION['email'] = null;
        $_SESSION['user_id'] = null;
        message('退出成功', 1, Route('user.login'));
    }

    function dologin(Request $req, $id) {

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = User::findOne('select * from users where email=? and password=?', [$email, $password]);
        if ($user) {
            var_dump($user);
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            message('登录成功！', 2, '/');
        } else {
            message('账号或密码错误，请重新登陆', 1, '/user/login');

        }

    }

    function loging() {
        echo json_encode([
            'email' => $_SESSION['email']
        ]);
    }

    // 充值
    function recharge() {
        view('user.recharge');
    }

    function dorecharge(Request $req, $id) {

        $order = new Order;
        // dd($req->all());
        $order->insert($req->all());
        message('成功提交订单', 1, Route('order.list'));
    }

    // 支付
    function payment() {
        echo 'UserController this is payment 支付';
    }

    function update() {


    }

}

?>