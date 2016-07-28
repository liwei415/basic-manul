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

class NeedInfoModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_info';

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
     * 获得ni_limit
     * @date   : 2016年7月19日 下午8:22:08
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNilimit($nb_id) {
        $sql ="SELECT ni.ni_limit
               FROM need_info AS ni
               LEFT JOIN need_bid AS nb ON nb.ni_id = ni.ni_id
               WHERE nb.nb_id = :nb_id ";
        $bind = array (':nb_id' => $nb_id);
        return $this->select_one($sql, $bind);
    }
    
    /**
     * get needinfo
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年7月19日 下午8:24:33
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT nib.*,ni.ni_act_type,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,npr.npr_term_type
                FROM  need_info_new AS nib
                LEFT JOIN need_info AS ni ON ni.ni_id = nib.ni_id
                LEFT JOIN need_product AS np ON np.np_id = nib.np_id
                LEFT JOIN need_product_repayment AS npr ON npr.npr_id = nib.npr_id
                WHERE nib.ni_id = :ni_id ";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
}