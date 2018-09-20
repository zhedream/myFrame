<?php

namespace app\Models;

use Core\Model;
use core\RD;
use core\DB;

class Article extends Model {

    static function get($id) {

        return RD::chache('Articles:' . $id, 60, function () use ($id) {
            return self::findOne("select * from articles where id=?", [$id]);
        });
    }

    /**
     * 对文章 表 一个字段 的 自增
     * 
     * 1. 字段
     * 2. 文章 id
     * return 自增后的 值
     */
    function increase(string $field,int $id) {
        ob_clean(); // 清空缓存区
        if (self::$redis->hexists('Hash:Aricles:'.$field, $id))
            return self::$redis->hincrby('Hash:Aricles:'.$field, $id, 1);

        $num = self::findOneFirst('select '.$field.' from articles where id=?', [$id]);
        if ($num !== null) {

            self::$redis->hset('Hash:Aricles:'.$field, $id, (int)$num);
            return self::$redis->hincrby('Hash:Aricles:'.$field, $id, 1);
        }
        return false;
    }

    /**
     * 主要 获取 display heart
     * 1. 字段
     * 2. id
     */
    function getIncrease(string $field,int $id) {
        $redis = self::$redis;
        $hash = 'Hash:Aricles:'.$field;
        if ($redis->hexists($hash, $id)){
            return $redis->hget($hash,$id);
        }else{

            $num = self::findOneFirst('select '.$field.' from articles where id=?', [$id]);
            if ($num !== null) {

                self::$redis->hset('Hash:Aricles:'.$field, $id, (int)$num);
                return $this->getIncrease( $field, $id);
            }

            return false;
        }
        
    }

    /**
     * 读取/刷新 用户空间 文章
     * 1. 用户 user_id
     * 2. 覆盖刷新
     * return blogs
     */
    function allUserBlog($user_id, $cover = false) {

        return RD::chache('Articles_user:' . $user_id, 60, function () use ($user_id) {
            return self::findAll("select * from articles where user_id=?", [$user_id]);
        }, $cover);

    }

    function store() {

        $title = $_POST['title'];
        $description = getChar(rand(20, 100));
        $content = $_POST['content'];
        $display = rand(10, 500);

        $accessable = $_POST['accessable'];
        $type = rand(1, 11);
        $date = rand(1233333399, 1535592288);
        $date = date('Y-m-d H:i:s');
        $user_id = $_SESSION['user_id'];

        return DB::exec("INSERT INTO `articles` (`title`,`description`,`content`,`display`,`accessable`,`type`,`created_at`,`user_id`) VALUES(?,?,?,?,?,?,?,? )"
            , [$title, $description, $content, $display, $accessable, $type, $date, $user_id]);
    }

    function del($id) {
        // DELETE FROM 表名称 WHERE 列名称 = 值
        return DB::exec("DELETE FROM `articles` WHERE `id` = ?", [$id]);
    }

    /**
     * 更新数据
     * 1. id
     * 2. 数据
     */
    function update($id, $data) {
        // dd($data);
        $blog = Article::findOne(" select * from " . $this->table() . " where user_id=? and id=? ", [$_SESSION['user_id'], $id]);

        if ($blog) {
            // dd($_POST);
            foreach ($data as $key => $value) {
                $blog[$key] = $value;
            }
            return (Article::exec_update($blog, ['id' => $id]));
        }

        return false;
        // var_dump($blog);die;
    }
}