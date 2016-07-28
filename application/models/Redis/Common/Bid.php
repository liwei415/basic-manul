<?php
namespace Redis\Common;
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
 * @date: 2016年6月23日 上午11:18:02
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
class BidModel extends \Redis\AbstractModel{
    
    /**
     * 继承父类方法
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月23日 上午11:24:01
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    protected function getConfigKey(){
        return 'common';
    }
    /**
     * set
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月23日 上午11:24:24
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function set($key,$value,$cache_time=NULL){
        return $this->_set($key,$value,$cache_time);
    }
    /**
     * get
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月23日 上午11:26:11
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function get($key){
        return $this->_get($key);
    }
}