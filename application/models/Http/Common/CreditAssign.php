<?php
namespace Http\Common;
use Http\AbstractModel;
/**
 * @desc: 债转标model
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月23日 下午3:20:11
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
class CreditAssignModel extends AbstractModel{
    
    /**
     * 继承父类方式
     * @param 参数类型 参数变量
     * @return
     * @date   : 2016年6月21日 下午12:00:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 1.0.0.0
     */
    protected function getUrlConfig(){
        return 'common';
    }
    /**
     * 投标
     * @param 参数类型 参数变量
     * @return
     * @date   : 2016年6月22日 下午5:47:06
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function goBidding($params=array(),$extParams=array()){
        return $this->post('settle/webapi/creditAssign',$params,$extParams);
    }
} 