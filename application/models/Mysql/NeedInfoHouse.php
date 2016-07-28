<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedInfoHouseModel extends AbstractModel {

    protected $_table_name = 'need_info_house';

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
                FROM need_info_house ni,need_product np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 房贷详情
     * @date   : 2016年7月19日 下午8:16:32
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT nihs.*,ni.ni_act_type,nih.nih_loan_uid,nih.npr_id,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,ui.u_id,ui.u_card,npr.npr_term_type
                FROM need_info_house nih
                LEFT JOIN need_info_house_show nihs ON nihs.ni_id = nih.ni_id
                LEFT JOIN need_info ni ON nihs.ni_id = ni.ni_id
                LEFT JOIN user_info ui ON ni.u_id = ui.u_id
                LEFT JOIN need_product np ON np.np_id = nih.np_id
                LEFT JOIN need_product_repayment npr ON npr.npr_id = nih.npr_id
                WHERE nih.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
}
