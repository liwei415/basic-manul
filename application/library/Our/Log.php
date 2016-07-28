<?php

namespace Our;

class Log {

    private static $_instance = null;
    private $_handle = null;

    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function write($message) {
        fwrite($this->getHandle(), date("Y-m-d H:i:s")
                . "\t" . $message
                . "\turi:" . $_SERVER['REQUEST_URI']
                . "\tref:" . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '')
                . "\r\n");
    }

    public function getHandle() {
        if (!$this->_handle) {
            $this->_handle = fopen(APPLICATION_PATH . '/data/log/app.log', 'a');
        }
        return $this->_handle;
    }


}
