<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedInfoXinModel extends AbstractModel {

    protected $_table_name = 'need_info_xin';

    /**
     * insert
     * @param array $fields
     * @date  : ${DATE}
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
     * @date  : ${DATE}
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
                FROM need_info_xin AS ni,need_product AS np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 信贷详情
     * @date   : 2016年7月19日 下午8:05:45
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT x.*,ni.ni_act_type,ix.npr_id,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,ui.u_id,ui.u_card,ui.u_login_type
                    FROM need_info_xin ix
                    LEFT JOIN need_info_xin_show x  on  x.ni_id = ix.ni_id
                    LEFT JOIN need_info ni on x.ni_id = ni.ni_id
                    LEFT JOIN user_info ui on ni.u_id = ui.u_id
                    LEFT JOIN need_product np on  np.np_id = ix.np_id
                    LEFT JOIN sys_region sr1 on  x.ni_region1 = sr1.sr_id
                    LEFT JOIN sys_region sr2 on  x.ni_region2 = sr2.sr_id
                    LEFT JOIN sys_region sr3 on  x.ni_region3 = sr3.sr_id
                WHERE ix.ni_id={$ni_id}";
        return  $this->select_row($sql);
    }
}
