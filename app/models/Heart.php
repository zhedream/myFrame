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
     * 回写到 MySQL
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
}