<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedBidDetailModel extends AbstractModel {

    protected $_table_name = 'need_bid_detail';

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
    public function getConutDetailByNbid($nb_id)
    {
        if (!$nb_id) {
            return  ;
        }
        $sql = "SELECT count(*)  FROM need_bid_detail WHERE ord_id = '' AND bid_amount > 0 AND nb_id = :nb_id ";
        $bind = array (':nb_id' => $nb_id);
        return  $this->select_one($sql, $bind);
    }
    
    /**
     * 获得抢标列表
     * @date   : 2016年7月19日 下午9:26:40
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getListDetailByParams($nb_id,$startnum,$row) { 
        $sql = "SELECT *,ui.u_loginmobile,ui.u_create_time,ui.u_name,@i := @i + 1 AS `order`
                FROM need_bid_detail AS nbd
                LEFT JOIN user_info AS ui ON ui.u_id =  nbd.u_id
                WHERE ord_id ='' AND bid_amount > 0 AND nb_id = :nb_id ORDER BY nbd_id DESC
                LIMIT $startnum, $row";
        $bind = array(':nb_id'=>$nb_id);
        return  $this->select($sql,$bind);
    }

}
