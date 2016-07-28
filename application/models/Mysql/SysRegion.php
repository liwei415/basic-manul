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

class SysRegionModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'sys_region';

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
     * 查看 省市县
     * @date   : 2016年7月16日 上午11:29:37
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getregion($sr_id) {
        $sql = " SELECT sr_name FROM sys_region WHERE sr_id = :sr_id ";
        $bind = array (':sr_id' => $sr_id);
        return $this->select_one($sql, $bind);
    }
    
}