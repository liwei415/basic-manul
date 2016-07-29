<?php

namespace Our;

class Manul {

    private static $_instance = NULL;
    private $_link = NULL;
    private $_host = NULL;
    private $_port = NULL;
    private $_token = NULL;

    public function __construct() {
        $conf = \Yaf\Registry::get('config')->get('resources.manul.params');
        if (!$conf) {
            throw new Exception('manul连接必须设置');
        }

        $params = $conf->toArray();
        $this->_host = $params['host'];
        $this->_port = $params['port'];
        $this->_token = $params['token'];
    }

    public function call($interface, $params = array()) {

        //1.组装请求数据
        $params['token'] = $this->_token;

        $jparams = json_encode($params);

        //2.初始化curl
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jparams);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8','Content-Length: '.strlen($data_string)));

        //3.配置请求参数
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);

        //4.发起类似浏览器的请求，并获得结果
        $result = curl_exec($ch);

        //5.如果出错记录日志
        if (curl_errno($ch)) {
            \Our\Log::getInstance()->write('请求manul接口失败，Curl error: ' . curl_error($ch));
            return false;
        }

        //6.释放资源
        curl_close($ch);

        return $result;
    }


}