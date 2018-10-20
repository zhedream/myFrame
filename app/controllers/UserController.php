<?php

namespace app\controllers;

use core\Request;
use app\Requests\LoginRequest;
use app\models\User;
use libs\Mail;
use libs\AliSms;

class UserController extends Controller {

    // 显示列表
    function index() {
        $user = new User;
        $data = $user->get();
        view('user.index',['data'=>$data]);
    }

    // 显示 添加页
    function add(){
        
        view('user.create');
    }

    // 添加
    function insert(Request $req,$id) {

        $data = $req->all();
        $user = new User;
        $user->fill($data);
        $user->exec_insert($user->getFillData());
        message('数据添加成功',1,Route('user.index'),3);
        // redirect(Route('user.index'));
    }

    // 删除
    function del(Request $req,$id){

        // $data = $req->all();
        $user = new User;
        $user->where($id)
            ->delete();
        message('数据删除成功',1,Route('user.index'),3);
    }
    
    // 显示 修改页
    function mod(Request $req,$id){

        $data = $req->all();
        $user = new User;
        $data = $user->where($id)->get()[0];
        view('user.edit',['data'=>$data]);
    }

    // 修改
    function update(Request $req,$id) {
        
        $data = $req->all();
        $user = new User;
        $user->where($id)
            ->fill($data)
            ->update();
        message('数据更改成功',1,Route('user.index'),3);
        
    }

    function login(){
        view('user.login');
    }

    function dologin(LoginRequest $req){

        $redis =  \core\RD::getRD();
        $time = $redis->get($emila.'errTime');
        if($time>=3){
            message('错误次数过多请稍后再试',1,'/user/login',2);
            return;
        }
        
        // dd($time);
        $data = $req->all();
        // dd($data,false);
        // dd($req->email);
        $user = new User;
        $user->group(function($q)use($req){
            $q->where('email',$req->username)
                ->orWhere('phone',$req->username);
        });
            
        $data = $user->where('password',$req->password)
        ->toSql(true);
        // ->get()[0];
        // dd($data);
        if($data){
            // 判断 密码
            $_SESSION['user_id'] = $data['id'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['name'] = $data['name'];

            message('登陆成功',1,'/index/index',2);
            return ;
        }else{

            // 判断 是否输错过
           if($redis->exists('errTime')){

                $redis->incrby('errTime',1); // 出错过 错误次数 + 1

           }else{
                // 第一次 出错 设置 错误 次数 为 1
                $redis->setex('errTime', 60*10, 1);
           }
           
            message('密码错误',1,'/user/login',2);
        }
    }

    function reg(){
        view('user.register');
    }

    // 手机注册
    function reg2(){
        
        view('user.register2');
    }

    function sendsms(Request $req){
        
        $data = $req->all();
        if($req->captcha==$_SESSION['Captcha']){

            $sms = new AliSms;
            $code = rand(100000, 999999);
            $_SESSION[$req->phone] = $code;
            // $re = $sms->send($req->phone,$code); // $re->Message == "OK" || $re->Code == "OK"
            if(true)
                echo json_encode([
                    'err'=>1,
                    'msg'=>'发送成功',
                    'data'=>$data,
                    'sess'=>$_SESSION,
                    // 'sms'=>$re
                ]);
            else
                echo json_encode([
                    'err'=>1,
                    'msg'=>'发送失败,请检查手机号是否正确',
                    'data'=>$data,
                    'sess'=>$_SESSION,
                    // 'sms'=>$re
                ]);
            
        }else{
            echo json_encode([
                'err'=>3,
                'msg'=>'失败,验证码错误',
                'data'=>$data,
                'sess'=>$_SESSION,
            ]);
        }
    }

    function doreg(Request $req){
        $data = $req->all();
        // dd($data);
        if($data['code']==$_SESSION['Captcha']){
            
            $user = new User;
            $user->fill($data);
            $user->exec_insert($user->getFillData());
            $mailer = new Mail;
            $email = $data['email'];
            // dd($email);
            $code = md5(rand(10000, 99999));
            // dd($code);
            $content = "
            点击以下链接进行激活：<br> 点击激活：
            <a href='http://lhz.tunnel.echomod.cn/user/active?code={$code}'>
            http://lhz.tunnel.echomod.cn/user/active?code={$code}</a><p>
            如果按钮不能点击，请复制上面链接地址，在浏览器中访问来激活账号！</p>";

            // $state = $mailer->send('注册激活', $content, $email);
            
            message('注册成功,能送激活码：已注释',1,'/user/login',3);
        }else{
                    
            message('验证码错误',1,'/user/reg',3);
            var_dump($data,$_SESSION);die;
        }

      

    }
    function doreg2(Request $req){
        $data = $req->all();
        if($data['captcha']==$_SESSION[$req->phone]){
            
            $user = new User;
            $u = $user->where('phone',$req->phone)->get()[0];
            if(!$u){

                $user->fill($data);
                $user->email = '';
                $user->exec_insert($user->getFillData());
                message('手机注册成功',1,'/user/login',3);
            }else{
                dd($u);
                message('手机注册成功',1,'/user/login',3);
            }


            
        }else{
                    
            message('短信验证码错误',1,'/user/reg',3);
            var_dump($data,$_SESSION);die;
        }

      

    }
}

?>