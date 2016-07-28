<?php
namespace Mysql;
use \Mysql\AbstractModel;
/**
 * @desc: NeedInfoExtra model
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年7月19日 下午7:44:47
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */

class NeedBidIncomeTempModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_bid_income_temp';

    /**
     * insert
     * @date   : 2016年7月16日 上午11:28:13
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function add($fields) {
        return $this->insert($fields);
    }

    /**
     * get
     * @date   : 2016年7月16日 上午11:29:37
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function get($col, $cond='', array $bind=array(), $order='', $page=0, $limit=0, $group='') {
        return $this->find($col, $cond, $bind, $order, $page, $limit, $group);
    }

    /**
     * edit
     * @date   : 2016年7月16日 上午11:30:18
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function edit($fileds = array(), $cond = '', $bind = array()) {
        return $this->update($fileds, $cond, $bind);
    }

    /**
     * 获得标的临时收益计划也就前台的还款计划
     * @date   : 2016年7月19日 下午9:16:11
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedBidIncomeTempListByNbId($nb_id) {
        $sql = "SELECT * FROM need_bid_income_temp WHERE nb_id =:nb_id AND delete_flag=0 ORDER BY np_id ASC";
        $bind = array(':nb_id'=>$nb_id);
        return $this->select($sql,$bind);
    }
    
}