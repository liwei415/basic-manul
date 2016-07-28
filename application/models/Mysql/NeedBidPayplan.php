<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedBidPayplanModel extends AbstractModel {

    protected $_table_name = 'need_bid_payplan';

    /**
     * insert
     * @param array $fields
     * @date  : 2016年07月21日
     * @author: wangkelin <wangkelin@roadoor.com>
     * @vesion: 2.0.0.0
     * @return  bool|string
     */
    public function add($fields = array()) {
        // 以下两种写法都可以
        return $this->insert($fields);
    }

    /**
     * get
     * @param $col
     * @param string $cond
     * @param array $bind
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param string $group
     * @date  : 2016年07月21日
     * @author: wangkelin <wangkelin@roadoor.com>
     * @vesion: 2.0.0.0
     * @return  array
     */
    public function get($col, $cond='', array $bind=array(), $order='', $page=0, $limit=0, $group='') {
        return $this->find($col, $cond, $bind, $order, $page, $limit, $group);
    }

    /**
     * edit
     * @param array $fileds
     * @param string $cond
     * @param array $bind
     * @date  : 2016年07月21日
     * @author: wangkelin <wangkelin@roadoor.com>
     * @vesion: 2.0.0.0
     * @return  bool
     */
    public function edit($fileds = array(), $cond = '', $bind = array()) {
        return $this->update($fileds, $cond, $bind);
    }

    /**
     * del
     * @date  : 2016年07月21日
     * @author: wangkelin <wangkelin@roadoor.com>
     * @vesion: 2.0.0.0
     */
    public function del() {
    }

    /**
     *
     * @date   : 2016年7月15日
     * @author : wangkelin <wangkelin@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getSettleDate($nb_id = 0) {
        if (!$nb_id) {
            return ;
        }
        $sql = "SELECT MAX(pay_date) FROM view_need_bid_payplan WHERE nb_id = :nb_id ";
        $bind = array (':nb_id' => $nb_id);
        return $this->select_one($sql, $bind);
    }
    
    /**
     *已成功还款的期数
     * @date   : 2016年7月20日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    
    public function getSuccessTerm($nb_id = 0) {
        if (!$nb_id) {
            return ;
        }
    	$sql = "SELECT COUNT(*) FROM need_bid_payplan_paylog WHERE is_valid = 1 AND nb_id = :nb_id ";
    	$bind = array ();
    	$bind = array (':nb_id' => $nb_id);
    	return  $this->select_one($sql, $bind);
	
    }
    
     /**
     * 债转标的结清日期
     * @date   : 2016年7月15日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getDebtSettleDate($ni_id = 0) {
        if (!$ni_id) {
            return ;
        }
        $sql = "SELECT MAX(pay_date) FROM view_need_bid_payplan as vnbp
                LEFT JOIN  need_info_debt as nid on  vnbp.nb_id = nid.init_nbid
                WHERE nid.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return $this->select_one($sql, $bind);
    }


}
