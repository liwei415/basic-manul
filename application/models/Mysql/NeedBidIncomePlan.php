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
class NeedBidIncomePlanModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_bid_income_plan';

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
    *待收利息
    * @date   : 2016年3月3日
    * @author : heshengle <heshengle@roadoor.com>
    * @vesion : 1.0.0.0
    */
   public function getAdvanceInterestBynddid($ndd_id = 0){
       if (!$ndd_id) {
           return ;
       }
       $sql = "SELECT SUM(interest-fee) as income FROM need_bid_income_plan nbip,need_debt_detail ndd
               WHERE ndd.nbd_id=nbip.nbd_id AND nbip.state=0 AND nbip.delete_flag=0 AND ndd.ndd_id= :ndd_id ";
       $bind = array ();
       $bind = array (':ndd_id' => $ndd_id);
       return $this->select_one($sql, $bind);
   }
   
   /**
     * 债权还款总期数
     * @date   : 2016年3月3日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function getAllTerm($nb_id = 0) {
        if (!$nb_id) {
            return ;
        }
        $sql = "SELECT COUNT(*) FROM need_bid_income_temp WHERE delete_flag=0 AND nb_id = :nb_id ";
        $bind = array ();
        $bind = array (':nb_id' => $nb_id);
        return $this->select_one($sql, $bind);
    }
    

}
