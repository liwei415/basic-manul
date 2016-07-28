<?php

namespace Our;

class Common {

    /**
     * 获取http状态码
     * 
     * @param int $num 
     * @return string
     */
    public static function getHttpStatusCode($num) {
        $httpStatusCodes = array(
            100 => "HTTP/1.1 100 Continue",
            101 => "HTTP/1.1 101 Switching Protocols",
            200 => "HTTP/1.1 200 OK",
            201 => "HTTP/1.1 201 Created",
            202 => "HTTP/1.1 202 Accepted",
            203 => "HTTP/1.1 203 Non-Authoritative Information",
            204 => "HTTP/1.1 204 No Content",
            205 => "HTTP/1.1 205 Reset Content",
            206 => "HTTP/1.1 206 Partial Content",
            300 => "HTTP/1.1 300 Multiple Choices",
            301 => "HTTP/1.1 301 Moved Permanently",
            302 => "HTTP/1.1 302 Found",
            303 => "HTTP/1.1 303 See Other",
            304 => "HTTP/1.1 304 Not Modified",
            305 => "HTTP/1.1 305 Use Proxy",
            307 => "HTTP/1.1 307 Temporary Redirect",
            400 => "HTTP/1.1 400 Bad Request",
            401 => "HTTP/1.1 401 Unauthorized",
            402 => "HTTP/1.1 402 Payment Required",
            403 => "HTTP/1.1 403 Forbidden",
            404 => "HTTP/1.1 404 Not Found",
            405 => "HTTP/1.1 405 Method Not Allowed",
            406 => "HTTP/1.1 406 Not Acceptable",
            407 => "HTTP/1.1 407 Proxy Authentication Required",
            408 => "HTTP/1.1 408 Request Time-out",
            409 => "HTTP/1.1 409 Conflict",
            410 => "HTTP/1.1 410 Gone",
            411 => "HTTP/1.1 411 Length Required",
            412 => "HTTP/1.1 412 Precondition Failed",
            413 => "HTTP/1.1 413 Request Entity Too Large",
            414 => "HTTP/1.1 414 Request-URI Too Large",
            415 => "HTTP/1.1 415 Unsupported Media Type",
            416 => "HTTP/1.1 416 Requested range not satisfiable",
            417 => "HTTP/1.1 417 Expectation Failed",
            500 => "HTTP/1.1 500 Internal Server Error",
            501 => "HTTP/1.1 501 Not Implemented",
            502 => "HTTP/1.1 502 Bad Gateway",
            503 => "HTTP/1.1 503 Service Unavailable",
            504 => "HTTP/1.1 504 Gateway Time-out"
        );

        return isset($httpStatusCodes[$num]) ? $httpStatusCodes[$num] : '';
    }

    /**
     * 获取客户端IP
     *
     * @param  boolean $checkProxy
     * @return string
     */
    public static function getClientIp($checkProxy = true) {
        if ($checkProxy && isset($_SERVER['HTTP_CLIENT_IP']) && $_SERVER['HTTP_CLIENT_IP'] != null) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } else if ($checkProxy && isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != null) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    /**
     * 获取当前访问的url地址
     * 
     * @return string
     */
    public static function getRequestUrl() {
        return 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    /**
     * 公用算法公式，目前仅适用于加减乘除四则运算
     * @param unknown $e
     * @param number $b 保留几位小数 最大6位
     * @param number $c 0:舍位 1:四舍五入
     * @return number
     * @author : wangkelin <wangkelin@roadoor.com>
     * @date   : 2016-07-13 18:00:00
     * @vesion : 2.0.0.0
     */
    public static function rdexp($e, $b = 2, $c = 0)
    {
        // 1.初始化表达式
        $e = '('.str_replace(' ', '', $e).')';

        $r = 0;
        while (preg_match('/\([0-9\.\+\-\*\/]+\)/', $e, $m)) {
            $r = self::rdexp_recursion_basic($m[0]);
            $e = str_replace($m[0], $r, $e);
//         var_dump($e);
        }

        $b = pow(10, $b);
        switch ($c) {
            case 0 :
                $t = floor(strval($r)*$b)/$b;
                break;
            case 1 :
                $t = ceil(strval($r)*$b)/$b;
                break;
            default :
                $t = 0;
        }

        return $t;
    }

    /**
     * 展开递归
     * @param unknown $e
     * @author : wangkelin <wangkelin@roadoor.com>
     * @date   :  2016-07-13 18:00:00
     * @vesion : 2.0.0.0
     */
    public static function rdexp_recursion_basic($e)
    {
        $r = 0;

        //处理乘除法
        while (preg_match('/([\d\.]+)([\*\/])([\d\.]+)/', $e, $m)) {
            switch ($m[2]) {
                case '*' :
                    $t = $m[1] * $m[3];
                    break;
                case '/' :
                    $t = $m[1] / $m[3];
                    break;
                default :
                    $t = 0;
            }
            $e = str_replace($m[0], $t, $e);
        }

        //处理加减
        while (preg_match('/([\d\.]+)([\+\-])([\d\.]+)/', $e, $m)) {
            switch ($m[2]) {
                case '+' :
                    $t = (floor(strval($m[1]*10000000)) + floor(strval($m[3]*10000000)))/10000000;
                    break;
                case '-' :
                    $t = (floor(strval($m[1]*10000000)) - floor(strval($m[3]*10000000)))/10000000;
                    break;
                default :
                    $t = 0;
            }
            $e = str_replace($m[0], $t, $e);
        }

        if (preg_match('/([\d\.]+)/', $e, $m)) {
            $r = $m[1];
        }
        else {
            $r = 0;
        }

        return $r;
    }
}
