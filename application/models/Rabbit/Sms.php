<?php
namespace Rabbit;

class SmsModel {

    protected $ename_ = 'esms';
    protected $qname_ = 'qsms';
    protected $rkey_ = 'rsms';

    public function send($message) {
        $amqp = \Our\Rabbit::getInstance();
        return $amqp->send($this->ename_, $this->qname_, $this->rkey_, $message);
    }

    public function receive() {

        $amqp = \Our\Rabbit::getInstance();
        return $amqp->receive($this->qname_);
    }


}
