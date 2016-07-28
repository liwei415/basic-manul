<?php
namespace Redis;
/**
 * @desc: redis抽象类，所以子类必须继承它
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月23日 上午10:53:26
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
abstract class  AbstractModel{
    
    private $_link = NULL;
    private static $_redis_obj = NULL;
    /**
     * 子类必须继续
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月23日 上午11:05:26
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    abstract protected function getConfigKey();
    
    /**
     * 获得Redis对象
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年6月23日 下午1:18:26
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private static function getRedisObj(){
        if(!isset(self::$_redis_obj)){
            self::$_redis_obj = new \Our\Redis();
        }
        return self::$_redis_obj;
    }
    /**
     * get
     * @date   : 2016年6月23日 上午10:56:12
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function _get($key){
        return self::getRedisObj()->get($key,$this->getConfigKey());
    }
    /**
     * set
     * @date   : 2016年6月23日 上午11:14:13
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function _set($key,$value,$cache_time=NULL){
        return self::getRedisObj()->set($key,$value,$cache_time,$this->getConfigKey());
    }
    /**
     * flushAll
     * @date   : 2016年6月23日 上午10:48:05
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function flushAll($key=NULL){
        return self::getRedisObj()->flushAll($key,$this->getConfigKey());  
    }
    /**
     * exist
     * @date   : 2016年6月23日 上午10:48:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function exist($key){
        return self::getRedisObj()->exist($key,$this->getConfigKey()); 
    }
    /**
     * lPush
     * @date   : 2016年6月23日 上午10:48:46
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lPush($key,$value){
        return self::getRedisObj()->lPush($key, $value,$this->getConfigKey());    
    }
    /**
     * rPush
     * @date   : 2016年6月23日 上午10:49:12
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function rPush($key,$value){
        return self::getRedisObj()->rPush($key, $value,$this->getConfigKey());
    }
    /**
     * lPop
     * @date   : 2016年6月23日 上午10:49:34
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lPop($key){
        return self::getRedisObj()->lPop($key,$this->getConfigKey());
    }
    /**
     * rPop
     * @date   : 2016年6月23日 上午10:49:57
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function rPop($key){
        return self::getRedisObj()->rPop($key,$this->getConfigKey());
    }
    /**
     * lSize
     * @date   : 2016年6月23日 上午10:50:23
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lSize($key){
        return self::getRedisObj()->lSize($key,$this->getConfigKey()); 
    }
    /**
     * lRange
     * @date   : 2016年6月23日 上午10:50:50
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */   
    public function lRange($key,$start,$end){
        return self::getRedisObj()->lRange($key, $start, $end,$this->getConfigKey());
    }
}
