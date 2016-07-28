<?php
namespace Our;
/**
 * @desc: 文件描述
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月20日 下午5:40:00
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
class Http{
    
    private static $_instance = NULL;
    
    /**
     * 单例模式，构造函数私有
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月20日 下午5:41:02
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private function __construct(){
    }
    /**
     * 单例模式，禁止clone
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月20日 下午5:44:54
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function __clone(){
        trigger_error('Clone is not allow!', E_USER_ERROR);
    }
    /**
     * 单例模式，提供唯一的方法实例对象
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月20日 下午5:46:20
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public static final function getInstance(){
        if(!(self::$_instance instanceof self)){
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    /**
     * 获得远程URL数据
     * @param $url 请求的url
     * @param $params 请求参数
     * @param $timeout 允许执行的最长秒数
     * @param $extParams 请求时的cookie信息
     * @date   : 2016年6月20日 下午5:42:41
     * @vesion : 2.0.0.0
     */
    public function request($url, $method = "GET", $params = array(), $timeout = 30, $extParams = array()){
        //1.组装请求数据
        $paramString = http_build_query($params, '', '&');
        if (strtoupper($method) == "GET" && $params) {
            $url .= "?" . $paramString;
        }
        //2.初始化curl
        $ch = curl_init($url);
        if (strtoupper($method) == "POST") {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $paramString);
        }
        
        //3.配置请求参数
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        
        if (!empty($extParams["cookies"])) {
            curl_setopt($ch, CURLOPT_COOKIE, $this->analyzeCookie($extParams["cookies"]));
        }
        
        //检测是否是https访问
        if (strpos($url, 'https') === 0) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        }
        
        //4.发起类似浏览器的请求，并获得结果
        $result = curl_exec($ch);
        
        //5.如果出错记录日志
        if (curl_errno($ch)) {
            \Our\Log::getInstance()->write('请求http接口失败，请求url:' . $url . '，Curl error: ' . curl_error($ch));
            return false;
        }
        
        //6.释放资源
        curl_close($ch);
        
        return $result;
    }
    /**
     * 解析cookie数组，转换成字符串形式
     * @param $cookies 参数变量
     * @return 
     * @date   : 2016年6月21日 上午11:08:27
     * @vesion : 2.0.0.0
     */
    public function analyzeCookie($cookies) {
        $cookie = '';
        foreach ($cookies as $key => $value) {
            $cookie = $key . '=' . $value . '; ';
        }
        return substr($cookie, 0, strlen($cookie) - 2);
    }
}