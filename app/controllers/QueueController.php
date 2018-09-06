<?php 
namespace app\controllers;
use Core\DB;
use Core\RD;

class QueueController{

    function sendmail(){
        ini_set('default_socket_timeout', -1);
        while(1)
            var_dump(RD::boqueue(__FUNCTION__));
    }

    function a(){
        echo '123';
    }

}

 ?>