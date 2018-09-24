<?php

namespace app\controllers;

use core\Controller;
use core\Request;
use Core\DB;
use Core\RD;
use app\Models\Article;
use app\Models\Comment;
use app\Models\Heart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BlogController extends Controller {

    function index() {
        if ($_SESSION['email']) {
            $article = new Article;
            $blogs = $article->allUserBlog($_SESSION['user_id']);
            view('blog.index', [
                'blogs' => $blogs
            ]);
            echo 'this is BLog index';

        } else {
            message('未登录', 1, Route('user.login'));
        }
    }


    function get(Request $req, $id) {
        var_dump(Article::get($id));

    }

    /**
     * @param Request $req
     * @param $id
     */
    function increase(Request $req, $id) {
        $article = new Article;
        $heart = new Heart;
        $readKey = 'readRecord';
        $heartTop = $heart->getHeartTop($id);
        $c = json_decode($_COOKIE[$readKey], true);
        if (!$c || !in_array($id, $c)) {
            echo json_encode([
                'display' => $article->increase('display', $id),
                'heart' => $article->getIncrease('heart', $id),
                'email' => $_SESSION['email'],
                'avatar' => $_SESSION['avatar'],
                'token' => $_SESSION['_token'],
                'heartTop'=>$heartTop,
            ]);

            if (!$c) {
                $c = [];
                array_push($c, $id);
            }

            array_push($c, $id);
            $c = json_encode($c, true);
            return response()->WithCookie($readKey, $c, 60*5, '/blog/content/');

        } else {
            echo json_encode([
                'display' => $article->getIncrease('display', $id),
                'heart' => $article->getIncrease('heart', $id),
                'email' => $_SESSION['email'],
                'avatar' => $_SESSION['avatar'],
                'token' => $_SESSION['_token'],
                'heartTop'=>$heartTop,
            ]);
        }

    }

    function create() {
        view('blog.create');
    }

    function store() {
        $article = new Article;
        // jj($_POST);

        if ($article->store()) {


            message('发布成功', 1, Route('blog.index'));

        }

    }

    function del() {

        $article = new Article;
        $user_id = $_SESSION['user_id'];
        $id = $_POST['id'];
        // jj($_POST);
        $re = DB::findOneFirst('select Count(*) from articles where user_id=? and id=?', [$user_id, $id]);
        // dd($re);
        // jj($re);
        if ($re) {

            $a = $article->del($id);
            $article->allUserBlog($_SESSION['user_id'], true);
            message('删除成功:' . $a, 1, Route('blog.index'));

        }

    }

    function edit(Request $req, $id) {

        if (isset($_SESSION['email'])) {
            $article = new Article;
            $blog = Article::findOne('select * from articles where user_id=? and id=?', [$_SESSION['user_id'], $id]);
            // jj($blog);
            if ($blog) {
                view('blog.edit', ['blog' => $blog]);
                return;
            } else
                echo json_encode([
                    'err' => 007,
                    'msg' => 'this is BlogController edit',
                ]);
        }

        echo json_encode([
            'err' => 007,
            'msg' => '登陆信息过期,请重新登陆'
        ]);
        die;


    }

    function doedit(Request $req, $id) {
        $data = $req->all();
        $article = new Article;
        $blog = Article::findOne('select * from articles where user_id=? and id=?', [$_SESSION['user_id'], $id]);
        if ($blog) {
            // jj($blog);

            // dd($req);
            // dd();
            if ($article->update($id, $data)) {
                message('文章修改成功', 1, Route('blog.index'));
                $article->allUserBlog($_SESSION['user_id'], true); // 强制读取
            }
        } else {
            // echo json_encode([
            // 	'err'=>007,
            // 	'msg'=>'请重新登陆'
            // ]);
            message('请重新登陆', 1, Route('blog.index'));
        }

    }

    // 导出 表格
    public function makeExcel() {
        // 获取当前标签页
        $spreadsheet = new Spreadsheet();
        // 获取当前工作
        $sheet = $spreadsheet->getActiveSheet();

        // 设置第1行内容
        $sheet->setCellValue('A1', '标题');
        $sheet->setCellValue('B1', '内容');
        $sheet->setCellValue('C1', '发表时间');
        $sheet->setCellValue('D1', '是发公开');

        // 取出数据库中的日志
        $model = new Article;
        // 获取最新的20个日志
        $blogs = $model->allUserBlog($_SESSION['user_id']);
        // dd($blogs);

        $i = 2; // 第几行
        foreach ($blogs as $v) {
            $sheet->setCellValue('A' . $i, $v['title']);
            $sheet->setCellValue('B' . $i, $v['content']);
            $sheet->setCellValue('C' . $i, $v['created_at']);
            $sheet->setCellValue('D' . $i, $v['accessable']);
            $i++;
        }

        $date = date('Ymd');

        // 生成 excel 文件
        $writer = new Xlsx($spreadsheet);
        $writer->save(ROOT . 'temp/' . $date . '.xlsx');

        // 调用 header 函数设置协议头，告诉浏览器开始下载文件

        // 下载文件路径
        $file = ROOT . 'excel/' . $date . '.xlsx';
        // 下载时文件名
        $fileName = '最新的20条日志-' . $date . '.xlsx';

        return response()->download($file, $fileName);


    }

    function content(Request $req, $id) {
        // $A = new Article;
//        dd($id);
        // $user = Article::findOneFirst('select `user_id` from `articles` where `id`=? and `user_id`=?',[$id,$_SESSION['user_id']]);
        // if($user!=$_SESSION['user_id']){
        //     view('error');
        //     return;
        // }
        
        $blog = RD::chache("content_{$_SESSION['user_id']}:" . $id, 3600, function () use ($id) {
            return Article::findOne('select * from articles where id=? and user_id=?', [$id, $_SESSION['user_id']]);
        });

        // $blog = RD::chache("test_content_{$_SESSION['user_id']}:" . $id, 100, function () use ($id) {
        //     return Article::findOne('select * from articles where id=? ', [$id]);
        // });

        if ($blog) {
                
            $article = new Article;
            $H = new Heart;
            $blog['heart'] = $article->getIncrease('heart', $id); // 更新 heart 
            $heartTop = $H->getHeartTop($id);
            // dd($heartTop);
            return view('blog.content', [
                'blog' => $blog,
                'heartTop'=>$heartTop,
            ]);
        }
        view('error');

    }

    function comment(Request $req, $id){

        $com = new Comment;

        $data = $com->get($id);

        echo $data;
        
    }
    function docomment(Request $req, $id){

        $com = new Comment;

        $com->insert();
        
    }

    /**
     * 点赞
     *
     */
    function HeartToggle(Request $req, $id) {

        $user_id =  $_SESSION['user_id'];
        

        if(!$user_id){

            echo json_encode([
                'err'=>7,
                'msg'=>'未登录',
            ]);
            return ;
        }
        $H = new Heart;
        $count = $H->UheartA($user_id,$id);

        echo json_encode([
            'err'=>1,
            'msg'=>'登陆ing',
            'count'=>$count
        ]);



    }

    

}

?>