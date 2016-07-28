<?php

class ManulController extends \Our\Controller\Api {

    // 入口方法
    public function indexAction() {

        $argv = '{"version":"1.0.0","method":"usra","source":"pc","data":{"uid":"111222335","name":"周建军","type":"P", "cert":"P01", "cert_no":"342524198508010010", "mobile":"18616895697"}}';

        $o = json_decode($argv);
        $api = \Rd\Service\Api\Manul\FManul::factory($o);
        echo $api->run();
    }


}