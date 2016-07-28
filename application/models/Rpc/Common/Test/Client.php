<?php
namespace Rpc\Common\Test;
use Thrift\ClassLoader\ThriftClassLoader;
use Thrift\Protocol\TBinaryProtocol;
use Thrift\Transport\TSocket;
use Thrift\Transport\THttpClient;
use Thrift\Transport\TBufferedTransport;
use Thrift\Exception\TException;
use Rpc\AbstractModel;
require_once realpath(dirname(__FILE__)) . '/gen-php/xx/tutorial/Calculator.php';
require_once realpath(dirname(__FILE__)) . '/gen-php/xx/tutorial/Types.php';
/**
 * @desc: 文件描述
 * ==============================================
 * roadoor.com Lib
 * 版权所有 @2015 roadoor.com
 * ----------------------------------------------
 * 这不是一个自由软件，未经授权不许任何使用和传播。
 * ----------------------------------------------
 * 权限（全局限制访问）
 * ==============================================
 * @date: 2016年6月24日 下午5:02:10
 * @author:liufeilong<liufeilong@roadoor.com>
 * @version: 2.0.0.0
 */
class ClientModel extends AbstractModel{

    /**
     * 继承父类方式
     * @param 参数类型 参数变量
     * @return
     * @date   : 2016年6月21日 下午12:00:29
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    protected function getRpcConfig(){
        return 'common';
    }
    /**
     * exec
     * @param $params 入参参数
     * @date   : 2016年6月24日 下午5:04:03
     * @author : liufeilong <liufeilong@roadoor.com>
     * @vesion : 2.0.0.0
     */
    public function exec($params){
        //1.根据配置获得相关配置信息
        $config = \Bootstrap::getRpcIniConfig($this->getRpcConfig());
        $api_key = \Bootstrap::getIniConfig($this->getRpcConfig(),'Test');
        
        try {
            //2.thrift初始化
            $socket = new THttpClient($config['ip'], $config['port'], $api_key);
            $transport = new TBufferedTransport($socket, 1024, 1024);
            $protocol = new TBinaryProtocol($transport);
            $client = new \xx\tutorial\CalculatorClient($protocol);
            $transport->open();

            //3.实际接口操作，实际逻辑操作
            $client->ping();
            

            $sum = $client->add(1,1);
            print "1+1=$sum\n";

            $work = new \xx\tutorial\Work();

            $work->op = \xx\tutorial\Operation::DIVIDE;
            $work->num1 = 1;
            $work->num2 = 0;

            try {
                $client->calculate(1, $work);
                print "Whoa! We can divide by zero?\n";
            } catch (\xx\tutorial\InvalidOperation $io) {
                print "InvalidOperation: $io->why\n";
            }

            $work->op = \xx\tutorial\Operation::SUBTRACT;
            $work->num1 = 15;
            $work->num2 = 10;
            $diff = $client->calculate(1, $work);
            print "15-10=$diff\n";
            //关闭thrift
            $transport->close();

        } catch (TException $tx) {
            print 'TException: '.$tx->getMessage()."\n";
        }
    }


}
