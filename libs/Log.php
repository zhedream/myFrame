<?php

namespace libs;

class Log {

    private $fp = null;

    public function __construct($fileName) {
        $directory = ROOT . 'logs/';
        if (!is_dir($directory) && !mkdir($directory, 0775, true) && !is_dir($directory)) {
            throw new \RuntimeException('Cannot create log directory');
        }
        $this->fp = fopen($directory . $fileName . '.log', 'a');
        if ($this->fp === false) {
            throw new \RuntimeException('Cannot open log file');
        }
    }

    /**
     *
     */
    public function log($content) {

        fwrite($this->fp, str_repeat('-', 100) . PHP_EOL . date("Y-m-d H:i:s") . PHP_EOL . PHP_EOL . $content . PHP_EOL);
    }


}


?>