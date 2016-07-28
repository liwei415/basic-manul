<?php
namespace Rd\Service\Api\Sms;

class Post {

    private $var_ = null;

    public function __construct($var) {
        $this->var_ = $var;
    }

    private function error_($code, $data = null) {

        $rst = array();
        $rst['code'] = $code;
        $rst['msg'] = \Our\Error::getErrorMsg($code);
        $rst['data'] = null;

        if ($data) $rst['msg'] = $data;

        return json_encode($rst);
    }

    private function success_($data = null) {

        $rst = array();
        $rst['code'] = 0;
        $rst['msg'] = 'success';
        $rst['data'] = $data;

        return json_encode($rst);
    }

    public function run() {

        // vo
        $vo = new \Rd\Vo\In\Sms\Post($this->var_->data);

        if (!is_object($vo)) {
            return $this->error_(1003, $vo);
        }
        if (!$vo->validate()) {
            return $this->error_(1002, $vo->getError());
        }

        $bz = new \Rd\Service\Hdl\Sms\Post($vo);
        return $this->success_($bz->producer());
    }


}