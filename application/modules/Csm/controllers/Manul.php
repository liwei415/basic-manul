<?php

class ManulController extends \Our\Controller\Csm {

    // 入口方法
    public function postAction() {

        echo "-------------begin csm-------------------\n";
        $hdl = new \Rd\Service\Hdl\Manul\Post();
        $hdl->consumer();
        echo "-------------end csm-------------------\n";
    }


}