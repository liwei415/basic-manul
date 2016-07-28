<?php

namespace Our;

class Mysql {

    private static $_instance = NULL;
    private $_link = NULL;
    private $_username = NULL;
    private $_password = NULL;
    private $_host = NULL;
    private $_port = NULL;
    private $_dbname = NULL;

    private function __construct() {
        $conf = \Yaf\Registry::get('config')->get('resources.db.params');
        if (!$conf) {
            throw new \Exception('数据库连接必须设置');
        }

        $params = $conf->toArray();
        $this->_username = $params['username'];
        $this->_password = $params['password'];
        $this->_host = $params['host'];
        $this->_port = $params['port'];
        $this->_dbname = $params['dbname'];

        $this->_link = new \PDO("mysql:host=$this->_host;port=$this->_port;dbname=$this->_dbname",
                               $this->_username,
                               $this->_password);
        $this->_link->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);
        $this->_link->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->_link->exec('set names utf8');

        return $this->_link;
    }

    private function __clone() {}

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function exec($sql, $bind = array()){
        $stmt = $this->_get_statement($sql, $bind);
        $r= $stmt->execute();
        return $r;
    }

    private function _get_statement($sql, $bind = array()) {
        $stmt = $this->_link->prepare($sql);
        if(is_array($bind) && count($bind) > 0) {
            foreach ($bind as $k => $v) {
                if (is_numeric($v)) {
                    $stmt->bindValue($k, $v, \PDO::PARAM_INT);
                }
                else {
                    $stmt->bindValue($k, $v, \PDO::PARAM_STR);
                }
            }
        }
        return $stmt;
    }

    public function add($table_name, array $fileds = array()) {

        $sql = 'INSERT INTO `' . $table_name . '` ';

        if (count($fileds) == 0) {
            return false;
        }

        $bind = array();
        $cols = ' ( ';
        $vals = ' ( ';
        foreach ($fileds as $k => $v) {
            $cols .= "`$k`,";
            $vals .= ":$k,";
            $bind[":$k"] = $v;
        }
        $cols = trim($cols, ',') . ' ) ';
        $vals = trim($vals, ',') . ' ) ';

        $sql = $sql . $cols . 'VALUES' . $vals;

        // exec
        $stmt = $this->_get_statement($sql, $bind);
        $r = $stmt->execute();
        if ($r) {
            return $this->_link->lastInsertId();
        }
        return false;
    }

    public function delete($table_name, $cond = '', $bind = array()){
        $sql = 'DELETE FROM `' . $table_name . '` ';
        if(empty($cond)) {
            return FALSE;            // 清空整张表,不允许
        }
        $sql .= ' WHERE ' . $cond;

        return $this->exec($sql, $bind);
    }

    public function update($table_name, array $feilds = array(), $cond = '', $bind = array()){

        $sql = 'UPDATE `' . $table_name . '` ';
        if(count($feilds) == 0 || empty($cond)){
            return false;// 无更新任何列/全表更新 不支持
        }

        $set = ' SET ';
        foreach ($feilds as $k => $v) {
            $set .= '`' . $k . '`=:' . $k . ',';
            $bind[":$k"] = $v;
        }
        $set = trim($set, ',');

        $sql = $sql . $set . ' WHERE ' . $cond;

        return $this->exec($sql, $bind);
    }

    public function select($sql, $bind = array()){
        $stmt = $this->_get_statement($sql, $bind);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function select_one($sql, $bind = array()){
        $stmt = $this->_get_statement($sql, $bind);
        $stmt->execute();
        $r = $stmt->fetch();
        if(isset($r[0])) {
            return $r[0];
        }
        else {
            return false;
        }
    }

    public function select_row($sql,$bind = array()){
        $stmt = $this->_get_statement($sql, $bind);
        $stmt->execute();
        return $stmt->fetch(\PDO::FETCH_ASSOC); ;
    }

    public function get($table_name, $col='*', $cond='',
                        array $bind=array(), $order='', $page=0, $limit=0, $group='') {

        $sql = " SELECT " . $col . " FROM " . $table_name;
        if ($cond) {
            $sql .= " WHERE " . $cond;
        }

        if ($order) {
            $sql .= " ORDER BY " . $order;
        }

        if ($page && $limit) {
            $sql .= " LIMIT " . $page .','.$limit;
        }

        if ($group) {
            $sql .= " GROUP BY " . $group;
        }

        //echo $sql;return;
        $stmt = $this->_get_statement($sql, $bind);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }


    public function begin() {
        $this->_link->beginTransaction();
    }

    public function rollback() {
        $this->_link->rollback();
    }

    public function commit() {
        $this->_link->commit();
    }


}