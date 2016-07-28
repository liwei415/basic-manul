<?php

namespace Our\Controller;

abstract class Rpc extends \Yaf\Controller_Abstract {

    /**
     * rpc控制器直接输出json格式数据，不需要渲染视图
     */
    public function init() {
        \Yaf\Dispatcher::getInstance()->disableView();
    }

}
