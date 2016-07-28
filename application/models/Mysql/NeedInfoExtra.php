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

class NeedInfoExtraModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_info_extra';

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
     *
     * @date   : 2016年7月15日
     * @author : wangkelin <wangkelin@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getBiddingAmtByNiid($ni_id) {
        $sql = "SELECT np.np_bidding_amt,ni.npr_id  FROM need_info_train ni,need_product np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 获得车贷产品详情
     * @date   : 2016年7月19日 下午7:46:50
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT c.*,ca.*,ni.ni_act_type,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,ic.npr_id,ic.ni_car_time,
                    ex.u_extra_name,ex.u_extra_birth,ui.u_census_region1,ui.u_census_region2,ui.u_census_region3,
                    ui.u_region1,ui.u_region2,ui.u_region3,ui.u_login_type,npr.npr_term_type,sp1.sp_item_name,ca.ni_appr_time appr_time
                FROM  need_info ni
                LEFT JOIN need_info_extra_show AS c ON c.ni_id = ni.ni_id
                LEFT JOIN need_info_extra AS ic ON ic.ni_id = ni.ni_id
                LEFT JOIN need_product AS np ON np.np_id = ic.np_id
                LEFT JOIN need_product_repayment AS npr ON npr.npr_id = ic.npr_id
                LEFT JOIN user_info AS ui ON ni.u_id = ui.u_id
                LEFT JOIN user_info_extra AS ex ON ni.u_id = ex.u_id
                LEFT JOIN need_info_car AS ca ON c.ni_id = ca.ni_id
                LEFT JOIN sys_parameter AS sp1 ON sp1.sp_item_value = c.u_extra_type AND sp1.sp_field_name = 'client_type'
                WHERE ic.ni_id = :ni_id ";
        $bind = array (':ni_id' => $ni_id);
        return $this->select_row($sql, $bind);
    }
    
    /**
     * 获得车辆管理表信息
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年7月19日 下午7:53:30
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getCarBaseName($cb_id) {
        $sql = "SELECT cb_name FROM car_base WHERE is_valid = 1 AND  cb_id = :cb_id  ";
        $bind = array (':cb_id' => $cb_id);
        return $this->select_one($sql, $bind);
    }
}