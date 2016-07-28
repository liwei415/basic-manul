<?php
namespace Mysql;

abstract class AbstractModel {

    protected $_link = NULL;

    public function begin() {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->begin();
    }

    public function rollback() {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->rollback();
    }

    public function commit() {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->commit();
    }

    public function insert($fileds = array()) {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->add($this->_table_name, $fileds);
    }

    public function find($col, $cond='', array $bind=array(), $order='', $page=0, $limit=0, $group='') {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->get($this->_table_name, $col, $cond, $bind, $order, $page, $limit, $group);
    }

    public function update($fileds = array(), $cond = '', $bind = array()) {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->update($this->_table_name, $fileds, $cond, $bind);
    }

    public function delete() {
    }
    /**
     * select_row
     * @date   : 2016年7月15日
     * @author : wangkelin <wangkelin@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public final function select_row($sql, $bind = array()) {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->select_row($sql, $bind);
    }
    /**
     * select_one
     * @date   : 2016年7月15日
     * @author : wangkelin <wangkelin@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public final function select_one($sql, $bind = array()) {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->select_one($sql, $bind);
    }
    /**
     * select
     * @date   : 2016年7月16日 下午12:01:40
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public final function select($sql,$bind=array()){
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->select($sql,$bind);
    }
    
     /**
     * exe
     * @date   : 2016年7月16日 下午12:01:40
     * @author : heshengle <heshengle@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public final function exe($sql,$bind=array())
    {
        $this->_link = \Our\Mysql::getInstance();
        return $this->_link->exec($sql,$bind);
        
    }
    
    
}
