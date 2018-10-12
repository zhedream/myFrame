<?php

namespace app\controllers;

use Core\Controller;
use core\Request;
use Core\DB;
use app\Models\Test;
use app\Models\Heart;
use app\Models\Comment;
use app\Models\ArticleCategory;

class MockController extends Controller {

    public function users() {
        // 20个账号

        for ($i = 0; $i < 20; $i++) {
            $email = rand(50000, 99999999999) . '@126.com';
            $password = md5('123123');
            $name = getChar(2);
            DB::exec("INSERT INTO users (email,name,password) VALUES(?,?,?)", [$email, $name, $password]);
        }
    }

    public function blog() {

        // 清空表，并且重置 ID

        for ($i = 0; $i < 300; $i++) {
            $title = getChar(rand(20, 100));
            $description = getChar(rand(20, 100));
            $content = getChar(rand(100, 600));
            $display = rand(10, 500);

            $accessable = ['public', 'private'];
            $random_keys = array_rand($accessable, 1);
            $accessable = $accessable[$random_keys];

            $type = rand(1, 11);
            $date = rand(1233333399, 1535592288);
            $date = date('Y-m-d H:i:s', $date);
            $user_id = rand(1, 20);
            DB::exec("INSERT INTO articles (title,`description`,content,display,accessable,type,created_at,user_id) VALUES(?,?,?,?,?,?,?,? )"
                , [$title, $description, $content, $display, $accessable, $type, $date, $user_id]);

        }
    }

    public function hearts(){

        $H = new Heart;


        $pdo = Heart::$pdo;
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ERRMODE_SILENT

        for ($i=0; $i <  400; $i++) {
            $date = rand(1233333399,1535592288);
            $date = date('Y-m-d H:i:s', $date);

            $data = [
                'article_id'=>rand(1,20),
                'user_id'=>rand(1,20),
                'created_at'=>$date
            ];
            $H->exec_insert($data);
        }
    }

    function comments() {
        $comment = new Comment;


        $pdo = Comment::$pdo;
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ERRMODE_SILENT

        for ($i=1; $i <=  200; $i++) {
            
            $time = rand(1, 5); // 随机 评论数
            for ($j=1; $j <= $time; $j++) {
                $date = rand(1233333399,1535592288);
                $date = date('Y-m-d H:i:s', $date);

                $content = getChar(rand(100, 600));
                $data = [
                    'article_id'=>$i,
                    'user_id'=>rand(1,20),
                    'content'=>$content,
                    'created_at'=>$date
                ];
                $comment->exec_insert($data);

            }
            
        }
    }
    function ArticleCategory() {
        $Article = new Article;
        $pdo = Article::$pdo;
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING); //ERRMODE_SILENT

        for ($i=1; $i <=  200; $i++) {
            
            $time = rand(1, 5); // 随机 评论数
            for ($j=1; $j <= $time; $j++) {
                $date = rand(1233333399,1535592288);
                $date = date('Y-m-d H:i:s', $date);

                $content = getChar(rand(4, 600));
                $data = [
                    'article_id'=>$i,
                    'user_id'=>rand(1,20),
                    'content'=>$content,
                    'created_at'=>$date
                ];
                $Article->exec_insert($data);

            }
            
        }
    }

}

?>