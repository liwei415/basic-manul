<?php
namespace Mysql;

use \Mysql\AbstractModel;

class NeedInfoTrainModel extends AbstractModel {

    protected $_table_name = 'need_info_train';

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
        $sql = "SELECT np.np_bidding_amt,ni.npr_id  FROM need_info_train ni,need_product np
                WHERE ni.np_id = np.np_id AND ni.ni_id = :ni_id";
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
    /**
     * 培贷详情
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年7月19日 下午8:09:30
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getNeedInfoByNiid($ni_id) {
        $sql = "SELECT nb.*,np.np_bidding_amt,np.np_bidding_amtmax,np.np_bidding_num,nibs.*,sr1.`sr_name` AS `sr_name1`,sr2.`sr_name` AS `sr_name2`,sr3.`sr_name` AS sr_name3,
		            ni.`ni_type`,ni.`ni_act_type`,ni.`ni_handle_flag`,ni.`ni_limit`,ni.`a_id`,ui.`u_birth`,ui.`u_sex`,
		            ni.`u_id`,ni.`debt_type`,ui.`u_card`,uc.`curr_name`,uc.`curr_cycle`,uc.`curr_tuition`,uc.`first_payment`,
		            uid.`u_job_position`,uit.`u_age`,uie.`u_extra_position`,it.npr_id,
		            sp1.`sp_item_name`,sp2.`sp_item_name` AS `marrage`,sp3.`sp_item_name` AS `condition`,sp4.`sp_item_name` AS `company_type`,npr.npr_term_type
	            FROM `need_bid` AS nb
	            LEFT JOIN `need_info` AS ni ON ni.`ni_id` = nb.`ni_id`
	            LEFT JOIN `need_info_train` AS it ON ni.ni_id = it.ni_id
	            LEFT JOIN `user_info` AS ui ON ui.`u_id` =  ni.`u_id`
	            LEFT JOIN `user_info_detail` AS uid ON uid.`u_id` = ni.`u_id`
	            LEFT JOIN `user_info_train` AS uit ON uit.`u_id`=ni.`u_id`
	            LEFT JOIN `need_info_train_show` AS nibs ON nibs.`ni_id` = nb.`ni_id`
	            LEFT JOIN `user_curriculum` AS uc ON uc.`uc_id`=nibs.`uc_id`
	            LEFT JOIN `sys_region` AS sr1 ON ui.`u_region1` = sr1.`sr_id`
	            LEFT JOIN `sys_region` AS sr2 ON ui.`u_region2` = sr2.`sr_id`
	            LEFT JOIN `sys_region` AS sr3 ON ui.`u_region3` = sr3.`sr_id`
	            LEFT JOIN `user_info_extra` AS uie ON uie.`u_id`=ui.`u_id`
	            LEFT JOIN `need_product` AS np ON  np.np_id = it.np_id
                LEFT JOIN `need_product_repayment` AS npr on npr.npr_id = it.npr_id
	            LEFT JOIN `sys_parameter` AS sp1 ON sp1.`sp_item_value` = uit.`u_extra_type` AND sp1.`sp_field_name` = 'client_type'
	            LEFT JOIN `sys_parameter` AS sp2 ON sp2.`sp_item_value` = ui.`u_marrage` AND sp2.`sp_field_name` = 'u_marrage'
	            LEFT JOIN `sys_parameter` AS sp3 ON sp3.`sp_item_value` = uie.`u_credit_condition` AND sp3.`sp_field_name` = 'u_credit_condition'
	            LEFT JOIN `sys_parameter` AS sp4 ON sp4.`sp_item_value` = uid.`u_company_type` AND sp4.`sp_field_name` = 'u_company_type'
                WHERE nb.`ni_id` = :ni_id " ;
        $bind = array (':ni_id' => $ni_id);
        return  $this->select_row($sql, $bind);
    }
    
     /**
     * 获取学历
     * @param 参数类型 参数变量
     * @return 
     * @date   : 2016年7月19日 下午8:09:30
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getEducation($ueval = 0)
    {
        if(!$ueval){
            return;
        }
        $sql = "SELECT `sp_item_name` FROM `sys_parameter` WHERE `sp_field_name`='u_education' AND `sp_item_value`={$ueval}";
        return $this->select_one($sql);
    }

}
