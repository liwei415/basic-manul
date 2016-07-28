<?php

namespace Our;

class Error {

    private static $codes = array('1000' => 'method does not exist',
                                  '1001' => 'service does not exist',
                                  '1002' => '入参错误',
                                  '1003' => 'object is null',
                                  '1004' => 'bonus is not exist',
                                  '1005' => 'bonus is unexpire',
                                  '1006' => 'bonus had gotted',
                                  '1007' => 'bonus is finished',
                                  '9995' => 'version is error',
                                  '9996' => 'init method is error',
                                  '9997' => 'token is not exist',
                                  '9998' => 'Illegal sources',
                                  '9999' => 'errors in the input parameters'
                            );

    public static function getErrorMsg($code) {
        return self::$codes[$code];
    }

    public static function getMsg($code,$data = array()) {
        $error = array();
        $error['code'] = $code;
        $error['msg'] = self::$codes[$code];
        $error['data'] = $data;
        return json_encode($error);
    }
}
