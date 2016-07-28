<?php

namespace Rd\Service\Rpc\Sms;

use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TPhpStream;
use Thrift\Transport\TBufferedTransport;

// todo 试一试去掉哪个可以正常运行
require_once realpath(dirname(__FILE__)) . '/gen-php/rpc/sms/ISmsRemoteService.php';
require_once realpath(dirname(__FILE__)) . '/gen-php/rpc/sms/Types.php';

class Server {

    public function run() {

        $handler = new \Rd\Service\Rpc\Sms\Handler();
        $processor = new \rpc\sms\ISmsRemoteServiceProcessor($handler);

        $transport = new TBufferedTransport(new TPhpStream(TPhpStream::MODE_R | TPhpStream::MODE_W));
        $protocol = new TBinaryProtocol($transport, true, true);

        $transport->open();
        $processor->process($protocol, $protocol);
        $transport->close();
    }


}
