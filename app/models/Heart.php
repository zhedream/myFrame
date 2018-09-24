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

        A: if($redis->sismember($set,$article_id)){
            
            $redis->srem($set,$article_id); // 移出 用户 喜欢
            $redis->srem($set2,$user_id); // 移出 user from article
            $this->delHeartTop($article_id,$user_id); // 移出 点赞 TOP 10
            $count = $redis->scard($set2);
            RD::setHash('Aricles:heart',$article_id,$count);
            // dd($count);
            return $count; // 返回 文章的赞con'te
        }
        else{
            
            // 是否 同步过 数据库  , 如果 保证 程序运行 无误  不用 这个环节
            if(!$redis->exists($set)){

                // 同步 数据库 没有 插入 -1 
                $this->readHeartU($user_id);
                goto A;
            }

            
            $redis->sadd($set,$article_id); // 添加 用户 喜欢
            $redis->sadd($set2,$user_id); // 添加 user to article
            $count = $redis->scard($set2);
            if($count<10)
                $this->setHeartTop($article_id,$user_id,$count); // 设置 点赞 TOP 10
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
     * 
     * 同步 用户 heart
     * 
     * 
     */
    function readHeartU($user_id) {

        $articles_id = self::findAll('select article_id from hearts where user_id=?',[$user_id]);
        $set = 'Set:Userpraise:'.$user_id;
        if($articles_id)
            foreach ($articles_id as $key => $article_id) {
                $set2 = 'Set:heartOfArticle:'.$article_id['article_id'];
                self::$redis->sadd($set,$article_id['article_id']); // 添加 用户 喜欢
                self::$redis->sadd($set2,$user_id); // 添加 user to article
            }
        else
            self::$redis->sadd($set,-1); // 添加 用户 喜欢  读取标记 -1
        
    }

    /**
     * 回写 点赞 到 MySQL 
     * 
     * 
     */
    function writeHeart(){

        $redis = self::$redis;
        $H = new Heart;

        $keys = $redis->keys('Set:Userpraise:*'); // 用户 点赞 集合
        
        foreach ($keys as $value) {
            preg_match("/^Set:Userpraise:(\d+)$/",$value,$matches);
            $key = $matches[0];
            $user_id = $matches[1];
            $articles_id = $redis->smembers($key); // 用户 的所有点赞 文章

            // 断电 事务 
            $aa = self::TransactionCall(function()use($user_id,$articles_id){

                // 1. 清空 用户喜欢;
                $res1 = Heart::exec_delete(['user_id'=>$user_id]);
                // 2. 回写 用户 喜欢 
                foreach ($articles_id as  $article_id) {
                    $data = [
                        'article_id'=>$article_id,
                        'user_id'=>$user_id,
                    ];
                    $return = Heart::exec_insert($data);
                    // dd($data);
                }
                // dd($user_id);
                return true;
            });

            var_dump($user_id,$aa);

        }

    }

    /**
     * 获取 文章 前十 的点赞
     */
    function getHeartTop($article_id){
        // $sql  = "SELECT `avatar`,`email`,`name` FROM hearts LEFT JOIN users ON hearts.user_id = users.id WHERE hearts.article_id = ? ORDER BY hearts.created_at LIMIT 10;";
        $users = RD::chache('getHeartTop:'.$article_id,60,function()use($article_id){
            $set = "ZSet:Artilce:Heart:".$article_id;
            $data = self::$redis->zrange($set,0,-1);
            $da = [];
            foreach ($data as $key => $id)
                $da[] =  self::findOne('SELECT * FROM users WHERE id=?',[$id]);
            return $da;
        });

        return $users;
    }
    /**
     * 移出 文章 前十 的点赞
     * 1. 文章 ID
     * 2. 用户 ID
     */
    function delHeartTop($article_id,$user_id){
        $set = "ZSet:Artilce:Heart:".$article_id;
        self::$redis->zrem($set,$user_id);
        $this->readHeartTop($article_id);
        return true;
    }
    /**
     * 设置 文章 前十 点赞  for redis  只会 在 点赞 前 10 个 启用
     * 1. 文章 ID
     * 2. 用户 ID
     */
    function setHeartTop($article_id,$user_id,$count){
        $redis = self::$redis;
        $set = "ZSet:Artilce:Heart:".$article_id;
        // $count = $redis->zcard($set);
        $ex = $redis->exists($set);
        // dd($ex);
        if(!$ex){
            $this->readHeartTop($article_id);
            // $count = $redis->zcard($set);
        }
        if($count<10){
            // zset 重新排序  设置 最后个 index   
            RD::sortZSet($set);
            $redis->zadd($set,$count,$user_id); //覆盖排序 
        }
        return true;
    }

    /**
     * 读 heartTOP from mysql  定时
     * 1. 文章 ID
     */
    function readHeartTop($article_id) {
        $set = "ZSet:Artilce:Heart:".$article_id;
        $sql  = "SELECT `hearts`.`user_id` FROM `hearts` WHERE `hearts`.`article_id` = ? ORDER BY `hearts`.`created_at` LIMIT 10;";

        $data = RD::chache('readHeartTop:'.$article_id,3600,function()use($sql,$article_id) {
            return self::findOneFirsts($sql,[$article_id]);
        });

        if($data){
            foreach ($data as $key => $user_id) {
                // dd($user);
                self::$redis->zadd($set,$key,$user_id);
            }
        }
    }








}