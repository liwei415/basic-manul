<?php
namespace Rd\Service\Api\Manul;

class FManul {

    public static function factory($o) {

        switch ($o->method) {
        case 'usra' :
            return new \Rd\Service\Api\Manul\Usra($o);
        default :
            return 1001;
        }
    }


}
