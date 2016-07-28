<?php

namespace tutorial\php;

error_reporting(E_ALL);

require_once __DIR__.'/../../../../../library/Thrift/ClassLoader/ThriftClassLoader.php';

use Thrift\ClassLoader\ThriftClassLoader;

$GEN_DIR = realpath(dirname(__FILE__)).'/gen-php';

$loader = new ThriftClassLoader();
$loader->registerNamespace('Thrift', '../../../../../library');
$loader->registerDefinition('rpc\sms', $GEN_DIR);
$loader->register();

use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;

try {
    $socket = new THttpClient('d.inux.xyz', 80, '/rpc/sms');

    $transport = new TBufferedTransport($socket, 1024, 1024);
    $protocol = new TBinaryProtocol($transport);
    $client = new \rpc\sms\ISmsRemoteServiceClient($protocol);

    $p1 = new \rpc\sms\CommonRequest();
    $p1->version = '2.1.2';
    $p1->method = 'post';
    $p1->source = 'pc';

    $p2 = new \rpc\sms\PostRequest();
    $p2->ophone = '13999999999';
    $p2->iphone = '13888888888';
    $p2->content = 'sbsb';
    $p2->channel = '2';
    $p2->delay = '2016-07-10 08:00:00';

    var_dump(5765675);
    $rst = $client->post($p1, $p2);
    var_dump($rst);

    $transport->close();

} catch (TException $tx) {
    print 'TException: '.$tx->getMessage()."\n";
}

?>
