<?php

namespace app\Models;

use Core\Model;
use Core\RD;

class Comment extends Model {


    /**
     * 添加 一条评论
     */
    function insert($data){

        $data = [
            'article_id'=>$i,
            'user_id'=>$_SESSION['user_id'],
            'content'=>$content,
            'created_at'=>date('Y:m:d G-i-s')
        ];
        return self::exec_insert($data);

    }

    /**
     * 删除一条评论
     */
    function delete($article_id,$user_id){

        return self::exec_delete(['article_id'=>$article_id,'user_id'=>$user_id]);
    }

    /**
     * 获取文章所有 评论
     * 1. 文章ID
     * 2. 强制覆盖更新
     */
    function get($article_id,$cover = false,$json = true) {

        return RD::chache('article:comment:'.$article_id,60,function()use($article_id){
            $sql = "SELECT comments.*,users.avatar,users.email FROM `comments` LEFT JOIN `users` ON `users`.`id`=comments.user_id WHERE `comments`.`article_id`=?";
            return self::findAll($sql,[$article_id]);
        },$cover,$json);
        
    }
    
    /**
     * 获取 最热评论
     */
    function getHot($article_id){
        $sql = "SELECT comment_hearts.*,users.avatar,users.email FROM `comment_hearts` LEFT JOIN `users` ON `users`.`id`=comment_hearts.user_id WHERE `comment_hearts`.`article_id`=? ";

        return self::findAll($sql,[$article_id]);
    }

    /**
     * 获取 最新 评论
     */
    function getNew($article_id) {

    }
    
}