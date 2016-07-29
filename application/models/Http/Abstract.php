<?php
namespace Http;

use Our\Http;

abstract class AbstractModel {

    private $link = NULL;
    protected $host = NULL;

    abstract protected function getHost();

    public function get($url,$params = array(), $timeout = 30, $extParams = array()) {
        $this->host = \Bootstrap::getUrlIniConfig($this->getHost(),'host');
        $url = $this->_getUrl($this->host, $url);
        $this->link = Http::getInstance();
        return $this->link->request($url, "GET", $params, $timeout, $extParams);
    }

    public function post($url, $params = array(), $timeout = 30, $extParams = array()){
        $this->host = \Bootstrap::getUrlIniConfig($this->getHost(),'host');
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
