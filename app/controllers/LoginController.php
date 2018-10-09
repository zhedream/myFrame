<?php

namespace app\controllers;

use core\Request;
use app\Requests\LoginRequest;
use app\Models\Admin;

class LoginController extends Controller {

    public function index(){
        
        view('login.login');
    }

    public function login(Request $req){
        $data = $req->all();
        var_dump($data);
        $data['password'] = md5($req->password);
        $admin = new Admin;
        $admin->fill($data);
        $data = $admin->where($admin->getFillData())->get();
        dd($data,false);
    }   

}

?>