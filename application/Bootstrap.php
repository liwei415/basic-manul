<?php

/**
 * Bootstrap引导程序
 * 所有在Bootstrap类中定义的, 以_init开头的方法, 都会被依次调用
 * 而这些方法都可以接受一个Yaf_Dispatcher实例作为参数.
 */
class Bootstrap extends Yaf\Bootstrap_Abstract {

    private static $_url_config = NULL;
    private static $_rpc_config = NULL;
    private static $_rpc_ini_config = array();
    /**
     * 把配置存到注册表
     */
    public function _initConfig() {
        $config = Yaf\Application::app()->getConfig();
        Yaf\Registry::set('config', $config);
    }

    /**
     * 路由规则定义，如果没有需要，可以去除该代码
     *
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initRoute(Yaf\Dispatcher $dispatcher) {
        $config = new Yaf\Config\Ini(APPLICATION_PATH . '/conf/route.ini', 'common');
        if ($config->routes) {
            $router = Yaf\Dispatcher::getInstance()->getRouter();
            $router->addConfig($config->routes);
        }
    }

    /**
     * 获取url.ini配置的地址
     * @param string $name
     * @return string
     */
    public static function getUrlIniConfig($name=NULL,$key=NULL) {
        if(!isset(self::$_url_config)){
            self::$_url_config = new Yaf\Config\Ini(APPLICATION_PATH . '/conf/url.ini', ini_get('yaf.environ'));
        }
        if(isset($name)){
            if (count(self::$_url_config[$name]) > 0){
                if(isset($key)){
                    if(isset(self::$_url_config[$name][$key]) && !empty(self::$_url_config[$name][$key])){
                        return self::$_url_config[$name][$key];
                    }else{
                        return null;
                    }
                }else{
                    return self::$_url_config[$name];
                }
            }else{
                throw new Exception("$name config is not exist");
            }
        }else{
            return self::$_url_config;
        }
    }
    /**
     * 获取rpc.ini配置的地址
     * @date   : 2016年6月24日 下午4:49:00
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public static function getRpcIniConfig($name=NULL,$key=NULL) {
        if(!isset(self::$_rpc_config)){
            self::$_rpc_config = new Yaf\Config\Ini(APPLICATION_PATH . '/conf/rpc.ini', ini_get('yaf.environ'));
        }
        if(isset($name)){
            if (count(self::$_rpc_config[$name]) > 0){
                if(isset($key)){
                    if(isset(self::$_rpc_config[$name][$key]) && !empty(self::$_rpc_config[$name][$key])){
                        return self::$_rpc_config[$name][$key];
                    }else{
                        return null;
                    }
                }else{
                    return self::$_rpc_config[$name];
                }
            }else{
                throw new Exception("$name config is not exist");
            }
        }else{
            return self::$_rpc_config;
        }
    }
    /**
     * 指定配置，指定节点，获得相关信息
     * @param 参数类型 参数变量
     * @return
     * @date   : 2016年6月24日 下午5:12:24
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public static function getIniConfig($ininame,$api_key=NULL){
        if(!isset(self::$_rpc_ini_config[$ininame])){
            self::$_rpc_ini_config[$ininame] = new Yaf\Config\Ini(APPLICATION_PATH . "/conf/rpc/$ininame.ini", ini_get('yaf.environ'));
        }
        if(isset($api_key)){
            return self::$_rpc_ini_config[$ininame][$api_key];
        }else{
            return self::$_rpc_ini_config[$ininame];
        }
    }

}
