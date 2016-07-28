<?php
namespace Rd\Service\Rpc\Sms;

// todo 试一试去掉哪个可以正常运行
require_once realpath(dirname(__FILE__)) . '/gen-php/rpc/sms/ISmsRemoteService.php';
require_once realpath(dirname(__FILE__)) . '/gen-php/rpc/sms/Types.php';

class Handler implements \rpc\sms\ISmsRemoteServiceIf {

    private function error_(\rpc\sms\PostResponse $rst, $code, $data = null) {

        $rst->code = $code;
        $rst->msg = \Our\Error::getErrorMsg($code);
        $rst->data = null;

        if ($data) $rst->msg = $data;

        return $rst;
    }

    private function success_(\rpc\sms\PostResponse $rst, $data = null) {

        $rst->code = 0;
        $rst->msg = 'success';
        $rst->data = $data;

        return $rst;
    }

    public function post(\rpc\sms\CommonRequest $p1, \rpc\sms\PostRequest $p2) {

        $rst = new \rpc\sms\PostResponse();

        // vo
        $vo = new \Rd\Vo\In\Sms\Post($p2);

        if (!is_object($vo)) {
            return $this->error_($rst, 1003);
        }
        if (!$vo->validate()) {
            return $this->error_($rst, 1002, $vo->getError());
        }

        $bz = new \Rd\Service\Hdl\Sms\Post($vo);

        return $this->success_($rst, $bz->producer());
    }


}
