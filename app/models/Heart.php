<?php

namespace app\Models;

use Core\Model;
use Core\RD;

class Heart extends Model {

    function get() {
        // code
    }

    /**
     * 用户 点赞 文章
     * 
     * 点赞取反
     */
    function UheartA(int $user_id,int $article_id) {

        $redis = self::$redis;
        $set = 'Set:Userpraise:'.$user_id; // 用户喜欢
        $set2 = 'Set:heartOfArticle:'.$article_id; // 文章 点赞者

        if($redis->sismember($set,$article_id)){

            $redis->srem($set,$article_id); // 移出 用户 喜欢
            $redis->srem($set2,$user_id); // 移出 user from article
            $count = $redis->scard($set2);
            RD::setHash('Aricles:heart',$article_id,$count);
            // dd($count);
            return $count; // 返回 文章的赞
        }
        else{

            $redis->sadd($set,$article_id); // 添加 用户 喜欢
            $redis->sadd($set2,$user_id); // 添加 user to article
            $count = $redis->scard($set2);
            RD::setHash('Aricles:heart',$article_id,$count);
            // dd($count);
            return $count; // 返回 文章的赞
        }
    }

    /**
     * 获取 文章heart 数量
     * 
     */
    function getHeartCount(int $article_id){
        // self::$redis->hget
        $set2 = 'Set:heartOfArticle:'.$article_id;
        return RD::getHash('Aricles:heart',$article_id);
    }

    /**
     * 读取到 redis
     * 
     */
    function readHeart(){

        $hearts = self::findAll('select * from hearts');
        $redis=  self::$redis;

        RD::delMatch('Set:Userpraise:*'); // 删除 
        RD::delMatch('Set:heartOfArticle:*');
        RD::delMatch('Hash:Aricles:heart');

        foreach ($hearts as $key => $value) {

            $article_id = $value['article_id'];
            $user_id = $value['user_id'];

            $set = 'Set:Userpraise:'.$user_id;
            $set2 = 'Set:heartOfArticle:'.$article_id;

            $redis->sadd($set,$article_id); // 添加 用户 喜欢
            $redis->sadd($set2,$user_id); // 添加 user to article

            $count = $redis->scard($set2);
            RD::setHash('Aricles:heart',$article_id,$count);
        }

        return true;
    }

    /**
     * 回写到 MySQL
     * 
     * 
     */
    function writeHeart(){

        $redis = self::$redis;
        $H = new Heart;
        $pdo = Heart::$pdo;
        $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_WARNING);


        $keys = $redis->keys('Set:Userpraise:*');

        foreach ($keys as $value) {
            preg_match("/^Set:Userpraise:(\d+)$/",$value,$matches);
            // dd($matches);
            $key = $matches[0];
            $user_id = $matches[1];
            $data = $redis->smembers($key);
            dd($data);
            echo $matches[1]."<br>";
        }

        die;
        $data = $keys[0];

        preg_match("/Set:Userpraise:(\d+)/",$data,$matches);
        dd($data);

        dd($keys);

    }
}