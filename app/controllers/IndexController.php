<?php

namespace app\controllers;

use core\Request;
use app\models\Index;
use app\models\User;

class IndexController extends Controller {

    // 显示列表
    function index() {
        $index = new Index;
        $info = $index->welcome();
        view('index.index',['info'=>$info]);
    }

    function top () {

        view('index.top');
    }

    function test() {
        $index = new User;
        $data = [
            'asd'=>123,
        ];
        // $data =  $index->findOne('select * from users where id=?',[1]);
        // dd($data);
        // $index->otest(['id','<=',2]);
        // dd(1,false);
        $data = $index->where(['id'=>1])
                ->where('display2',2)
                ->where('display3','<=',3)
                ->where('display3','LIKE',"'%title%'")
                ->orWhere(['a'=>4])
                ->orWhere('b','NOT LIKE',"'%asd%'")
                ->orWhere('c',6)
                ->whereIn('d',[6,99],'not')
                ->whereIn('id',function($s){
                    // 'select `user_id` from users'
                    return $s->where('display','>=',2)->orWhereIn('id',[123,2],true);
                })
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