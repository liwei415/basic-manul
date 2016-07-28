<?php
namespace Mysql;
use \Mysql\AbstractModel;
/**
 * @desc: need_bid model
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年7月16日 上午11:27:26
 * @author:heshengle<heshengle@roadoor.com>
 * @version: 2.0.0.0
 */
class NeedInfoDebtModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_info_debt';

    /**
     * insert
     * @date   : 2016年7月16日 上午11:28:13
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function add($fields) {
        return $this->insert($fields);
    }

    /**
     * get
     * @date   : 2016年7月16日 上午11:29:37
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function get($col, $cond='', array $bind=array(), $order='', $page=0, $limit=0, $group='') {
        return $this->find($col, $cond, $bind, $order, $page, $limit, $group);
    }

    /**
     * edit
     * @date   : 2016年7月16日 上午11:30:18
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function edit($fileds = array(), $cond = '', $bind = array()) {
        return $this->update($fileds, $cond, $bind);
    }

   /**
     * 根据需求id获取债权转让信息
     * @date   : 2016年7月20日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function getNeedInfoDebtByNiid($ni_id = 0) {
         if (!$ni_id) {
            return  FALSE;
        }
        $sql = "SELECT nid.* 
                FROM need_info_debt AS nid  
                WHERE nid.ni_id = :ni_id "; // 已经流标的也要能取到
        $bind = array ();
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 债转标的原始标信息
     * @date   : 2016年3月3日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function getInitNbid($nb_id = 0) {
        if (!$nb_id) {
            return  FALSE;
        }
        $sql = "SELECT init_nbid FROM need_info_debt AS nid 
                LEFT JOIN need_bid AS nb on nb.ni_id = nid.ni_id 
                WHERE nb.nb_id = :nb_id " ;
        $bind = array ();
        $bind = array (':nb_id' => $nb_id);
        return  $this->select_one($sql, $bind);
    }
}
