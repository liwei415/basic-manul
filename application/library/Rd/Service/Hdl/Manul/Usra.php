<?php
namespace Rd\Service\Hdl\Manul;

class Usra {

    private $var_ = null;

    public function __construct($var = null) {
        $this->var_ = $var;
    }

    // 同步接口 exec
    public function exec() {

        $usra = new \Rd\Domain\Manul\Usra();
        $usra->setOphone($this->var_->getOphone());

        return 'Hdl example';
    }


}