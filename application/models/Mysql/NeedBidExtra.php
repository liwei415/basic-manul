<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedBidExtraModel extends AbstractModel {

    protected $_table_name = 'need_bid_extra';

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
    public function getBiddingAmtByNiid($ni_id = 0)
    {
        if (!$ni_id) {
            return ;
        }
        $sql = "SELECT np.np_bidding_amt,ni.npr_id  
                FROM need_info_extra ni,need_product AS np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id ";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }


}
