<?php

class ManulController extends \Our\Controller\Rpc {

    // 入口方法
    public function indexAction() {

        $rpc =  new \Rd\Service\Rpc\Manul\Server();
        $rpc->run();
    }


}
