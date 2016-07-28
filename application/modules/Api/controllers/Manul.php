<?php

class ManulController extends \Our\Controller\Api {

    // 入口方法
    public function indexAction() {

//        $argv = '{"version":"1.0.0","method":"post","source":"pc","data":{"ophone":"13000000000","iphone":"18600000000","content":"sb","channel":"1", "delay":"1971-01-01 00:00:01"}}';
//        $o = json_decode($argv);
        $api = \Rd\Service\Api\Manul\FManul::factory($this->argv);
        echo $api->run();
    }


}