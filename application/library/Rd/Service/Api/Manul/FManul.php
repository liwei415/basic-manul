<?php
namespace Rd\Service\Api\Sms;

class FSms {

    public static function factory($o) {

        switch ($o->method) {
        case 'post' :
            return new \Rd\Service\Api\Sms\Post($o);
        default :
            return 1001;
        }
    }


}
