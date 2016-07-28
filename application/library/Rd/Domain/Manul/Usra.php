<?php
namespace Rd\Domain\Manul;

class Usra {

    private $id_ = null;
    private $ophone_ = null;
    private $iphone_ = null;
    private $content_ = null;
    private $channel_ = null;
    private $status_ = null;
    private $delay_ = null;
    private $create_time_ = null;
    private $update_time_ = null;

    public function getId() {
        return $this->id_;
    }

    public function setId($id) {
        $this->id_ = $id;
    }

    public function getOphone() {
        return $this->ophone_;
    }

    public function setOphone($ophone) {
        $this->ophone_ = $ophone;
    }

    public function getIphone() {
        return $this->ophone_;
    }

    public function setIphone($iphone) {
        $this->iphone_ = $iphone;
    }

    public function getContent() {
        return $this->content_;
    }

    public function setContent($content) {
        $this->content_ = $content;
    }

    public function getChannel() {
        return $this->channel_;
    }

    public function setChannel($channel) {
        $this->channel_ = $channel;
    }

    public function getStatus() {
        return $this->status_;
    }

    public function setStatus($status) {
        $this->status_ = $status;
    }

    public function getDelay() {
        return $this->delay_;
    }

    public function setDelay($delay) {
        $this->delay_ = $delay;
    }

    public function getCreateTime() {
        return $this->create_time_;
    }

    public function setCreateTime($create_time) {
        $this->create_time_ = $create_time;
    }

    public function getUpdateTime() {
        return $this->update_time_;
    }

    public function setUpdateTime($update_time) {
        $this->update_time_ = $update_time;
    }

    public function save() {

        $db = new \Mysql\MessageSmsSendLogModel();

        $fields = array();
        $fields['mssl_ophone'] = $this->ophone_;
        $fields['mssl_iphone'] = $this->iphone_;
        $fields['mssl_content'] = $this->content_;
        $fields['mssl_channel'] = $this->channel_;
        $fields['mssl_status'] = $this->status_;
        $fields['mssl_delay'] = $this->delay_;
        $fields['mssl_create_time'] = $this->create_time_;
        $fields['mssl_update_time'] = $this->update_time_;

        $db->begin();

        $rst = $db->add($fields);

        $db->commit();

        return $rst;
    }

    public function edit() {

        $db = new \Mysql\MessageSmsSendLogModel();

        // set fields cond bind
        $fields = array();
        $fields['mssl_status'] = $this->getStatus();
        $fields['mssl_update_time'] = $this->getUpdateTime();

        $cond = "mssl_id=:mssl_id";

        $bind = array();
        $bind[":mssl_id"] = $this->getId();

        $db->begin();

        $rst = $db->edit($fields, $cond, $bind);

        $db->commit();
        var_dump($rst);
        return $rst;
    }

    public function sendMQ() {
        $mq = new \Rabbit\SmsModel();

        $fields = array();
        $fields['mssl_id'] = $this->id_;
        $fields['mssl_ophone'] = $this->ophone_;
        $fields['mssl_iphone'] = $this->iphone_;
        $fields['mssl_content'] = $this->content_;
        $fields['mssl_channel'] = $this->channel_;
        $fields['mssl_status'] = $this->status_;
        $fields['mssl_delay'] = $this->delay_;
        $fields['mssl_create_time'] = $this->create_time_;
        $fields['mssl_update_time'] = $this->update_time_;

        $rst = $mq->send(json_encode($fields));

        return $rst;
    }

    public function receiveMQ() {

        $mq = new \Rabbit\SmsModel();

        $rst = $mq->receive();

        return $rst;
    }


}