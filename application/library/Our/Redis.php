<?php
namespace Our;
/**
 * @desc: redis操作类
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月23日 上午9:27:36
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 1.0.0.0
 */
class Redis{
    
    private static $_redis_list = array();
    
    public static function getRedisHandle($config_key=NULL){
        if(!isset(self::$_redis_list[strtolower($config_key)])){
            $config = \Yaf\Registry::get('config');
            if(!isset($config_key)){
                $config_key = 'common';
            }
            $host = !empty($config[$config_key]['redis']['host'])?$config[$config_key]['redis']['host']:'127.0.0.1';
            $port = !empty($config[$config_key]['redis']['port'])?$config[$config_key]['redis']['port']:'6379';
            $redis = new \Redis();
            $link = $redis->connect($host,$port);
            if(!$link){
                throw new \Exception('redis cannot link');
            }
            self::$_redis_list[$config_key] = $redis;
        }
        return self::$_redis_list[$config_key];
    }
    /**
     * get
     * @return 
     * @date   : 2016年6月23日 上午9:33:01
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function get($key,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->get($key);
        return $r;
    }
    /**
     * set
     * @date   : 2016年6月23日 上午10:47:19
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function set($key,$value,$cache_time=NULL,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        if(isset($cache_time) && is_numeric($cache_time) && $cache_time > 0){
            $r = $link->setex($key,$cache_time,$value);
        }else{
            $r = $link->set($key,$value);
        }
        return $r;
    }
    /**
     * flushAll
     * @date   : 2016年6月23日 上午10:48:05
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function flushAll($key=NULL,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        if(isset($key)){
            $r = $link->delete($key);
        }else{
            $r = $link->flushAll();
        }
        return $r;
    }
    /**
     * exist
     * @date   : 2016年6月23日 上午10:48:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function exist($key,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->exists($key);
        return $r;
    }
    /**
     * lPush
     * @date   : 2016年6月23日 上午10:48:46
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lPush($key,$value,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->lPush($key,$value);
        return $r;
    
    }
    /**
     * rPush
     * @date   : 2016年6月23日 上午10:49:12
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function rPush($key,$value,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->lPush($key,$value);
        return $r;
    }
    /**
     * lPop
     * @date   : 2016年6月23日 上午10:49:34
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lPop($key,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->lPop($key);
        return $r;
    }
    /**
     * rPop
     * @date   : 2016年6月23日 上午10:49:57
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function rPop($key,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->rPop($key);
        return $r;
    }
    /**
     * lSize
     * @date   : 2016年6月23日 上午10:50:23
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function lSize($key,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->lSize($key);
        return $r;
    }
    /**
     * lRange
     * @date   : 2016年6月23日 上午10:50:50
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */   
    public function lRange($key,$start,$end,$config_key=NULL){
        $link = self::getRedisHandle($config_key);
        $r = $link->lRange($key,$start,$end);
        return $r;
    }
} 