<?php
namespace Http;
use Our\Http;
/**
 * @desc: http数据来源抽象类
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月21日 上午11:03:35
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
abstract class AbstractModel {

    private $link = NULL;
    protected $host = NULL;
    /**
     *  功能描述
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月21日 上午11:58:13
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    abstract protected function getUrlConfig();
   
    /**
     * get方式获得http数据
     * @param string $url
     * @param string $method
     * @param array $params
     * @param int $timeout
     * @param array $extParams 扩展的参数信息，可以是cookie之类
     * @date   : 2016年6月21日 上午11:23:56
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function get($url,$params = array(), $timeout = 30, $extParams = array()) {
        $this->host = \Bootstrap::getUrlIniConfig($this->getUrlConfig(),'host');
        $url = $this->_getUrl($this->host, $url); 
        $this->link = Http::getInstance();
        return $this->link->request($url, "GET", $params, $timeout, $extParams);
        
    }
    /**
     * POST方式发起http数据
     * @param string $url
     * @param string $method
     * @param array $params
     * @param int $timeout
     * @param array $extParams 扩展的参数信息，可以是cookie之类
     * @date   : 2016年6月21日 上午11:25:20
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function post($url,$params = array(), $timeout = 30, $extParams = array()){
        $this->host = \Bootstrap::getUrlIniConfig($this->getUrlConfig(),'host');
        $url = $this->_getUrl($this->host, $url);
        $this->link = Http::getInstance();
        return $this->link->request($url, "POST", $params, $timeout, $extParams);
    }
    /**
     * 获得真实的url
     * @date   : 2016年6月21日 下午2:59:19
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private function _getUrl($host,$url){
        $pos = stripos($url, $host);
        if($pos >= 0){
            $parsearr = parse_url($url);
            $url = $parsearr['path'];
        }
        $url = rtrim($host,'/').DS.ltrim($url,'/');
        return $url;
    }
}
