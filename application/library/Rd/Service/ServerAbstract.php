<?php
namespace Rd\Service;

abstract class ServerAbstract{
    
    protected function error_($code, $msg = null, $data = NULL) {
    
        $rst = array();
        $rst['code'] = $code;
        $rst['msg'] = \Our\Error::getErrorMsg($code);
        $rst['data'] = $data;
        return json_encode($rst);
    }
    
    protected function success_($data = null) {
        $rst = array();
        $rst['code'] = 0;
        $rst['msg'] = 'success';
        $rst['data'] = $data;
        return json_encode($rst);
    }
    
    abstract public function run();
} 
