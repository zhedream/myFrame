<?php

namespace libs;

class Log {

    private $fp = null;

    public function __construct($fileName) {
        $this->fp = fopen(ROOT . 'logs/' . $fileName . '.log', 'a');
    }

    /**
     *
     */
    public function log($content) {

        fwrite($this->fp, str_repeat('-', 100) . PHP_EOL . date("Y-m-d H:i:s") . PHP_EOL . PHP_EOL . $content . PHP_EOL);
    }


}


?>