<?php
namespace Rd\Service\Hdl\Sms;

class Post {

    private $var_ = null;

    public function __construct($var = null) {
        $this->var_ = $var;
    }

    // 同步接口 exec
    public function exec() {

        return 'Hdl example';
    }

    // 异步生产 producer
    public function producer() {

        // 0.create object
        $sms_log = new \Rd\Domain\Sms\Log();
        $sms_log->setOphone($this->var_->getOphone());
        $sms_log->setIphone($this->var_->getIphone());
        $sms_log->setContent($this->var_->getContent());
        $sms_log->setChannel($this->var_->getChannel());
        $sms_log->setStatus(0);
        $sms_log->setDelay($this->var_->getDelay());
        $sms_log->setCreateTime(date('Y-m-d H:i:s'));
        $sms_log->setUpdateTime(date('Y-m-d H:i:s'));

        // 1.db
        $sms_log_id = $sms_log->save();
        $sms_log->setId($sms_log_id);
        // 2.mq
        $sms_log->sendMQ();
        return 'Hdl producer';
    }

    // 异步消费 consumer
    public function consumer() {

        // 0.create object
        $sms_log = new \Rd\Domain\Sms\Log();

        // 1.mq
        $message = json_decode($sms_log->receiveMQ());
        if (!$message) {
            return null;
        }

        // 2.发送

        // 3.db
        $sms_log->setId($message->mssl_id);
        $sms_log->setStatus(1);
        $sms_log->setUpdateTime(date('Y-m-d H:i:s'));

        $sms_log->edit();

        return $message;
    }


}