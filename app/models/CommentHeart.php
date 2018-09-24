<?php

namespace app\Models;

use Core\Model;

class CommentHeart extends Model {

    function insert($id) {
        $data = [
            'asd'=>1
        ];
        self::exec_insert($data);
    }
}