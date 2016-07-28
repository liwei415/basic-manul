<?php
namespace Rd\Vo;

abstract class Vo {

    protected $validate = array();
    protected $error = NULL;

    public function getError() {
        return $this->error;
    }
    
    public function validate(){
        if(count($this->validate) > 0){
            foreach ($this->validate as $key => $value) {
                if ($value['required'] == TRUE && !isset($this->$key)) {
                    $this->error = $key . ' is not exists!';
                    return false;
                }

                if ($value['required'] == FALSE && !isset($this->$key)) {
                    continue;
                }

                if (isset($value['min']) && $value['min'] > strlen($this->$key)) {
                    $this->error = $key . ' length < ' . $value['min'];
                    return false;
                }

                if (isset($value['max']) && $value['max'] < strlen($this->$key)) {
                    $this->error = $key . ' length > ' . $value['max'];
                    return false;
                }
            }
        }else{
            $this->error = "validate is empty";
        }
        return true;
    }
}
