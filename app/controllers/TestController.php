<?php

namespace app\controllers;

use Core\HomeController;
use core\Request;
use Core\DB;
use Core\RD;
use libs\Mail;
use app\Models\TestModel;
use app\Models\User;
use app\Models\Heart;
use libs\Uploader;



class TestController extends HomeController {


    function redis() {
        echo 'this is TestController';
        $redis = RD::getRD();
        echo $redis->get('name');
    }

    function mysql() {
        echo 'this is TestController';
        var_dump(DB::findOne("select * from articles where id=?", [2]));
    }

    function mail($data) {

        // var_dump($data);
        echo 'this is TestController';
        $mail = new Mail;
        echo $mail->send('激活邮件1', '点击这里激活', 'l19517863@126.com');

    }

    function user(Request $req, $id) {
        echo "Request->" . $req->test . "<br>";
        echo "第一个路由参数->" . $id . "<br>";
        var_dump($req->routevar);
    }

    function aa() {
        $data = TestModel::getUserInfo();
        $this->assign('data', $data);
        $this->display('a/a.html');
    }

    function content2html() {
        echo 'content2html<br>';
        $blogs = DB::findAll('select * from articles');
        // var_dump($blogs);
        // die();
        ob_start();
        foreach ($blogs as $key => $value) {
            // $this->assign('blog',$value);
            // $this->display('blog/content.html');
            view('blog.content', ['blog' => $value, '_static' => '_static']);
            $str = ob_get_contents();
            // 生成静态页
            file_put_contents(ROOT . '/public/content/' . $value['id'] . '.html', $str);
            // 清空缓冲区
            ob_clean();
        }

    }

    function index2html() {

        $blogs = DB::findAll('select * from articles');
        ob_start();

        // $this->assign('blogs',$blogs);
        // $this->display('index.html');

        view('index', ['blogs' => $blogs, '_static' => '_static']);
        $str = ob_get_contents();
        // 生成静态页
        file_put_contents(ROOT . '/public/index.html', $str);
        // 清空缓冲区
        ob_clean();

    }

    function a() {
        echo 'asdf';
    }

    function routeName() {
        echo routeName();
    }

    function makeUrl(Request $req, $id) {
        echo '路由名称: ' . routeName() . '<br>';
        echo '生产路由: ' . Route(routeName(), ['id' => $id], true);
    }

    public function testPurify() {
        // 测试字符串
        $content = "你懂 <a href=''></a>  的 <a href=''>小技巧   fdaf<div>fdafd</div> fdsa <script>console.log('abc');</script>";

        // 1. 生成配置对象
        $config = \HTMLPurifier_Config::createDefault();

        // 2. 配置
        // 设置编码
        $config->set('Core.Encoding', 'utf-8');
        $config->set('HTML.Doctype', 'HTML 4.01 Transitional');
        // 设置缓存目录
        $config->set('Cache.SerializerPath', ROOT . 'cache');
        // 设置允许的 HTML 标签
        $config->set('HTML.Allowed', 'div,b,strong,i,em,a[href|title],ul,ol,ol[start],li,p[style],br,span[style],img[width|height|alt|src],*[style|class],pre,hr,code,h2,h3,h4,h5,h6,blockquote,del,table,thead,tbody,tr,th,td');
        // 设置允许的 CSS
        $config->set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,margin,width,height,font-family,text-decoration,padding-left,color,background-color,text-align');
        // 设置是否自动添加 P 标签
        $config->set('AutoFormat.AutoParagraph', TRUE);
        // 设置是否删除空标签
        $config->set('AutoFormat.RemoveEmpty', TRUE);

        // 3. 过滤
        // 创建对象
        $purifier = new \HTMLPurifier($config);
        // 过滤
        $clean_html = $purifier->purify($content);


        echo $clean_html;
    }

    function getcsrf() {

        echo csrf();

    }

    function testSql() {
        $blog = Test::testSql([
            [" select * from " . $this->table() . " where user_id=? and id=? ", [$_SESSION['user_id'], $id]],
        ]);
    }

    function showtable() {

        var_dump(DB::findAll('desc articles'));
        // jj( DB::findAll('show create table articles'));
    }

    function upload() {
        $upload = Uploader::new();
       var_dump($upload);
        var_dump($upload->getExt());
//        echo '123';
        return ;
    }

    function md5(){

        // echo md5_file('D:\deepin-15.6-amd64.iso');
        view('md5');
    }

    function users(){

        $U = new User;

        // jj($U->getAllUsers());
        echo json_encode([
            'err'=>1,
            'data'=>$U->getAllUsers(),

        ]);


    }

    function login(){
        unset($_SESSION['email']);
        unset($_SESSION['name']);
        unset($_SESSION['user_id']);
        unset($_SESSION['avatar']);
        unset($_SESSION['_token']);

        $email = $_GET['email'];
        $password = md5(123123);

        $user = User::findOne('select * from users where email=? and password=?', [$email, $password]);
        if ($user) {
            var_dump($user);
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


    function testCookie(){
//        die('cookie');
//        var_dump($_COOKIE);
//        setcookie("key:asd",'afsafas',time()+120,'/test/cookie');
         response()->WithCookie('test','12344',60);
    }

    function test() {
        $H = new Heart;
        $data = $H->readHeartU(21);
        // $data = $H->writeHeart();
        // $data = $H->getHeartCount(125);
        dd($data);
    }

}

?>