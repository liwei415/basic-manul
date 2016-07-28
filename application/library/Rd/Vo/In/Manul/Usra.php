<?php
namespace Rd\Vo\In\Sms;

use Rd\Vo\Vo;

class Post extends Vo {

    protected $ophone = null;
    protected $iphone = null;
    protected $content = null;
    protected $channel = null;
    protected $delay = null;

    protected $validate = array('ophone' => array('required' => TRUE, 'min' => 0, 'max' => 11),
                                'iphone' => array('required' => TRUE, 'min' => 0, 'max' => 11),
                                'content' => array('required' => TRUE, 'min' => 0, 'max' => 70),
                                'channel' => array('required' => TRUE, 'min' => 0, 'max' => 1),
                                'delay' => array('required' => TRUE, 'min' => 0, 'max' => 32));

    public function getOphone() {
        return $this->ophone;
    }

    public function getIphone() {
        return $this->iphone;
    }

    public function getContent() {
        return $this->content;
    }

    public function getChannel() {
        return $this->channel;
    }

    public function getDelay() {
        return $this->delay;
    }

    public function __construct($argv) {
        foreach ($argv as $key => $value) {
            $this->$key = $value;
        }
    }


}
