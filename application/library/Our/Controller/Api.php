<?php
namespace Our\Controller;
/**
 * @desc: 基础控制器，所有控制器必须继承
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年7月15日 下午6:20:19
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
abstract class Api extends \Yaf\Controller_Abstract {

    protected $argv = NULL;

    /**
     * init
     * @date   : 2016年7月15日 上午11:39:52
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function init() {
        $r = $this->beforeAction_();
        if(isset($r)){
           echo $r;die;
        }
        \Yaf\Dispatcher::getInstance()->disableView();
    }

    /**
     *  功能描述
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年7月13日 下午3:59:16
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private function beforeAction_() {
        //1.设置header
        $this->setHeader_();
        
        //2.入参基本校验
        $r = $this->checkInput_();
        if(isset($r)){
            return $r;
        }
        
        //3.检查版本号
        $r = $this->checkVersion_();
        if(isset($r)){
            return $r;
        }
    }
    
    /**
     * 由于ajax请求会有跨域问题，所以需要此操作
     * @date   : 2016年7月14日 上午10:04:46
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private function setHeader_() {
        
        //1.指定允许其他域名访问
        header('Access-Control-Allow-Origin:*');
        
        //2.响应类型
        header('Access-Control-Allow-Methods:POST');
        
        //3.响应头设置
        header('Access-Control-Allow-Headers:x-requested-with,content-type');
        
        //4.指定返回内容格式
        header('Content-type: application/json');
    }
    
    /**
     * 入参基本校验
     * @date   : 2016年7月14日 上午9:51:03
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    private function checkInput_() {
        //1.我们只接收post请求，其它请求不管
        if(DEBUG) {
            $argv = isset($_POST['argv'])? $_POST['argv']:(isset($_GET['argv'])?$_GET['argv']:'');
        } else {
            $argv = isset($_POST['argv'])?$_POST['argv']:'';
        }
        //2.检查请求数据
        if(empty($argv) || !isset($argv)){
            return \Our\Error::getMsg(9999);
        }
        $this->argv = json_decode($argv);
        
    }
    
    /**
     * 检查来源
     * @date   : 2016年7月15日 上午10:48:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function checkSource_() {
        $allow_list = \Yaf\Registry::get('config')['source']['allow']['list'];
        $allow_arr = explode(',', $allow_list);
        if(!in_array($this->argv->source,$allow_arr)) {
            return \Our\Error::getMsg(9998);
        }
    }
    
    /**
     * 检查版本号
     * @date   : 2016年7月15日 上午10:50:04
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function checkVersion_() {
        $version = \Yaf\Registry::get('config')['vesion'];
        if($version != $this->argv->version) {
            return \Our\Error::getMsg(9995);
        }
    }

}
