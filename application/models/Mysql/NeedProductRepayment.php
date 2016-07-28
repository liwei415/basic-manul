<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedProductRepaymentModel extends AbstractModel {

    protected $_table_name = 'need_product_repayment';

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
     * 获取标的还款方式
     * @date   : 2016年7月14日
     * @author : wangkelin <wangkelin@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public  function getBidRepayment($npr_id,$nb_id)
    {
        if ($npr_id == '') {
            return ;
        }
        $sql="SELECT npr.npr_term_type,sp.sp_item_name,sp.sp_item_remark
                FROM need_product_repayment AS npr
                LEFT JOIN sys_parameter AS sp ON sp.sp_item_value=npr.npr_repayment_type AND sp.sp_field_name='appr_payment'
                WHERE npr.`npr_id`= :npr_id";
        $bind = array (':npr_id' => $npr_id);
        return $this->select_row($sql, $bind);
    }

    /**
     * getNPRDetail
     * @date   : 2016年7月19日 下午8:25:52
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNPRDetail($npr_id) {
        $sql = "SELECT * FROM need_product_repayment AS npr
               LEFT JOIN need_product AS np ON np.np_id = npr.np_id
               where npr.npr_id = :npr_id ";
        $bind = array (':npr_id' => $npr_id);
        return $this->select_row($sql, $bind);
    }
}
