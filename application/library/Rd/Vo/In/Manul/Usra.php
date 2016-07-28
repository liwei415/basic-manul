<?php
namespace Rd\Vo\In\Manul;

use Rd\Vo\Vo;

class Usra extends Vo {

    protected $uid = '';
    protected $name = '';
    protected $type = '';
    protected $cert = '';
    protected $cert_no = '';
    protected $mobile = '';

    protected $validate = array('uid' => array('required' => TRUE, 'min' => 0, 'max' => 20),
                                'name' => array('required' => TRUE, 'min' => 0, 'max' => 80),
                                'type' => array('required' => TRUE, 'min' => 0, 'max' => 1),
                                'cert' => array('required' => TRUE, 'min' => 0, 'max' => 3),
                                'cert_no' => array('required' => TRUE, 'min' => 0, 'max' => 30),
                                'mobile' => array('required' => TRUE, 'min' => 0, 'max' => 11));

    public function __construct($argv) {
        foreach ($argv as $key => $value) {
            $this->$key = $value;
        }
    }


}
