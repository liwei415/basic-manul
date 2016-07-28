<?php
namespace Mysql;
use \Mysql\AbstractModel;
/**
 * @desc: need_bid model
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年7月16日 上午11:27:26
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
class NeedBidModel extends AbstractModel {

    //设置当前model对应的表名
    protected $_table_name = 'need_bid';

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
     * 获得精选标列表
     * @param $page 当前页数
     * @param $row  显示多少条
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getJxBidList($startnum,$row,$min_amount) {
        
        $sql = "SELECT nb.nb_id,nb.ni_title,nb.percentage,ni.p2p_site,ni.debt_type,nb.appr_term,ni.ni_type,ni.ni_handle_flag,
                nb.bonus_type,nb.bonus_value,nb.appr_rate,np.np_bidding_amt,npr.npr_term_type 
               FROM need_bid AS nb 
               LEFT JOIN need_info AS ni ON nb.ni_id = ni.ni_id 
               LEFT JOIN need_product_repayment AS npr ON nb.npr_id = npr.npr_id
               LEFT JOIN need_product AS np ON npr.np_id = np.np_id
               WHERE ni.ni_type = 0 AND np.np_bidding_amt < :np_bidding_amt
               AND nb.percentage <> 100 AND nb.delete_flag = 0 AND ni.delete_flag = 0
               AND nb.appr_amount>0 AND ni.ni_handle_flag IN (5,6,7,9) AND ni.p2p_site IN (2,1,3,4,9,10)
               AND nb.nb_id > 2700 ORDER BY nb.percentage DESC,nb.pub_time ASC LIMIT $startnum,$row";  
        $bind = array(':np_bidding_amt'=>$min_amount);
        return $this->select($sql,$bind);
    }
    
    /**
     * 获得金财标列表
     * @date   : 2016年7月16日 下午1:21:44
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getJcBidList($startnum,$row,$min_amount) {
        $sql = "SELECT nb.nb_id,nb.ni_title,nb.percentage,ni.p2p_site,ni.debt_type,nb.appr_term,ni.ni_type,ni.ni_handle_flag,
                nb.bonus_type,nb.bonus_value,nb.appr_rate,np.np_bidding_amt,npr.npr_term_type
                FROM need_bid AS nb
                LEFT JOIN need_info AS ni ON nb.ni_id = ni.ni_id
                LEFT JOIN need_product_repayment AS npr ON nb.npr_id = npr.npr_id
                LEFT JOIN need_product AS np ON npr.np_id = np.np_id
                WHERE ni.ni_type = 0 AND np.np_bidding_amt >= :np_bidding_amt
                AND nb.percentage <> 100 AND nb.delete_flag = 0 AND ni.delete_flag = 0
                AND nb.appr_amount>0 AND ni.ni_handle_flag IN (5,6,7,9) AND ni.p2p_site IN (2,1,3,4,9,10)
                AND nb.nb_id > 2700 ORDER BY nb.percentage DESC,nb.pub_time ASC LIMIT $startnum,$row";
        $bind = array(':np_bidding_amt'=>$min_amount);
        return $this->select($sql,$bind);
    }
    
    /**
     * 获得标列表
     * @date   : 2016年7月16日 下午1:21:44
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getBidList($startnum,$row) {
        $sql = "SELECT nb.nb_id,nb.ni_title,nb.percentage,ni.p2p_site,ni.debt_type,nb.appr_term,ni.ni_type,ni.ni_handle_flag,
        nb.bonus_type,nb.bonus_value,nb.appr_rate,np.np_bidding_amt,npr.npr_term_type
        FROM need_bid AS nb
        LEFT JOIN need_info AS ni ON nb.ni_id = ni.ni_id
        LEFT JOIN need_product_repayment AS npr ON nb.npr_id = npr.npr_id
        LEFT JOIN need_product AS np ON npr.np_id = np.np_id
        WHERE ni.ni_type = 0
        AND nb.percentage <> 100 AND nb.delete_flag = 0 AND ni.delete_flag = 0
        AND nb.appr_amount>0 AND ni.ni_handle_flag IN (5,6,7,9) AND ni.p2p_site IN (2,1,3,4,9,10)
        AND nb.nb_id > 2700 ORDER BY nb.percentage DESC,nb.pub_time ASC LIMIT $startnum,$row";
        return $this->select($sql);
    }
    
    /**
     * 根据标ID获得普通标详情
     * @date   : 2016年7月16日 下午2:51:31
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getBidDetail($nb_id) {
        $sql = "SELECT ni.*,nb.*,ui.u_login_type,ui.u_card,uic.corp_cert,ui.u_is_house is_house,ui.u_is_car is_car,
                sp.sp_item_remark payment_desc,ui.u_is_shebao is_shebao,ui.u_education education,(nb.appr_amount-nb.collect_amount) rest_amount,
                ui.u_marrage marrage,(nb.pub_time<NOW()) is_pub,npr.npr_term_type,np.np_bidding_amt,COUNT(nbd.nbd_id) grab_num,nb.appr_amount
                FROM need_bid nb
                LEFT JOIN need_info ni ON ni.ni_id = nb.ni_id
                LEFT JOIN user_info ui ON ni.u_id = ui.u_id
                LEFT JOIN user_info_corp uic ON ui.u_id=uic.u_id
                LEFT JOIN need_product_repayment AS npr ON nb.npr_id = npr.npr_id
                LEFT JOIN sys_parameter AS sp ON sp.sp_item_value = nb.appr_payment AND sp.sp_field_name = 'appr_payment'
                LEFT JOIN need_product AS np ON npr.np_id = np.np_id
                LEFT JOIN need_bid_detail AS nbd ON nbd.nb_id = nb.nb_id AND nbd.ord_id = '' AND nbd.bid_amount > 0 
                AND nbd.bid_status =1 WHERE nb.nb_id = :nb_id AND nb.delete_flag = 0 AND ni.delete_flag = 0";
        $bind = array(':nb_id'=>$nb_id);
        return $this->select_row($sql,$bind);
    }
    
    /**
     * 获得标剩余天数
     * @date   : 2016年7月19日 下午7:32:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getLeftDays($ni_id) {
        $sql = "SELECT (SELECT DATEDIFF(MAX(NBP.pay_date),CURDATE())
	           FROM view_need_bid_payplan AS NBP WHERE NBP.nb_id=NB.nb_id) left_days
	           FROM need_bid AS NB,need_info AS NI
	           WHERE NB.ni_id = NI.ni_id AND NI.ni_id = :ni_id ";
        $bind = array (':ni_id' => $ni_id);
        $r = $this->select_one($sql, $bind);
        return $r < 0 ? 0 : $r;
    }
    /**
     * getTimeNoviceBidTest
     * @date   : 2016年7月19日 下午8:28:40
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getTimeNoviceBidTest($nb_id) {
        $sql = "SELECT ni.p2p_site,nb.bonus_type,nb.bonus_value,nb.recommend,nb.pub_time,nb.ni_title,
                nb.nb_id,nb.appr_rate,ni.ni_handle_flag,nb.appr_amount,nb.appr_term,nb.percentage,nb.npr_id
                FROM need_bid AS nb
                LEFT JOIN need_info AS ni ON nb.ni_id = ni.ni_id
                WHERE ni.ni_type = 0 AND ni.p2p_site = 100 AND nb.nb_id = :nb_id ";
        $bind = array (':nb_id' => $nb_id);
        return $this->select_one($sql, $bind);
    }
    
    /**
     * 获取债转标的列表
     * @date   : 2016年7月16日 下午2:51:31
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function getTrsList($start, $rows) {
        $filter[] = "NB.ni_id = NI.ni_id";
        $filter[] = "NB.pub_time < NOW()";
        $filter[] = "NI.p2p_site != 8";
        $filter[] = "NI.ni_type = 1";
        $filter[] = "NID.ni_id = NI.ni_id";
        $filter[] = "NID.init_nbid = NB2.nb_id";
        $where    = " WHERE " . implode(" AND ", $filter);
        $limit = " LIMIT {$start} , {$rows} ";
        $sql = "SELECT * FROM (
                SELECT NB.*,NI.ni_handle_flag,
                (SELECT DATEDIFF(MAX(NBP.pay_date),CURDATE()) FROM view_need_bid_payplan NBP WHERE NBP.nb_id=NB2.nb_id) left_days
                FROM need_bid NB,need_bid NB2,need_info NI,need_info_debt NID
                {$where} AND NI.ni_handle_flag=5 ORDER BY IF(NB.percentage=100,1,0),NB.percentage DESC limit 5) a
                UNION
                SELECT * FROM (
                SELECT NB.*,NI.ni_handle_flag,
                (SELECT DATEDIFF(MAX(NBP.pay_date),CURDATE()) FROM view_need_bid_payplan NBP WHERE NBP.nb_id=NB2.nb_id) left_days
                FROM need_bid NB,need_bid NB2,need_info NI,need_info_debt NID
                {$where} AND NI.ni_handle_flag in(7,8) ORDER BY IF(NB.percentage=100,1,0),NB.percentage DESC) b
                {$limit} ";
        return $this->select($sql);
    }
    
    
}
