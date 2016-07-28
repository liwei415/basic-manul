<?php
namespace Mysql;

use \Mysql\AbstractModel;

class UserPackageBonusDetailModel extends AbstractModel {

    protected $_table_name = 'user_package_bonus_detail';

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
     * 获取红包的总数
     * @date   : 2016年7月14日
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function getCountByParams($params) {
    	$where = "WHERE upbd.u_id=".$params['u_id'];
        if (isset($params['bid_amount']) && !empty($params['bid_amount'])) {
           $where  .= " AND sbr.sbr_quota<=".$params['bid_amount'];
        }
        
        $time = date('Y-m-d');
        if ($params['status']==1) {//未使用
            $where .= " AND upbd.`upbd_status`=1  AND  spb.`end_time`>='".$time."'  ORDER BY scc.scc_money desc,spb.end_time asc";
        }elseif ($params['status']==2) {//已使用
            $where .= " AND upbd.`upbd_status`=2  ORDER BY upbd.upbd_create_time desc";
        }elseif($params['status']==3){//已过期
             $where .= " AND spb.`end_time`<'".$time."' AND upbd.`upbd_status`=1 ORDER BY spb.end_time desc,scc.scc_money desc";
        }
        
        $sql  = "SELECT COUNT(*) 
        		FROM user_package_bonus_detail AS upbd
                        LEFT JOIN sys_cash_card AS scc ON scc.scc_id=upbd.scc_id
                        LEFT JOIN sys_bonus_relation AS sbr ON sbr.scc_id=scc.scc_id AND sbr.spb_id=upbd.spb_id
                        LEFT JOIN sys_package_bonus AS spb ON spb.spb_id=sbr.spb_id";
        $sql .= " {$where} "; 
        return $this->select_one($sql);
    }
    
    
     /**
     * 获取用户红包
     * @date   : 2016年7月19日
     * @author : heshengle<heshengle@roadoor.com>
     * @vesion : 1.0.0.0
     */
    public function getListByParams($params) {
        $where = "WHERE upbd.u_id=".$params['u_id'];
        if (isset($params['bid_amount']) && !empty($params['bid_amount'])) {
           $where  .= " AND sbr.sbr_quota<=".$params['bid_amount'];
        }
        $time = date('Y-m-d');
        if ($params['status']==1) {//未使用
            $where .= " AND upbd.`upbd_status`=1  AND  spb.`end_time`>='".$time."'  ORDER BY scc.scc_money desc,spb.end_time asc";
        }elseif ($params['status']==2) {//已使用
            $where .= " AND upbd.`upbd_status`=2  ORDER BY upbd.upbd_create_time desc";
        }elseif($params['status']==3){//已过期
            $where .= " AND spb.`end_time`<'".$time."' AND upbd.`upbd_status`=1 ORDER BY spb.end_time desc,scc.scc_money desc";
        }else{
            $where .="  scc.scc_money DESC,spb.end_time DESC"; 
        }
    	$limit = '';
    	if (isset($params['page']) && $params['page']>0) {
    		$page     = $params['page'];
    		$rows     = $params['rows'] ? $params['rows'] : 10;
    		$start = ($page -1) * $rows;
    		$limit = " LIMIT {$start} , {$rows} ";
    	}        
                
        $need_fields = "scc.scc_id,scc.scc_type,scc.scc_money,sbr.sbr_quota,upbd.upbd_id,upbd.upbd_status,DATE_FORMAT(spb.start_time,'%Y-%m-%d') as start_time,DATE_FORMAT(spb.end_time,'%Y-%m-%d') as end_time";        
        $sql = "SELECT {$need_fields}
				    FROM user_package_bonus_detail AS upbd
	                LEFT JOIN sys_cash_card AS scc ON scc.scc_id=upbd.scc_id
	                LEFT JOIN sys_bonus_relation AS sbr ON sbr.scc_id=scc.scc_id AND sbr.spb_id=upbd.spb_id
	                LEFT JOIN sys_package_bonus AS spb ON spb.spb_id=sbr.spb_id
                        {$where}";
				   
        $sql .= $limit;
        return $this->select($sql);
    }
    
      /**
     * 调用存储过程获取红包领取状态
     * @date: 2016-7-19 下午1:39:43
     * @author: heshengle
     * @param: variable
     * @return:
     */
    public function getBonusStatus($u_id, $spb_id) {
        $sql = "call get_user_package($u_id,$spb_id,@return_status)";
        $this->exe($sql);
        $res = $this->select_one('select @return_status');
        return $res;
    }
    

}
