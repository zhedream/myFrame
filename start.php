<?php

define("ACCESS", true);// 入口标识
define('ROOT', dirname(__FILE__) ); // 根目录 不带 /   /../
define('HEARTBEAT_TIME', 1000); // 设置心跳 时间
// require_once ROOT . "vendor/autoload.php"; // 加载 vendor
// require_once ROOT . "/core/App.php"; // 核心APP 入口
require_once ROOT . "/core/Loader.php";
require_once ROOT . "/core/CoreFn.php"; // 核心辅助全局函数

// use core\Route;
use Workerman\Lib\Timer;
use Workerman\Worker;
// require_once './Workerman/Autoloader.php';
$global_uid = 0;
 
// 当客户端连上来时分配uid,自动保存连接, 并通知所有客户端
function handle_connect($connection) {
    global $ws_worker, $global_uid;
    // 为这个链接分配一个uid
    $connection->uid = ++$global_uid;

    sendAll('userConnect',[
        'msg'=>"我上线了 Online",
        'uid'=>$connection->uid,
    ]);
}

// 当客户端断开时,广播给所有客户端
function handle_close($connection) {
    global $ws_worker;
    sendAll('userClose',[
        'msg'=>"我离开了 Doneline",
        'uid'=>$connection->uid,
    ]);
}

// 当客户端发 动作 过来时，转发给所有人
function handle_message($connection, $data) {
    
    // 路由 转发到 函数
    $connection->lastMessageTime = time(); //  心跳 存储 最后通讯时间
    global $ws_worker;

    $data = json_decode($data);
    sendAll('message',[
        'uid'=>$connection->uid,
        'msg'=>$data->data,
    ]);

}
/**
 *  广播所有
 * 1. 动作
 * 2. 消息
 */
function sendAll($action,$data){
    global $ws_worker;
    $data = [
        'action'=>$action,
        'data'=>$data,
    ];

    foreach ($ws_worker->connections as $conn) {
        $conn->send(json_encode($data));
    }
}
function sendOne($action,$data,$conn){
    global $ws_worker;
    $data = [
        'action'=>$action,
        'data'=>$data,
    ];

    $conn->send(json_encode($data));
}


 // ws 协议
$ws_worker = new Worker("websocket://0.0.0.0:2347");
 
$ws_worker->count = 1;
 

$ws_worker->onWorkerStart = function($ws_worker) {

    // 定时 验证心跳
    Timer::add(1, function()use($ws_worker){
        $time_now = time();
        foreach($ws_worker->connections as $connection) {
            // 有可能该connection还没收到过消息，则lastMessageTime设置为当前时间
            if (empty($connection->lastMessageTime)) {
                $connection->lastMessageTime = $time_now;
                continue;
            }
            // 上次通讯时间间隔大于心跳间隔，则认为客户端已经下线，关闭连接
            if ($time_now - $connection->lastMessageTime > HEARTBEAT_TIME) {
                $connection->close();
            }
        }
    });
    echo 'workerman Start';
};
$ws_worker->onConnect  = 'handle_connect';
$ws_worker->onMessage = 'handle_message';
$ws_worker->onClose = 'handle_close';
$ws_worker->onClose = 'handle_close';

 
Worker::runAll();
