<?php

namespace Our;

class Rabbit {

    private static $_instance = NULL;
    private $_link = NULL;
    private $_host = NULL;
    private $_port = NULL;
    private $_login = NULL;
    private $_password = NULL;
    private $_vhost = NULL;

    private function __construct() {
        $conf = \Yaf\Registry::get('config')->get('resources.rabbit.params');
        if (!$conf) {
            throw new Exception('数据库连接必须设置');
        }

        $params = $conf->toArray();
        $this->_host = $params['host'];
        $this->_port = $params['port'];
        $this->_login = $params['login'];
        $this->_password = $params['password'];
        $this->_vhost = $params['vhost'];

        $params = array('host' => $params['host'],
                        'port' => $params['port'],
                        'login' => $params['login'],
                        'password' => $params['password'],
                        'vhost' => $params['vhost']);
        $this->_link = new \AMQPConnection($params);
        return $this->_link;
    }

    private function __clone() {}

    public static function getInstance() {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function send($ename, $qname, $rkey, $message) {
        // 0. conn
        $this->_link->connect();
        // 1.创建channel
        $channel = new \AMQPChannel($this->_link);

        // 2.创建exchange
        $ex = new \AMQPExchange($channel);
        $ex->setName($ename);//创建名字
        $ex->setType(AMQP_EX_TYPE_DIRECT);
        $ex->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
        $ex->declare();

        // 3.创建队列
        $q = new \AMQPQueue($channel);
        $q->setName($qname);
        $q->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
        $q->declare();
        $q->bind($ename,$rkey);

        // 4.发送
        $channel->startTransaction();
        $ex->publish($message, $rkey);
        $channel->commitTransaction();

        // 5.disconn
        $this->_link->disconnect();

        return true;
    }

    public function receive($qname) {

        // 0.conn
        $this->_link->connect();

        // 1.创建channel
        $channel = new \AMQPChannel($this->_link);

        // 3.创建队列
        $q = new \AMQPQueue($channel);
        $q->setName($qname);
        $q->setFlags(AMQP_DURABLE | AMQP_AUTODELETE);
        $q->declare();

        // 4.接收
        $message = $q->get();
        if (!$message) {
            return null;
        }
        $rst = $message->getBody();

        // 5.ack
        $q->ack($message->getDeliveryTag());

        // 6.disconn
        $this->_link->disconnect();

        return $rst;
    }


}