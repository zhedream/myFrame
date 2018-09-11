<?php

namespace app\Models;
use Core\Model;
use core\RD;
use core\DB;

class Article extends Model{

    static function get($id){

        return RD::chache('Articles:'.$id,60,function()use($id){
            return self::findOne("select * from articles where id=?",[$id]);
        });
    }

    function increase($id){
        ob_clean(); // 清空缓存区
        if(self::$redis->hexists ('Hash:Aricles:display',$id))
            return self::$redis->hincrby('Hash:Aricles:display',$id,1);
        
        $num = self::findOneFirst('select display from articles where id=?',[$id]);
        if($num!==null){
            
            self::$redis->hset('Hash:Aricles:display',$id,(int)$num);
            return self::$redis->hincrby('Hash:Aricles:display',$id,1);
        }
        return false;
    }

    /**
     * 读取/刷新 用户空间 文章
     * 1. 用户 user_id
     * 2. 覆盖刷新
     * return blogs
     */
    function allUserBlog($user_id,$cover = false){

        return RD::chache('Articles_user:'.$user_id,60,function()use($user_id){
            return self::findAll("select * from articles where user_id=?",[$user_id]);
        },$cover);

    }

    function store(){

        $title = $_POST['title'];
        $description = getChar( rand(20,100) ) ;
        $content = $_POST['content'];
        $display = rand(10,500);

        $accessable = $_POST['accessable'];
        $type = rand(1,11);
        $date = rand(1233333399,1535592288);
        $date = date('Y-m-d H:i:s');
        $user_id = $_SESSION['user_id'];

        return DB::exec("INSERT INTO `articles` (`title`,`description`,`content`,`display`,`accessable`,`type`,`created_at`,`user_id`) VALUES(?,?,?,?,?,?,?,? )"
                ,[$title,$description,$content,$display,$accessable,$type,$date,$user_id]);
    }

    function del($id){
        // DELETE FROM 表名称 WHERE 列名称 = 值
        return DB::exec("DELETE FROM `articles` WHERE `id` = ?",[$id]);
    }

    /**
     * 更新数据
     * 1. id
     * 2. 数据
     */
    function update($id,$data){
        // dd($data);
        $blog = Article::findOne(" select * from ".$this->table()." where user_id=? and id=? ",[$_SESSION['user_id'],$id]);

		if($blog){
            // dd($_POST);
            foreach ($data as $key => $value) {
                $blog[$key] = $value;
            }
            return( Article::exec_update($blog,['id'=>$id]));
        }

        return false;
        // var_dump($blog);die;
    }
}