<?php

namespace app\controllers;

use Core\HomeController;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\User;
use app\Models\Order;
use core\Route;
use Intervention\Image\ImageManagerStatic as Image;

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
        $_SESSION['name'] = null;
        $_SESSION['user_id'] = null;
        $_SESSION['avatar'] = null;
        $_SESSION['_token'] = null;
        message('退出成功', 1, Route('user.login'));
    }

    function dologin(Request $req, $id) {

        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $user = User::findOne('select * from users where email=? and password=?', [$email, $password]);
        if ($user) {
            // var_dump($user);
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['avatar'] = $user['avatar'];
            $_SESSION['_token'] = csrf();
            message('登录成功！', 2, Route('blog.index'));
        } else {
            message('账号或密码错误，请重新登陆', 1, '/user/login');

        }

    }

    function loging() {
        echo json_encode([
            'email' => $_SESSION['email'],
            'avatar' => $_SESSION['avatar'],

        ]);
    }

    // 充值
    function recharge() {
        view('user.recharge');
    }

    function dorecharge(Request $req, $id) {

        $order = new Order;
        $order->insert($req->all());
        message('成功提交订单', 1, Route('order.list'));
    }

    // 支付
    function payment() {
        echo 'UserController this is payment 支付';
    }

    function update() {


    }

    function avatar() {

        if($_SESSION['user_id'])
            return view('user.avatar');
        else
            message('未登录,请重新登陆',1,Route('user.login'));
            
    }   

    function doavatar(Request $req, $id) {
        // $_FILES['face'];
        extract($req->all());
        // var_dump($_POST);
        // var_dump($_FILES);
        // echo 'success';

        $file = $_FILES['face'];
        $md5 = md5_file($file['tmp_name']);
        $date = date('Ymd');
        // $name
        $dir = ROOT . 'public/uploads/avatar/' . $date;
        is_dir($dir) OR mkdir($dir, 0777, true);
        $path = $dir . "/{$md5}." . $fileType;

        $img = Image::make($file['tmp_name']);
        $img->crop((int)$w, (int)$h, (int)$x, (int)$y); // 剪裁

        $tem = $img->resize(80, null, function ($cons) {
            $cons->aspectRatio();
        });

        $img->resize(80, null, function ($cons) {
            $cons->aspectRatio();
        })->save($path);

        rename($img->dirname . '/' . $img->basename, $img->dirname . '/' . md5($img->encoded) . '.' . $img->extension);
        $user = new User;
        $a = $user->exec_update([
            'avatar'=>'/uploads/avatar/' . $date. '/' . md5($img->encoded) . '.' . $img->extension,
        ],
            ['id'=>$_SESSION['user_id']]
        );

        if($a){
            echo json_encode([
                'err'=>1,
                'msg'=>'更新头像成功',
                'url'=>'/uploads/avatar/' . $date. '/' . md5($img->encoded) . '.' . $img->extension,

            ]);
        }else{
            echo json_encode([
                'err'=>007,
                'msg'=>'更新头像失败',

            ]);
        }
    }

    function readyfile(Request $req, $id) {
        extract($req->all());
        $redis = RD::getRD();

        $exis = $redis->hexists('Hash:files:' . $MD5, 'url');

        if ($exis) {

            $url = RD::getHash('files:' . $MD5, 'url');
            echo json_encode([
                'err' => '1',
                'msg' => '可以秒传',
                'data' => $url
            ]);

            return;
        }
        // echo 'file_slices:' . $MD5;
        $indexs = $redis->zrangebyscore('file_slices:' . $MD5, 0, 9999, 'withscores');
        $indexs = array_values($indexs);

        if ($indexs) {


            echo json_encode([
                'err' => '2',
                'msg' => '断点续传',
                'data' => $indexs
            ]);

            return;

        }


        echo json_encode([
            'err' => '3',
            'msg' => '完整上传',
        ]);

        return;

    }

}

?>