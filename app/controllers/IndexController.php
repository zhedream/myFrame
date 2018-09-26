<?php

namespace app\controllers;

use core\Request;
use app\models\Index;

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