<?php
namespace Rd\Vo\In\Manul;

class Usra {

    private $uid_ = '';
    private $name_ = '';
    private $type_ = '';
    private $cert_ = '';
    private $cert_no_ = '';
    private $mobile_ = '';

    private $error_ = NULL;

    private $validate = array('uid_' => array('required' => TRUE, 'min' => 0, 'max' => 20),
                              'name_' => array('required' => TRUE, 'min' => 0, 'max' => 80),
                              'type_' => array('required' => TRUE, 'min' => 0, 'max' => 1),
                              'cert_' => array('required' => TRUE, 'min' => 0, 'max' => 3),
                              'cert_no_' => array('required' => TRUE, 'min' => 0, 'max' => 30),
                              'mobile_' => array('required' => TRUE, 'min' => 0, 'max' => 11));

    public function getUid() {
        return $this->uid_;
    }

    public function getName() {
        return $this->name_;
    }

    public function getType() {
        return $this->type_;
    }

    public function getCert() {
        return $this->cert_;
    }

    public function getCertNo() {
        return $this->cert_no_;
    }

    public function getMobile() {
        return $this->mobile_;
    }

    public function getError() {
        return $this->error_;
    }

    public function __construct($argv) {
        foreach ($argv as $key => $value) {
            $this->{$key.'_'} = $value;
        }
    }

    public function validate(){
        if(count($this->validate) > 0){
            foreach ($this->validate as $key => $value) {
                if ($value['required'] == TRUE && !isset($this->{$key})) {
                    $this->error_ = $key . ' is not exists!';
                    return false;
                }

                if ($value['required'] == FALSE && !isset($this->$key)) {
                    continue;
                }

                if (isset($value['min']) && $value['min'] > strlen($this->$key)) {
                    $this->error_ = $key . ' length < ' . $value['min'];
                    return false;
                }

                if (isset($value['max']) && $value['max'] < strlen($this->$key)) {
                    $this->error_ = $key . ' length > ' . $value['max'];
                    return false;
                }
            }
        }
        else{
            $this->error_ = "validate is empty";
        }
        return true;
    }


}
