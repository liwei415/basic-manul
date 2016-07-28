<?php
namespace Our\Controller;

abstract class Api extends \Yaf\Controller_Abstract {

    protected $argv = NULL;

    public function init() {
        \Yaf\Dispatcher::getInstance()->disableView();
    }


}
