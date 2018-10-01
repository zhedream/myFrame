<?php

namespace app\controllers;

use core\Request;
use app\models\Index;
use app\models\User;
use app\models\GoodsAttribute;

class IndexController extends Controller {

    // 显示列表
    function index() {
        $index = new Index;
        $info = $index->welcome();
        view('index.index');
    }

    function top () {

        view('index.top');
    }

    function test() {

        $user = new User;
        
        $user->fill(['email'=>'123','name'=>'河是德国','money'=>0,'avatar'=>'asdf','password'=>md5('123123')]);

        $user->dd = 1;
        // dd($user->dd);
        // var_dump($user);die;
        // $data = $user->whereIn('id',[1])
            // ->toSql();
            // ->get();
        // dd($data);die;
        $data = [
            'asd'=>123,
        ];
        // $data =  $user->findOne('select * from users where id=?',[1]);
        // dd($data);
        // $user->otest(['id','<=',2]);
        // dd(1,false);
        $data = $user
                // ->where(['id'=>1])
                // ->where('money','>=',3)
                ->Where('name','LIKE',"%liu%")
                // ->where('display3','LIKE',"'%title%'")
                // ->orWhere(['a'=>4])
                // ->orWhere('b','NOT LIKE',"'%asd%'")
                // ->orWhere('c',6)
                // ->whereIn('d',[6,99],'not')
                // ->whereIn('id',function($s){
                //     // 'select `user_id` from users'
                //     return $s->where('display','>=',2)->orWhereIn('id',[123,2],true);
                // })
                // ->whereIn('d',function(){})
                // ->toSql();
                ->get();
        dd($data);
    }

    function menu () {

        view('index.menu');
    }

    function main () {

        view('index.main');
    }

    // 显示 添加页
    function add(){

        view('index.create');
    }

    // 添加
    function insert(Request $req,$id) {
        
        
    }

    // 删除
    function del(Request $req,$id){
        

    }
    
    // 显示 修改页
    function mod(){
        
        view('index.edit');
    }

    // 修改
    function update(Request $req,$id) {


    }

    // 搜索
    function search(Request $req,$id){


    }

}

?>