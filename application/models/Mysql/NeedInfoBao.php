<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedInfoBaoModel extends AbstractModel {

    protected $_table_name = 'need_info_bao';

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
                FROM need_info_bao AS ni,need_product AS np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 保必贷详情
     * @date   : 2016年7月19日 下午8:01:25
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT b.*,ni.ni_act_type,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,nib.np_id,nib.npr_id,
                    sr1.sr_name as bao_name1,sr2.sr_name as bao_name2,sr3.sr_name as bao_name3,npr.npr_term_type
                FROM need_info_bao AS nib
                LEFT JOIN need_info_bao_show AS b ON b.ni_id = nib.ni_id
                LEFT JOIN need_info AS ni ON ni.ni_id = nib.ni_id
                LEFT JOIN need_product AS np ON np.np_id = nib.np_id
                LEFT JOIN need_product_repayment AS npr ON npr.npr_id = nib.npr_id
                LEFT JOIN sys_region AS sr1 ON b.run_region1 = sr1.sr_id
                LEFT JOIN sys_region AS sr2 ON b.run_region2 = sr2.sr_id
                LEFT JOIN sys_region AS sr3 ON b.run_region3 = sr3.sr_id
                WHERE nib.ni_id = :ni_id ";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
}
