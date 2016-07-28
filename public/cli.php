<?php

ini_set('session.name', 'PHPSESSID_BASIC_MANUL');

/* 错误打印到网页: 0 & 1 */
if (ini_get('yaf.environ') == 'develop') {
    ini_set('display_errors', 1);
}

date_default_timezone_set("Asia/Shanghai");
mb_internal_encoding("UTF-8");
define("APPLICATION_PATH", realpath(dirname(__FILE__) . '/../'));
define("DS", '/');
define("PUBLIC_PATH", realpath(dirname(__FILE__)));

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/application/library'),
    get_include_path(),
)));

$app = new \Yaf\Application(APPLICATION_PATH . "/conf/application.ini", ini_get('yaf.environ'));

if (isset($argc) && $argc == 4) {
    //使用方法: php -f path_to_cli Module Controller Action Json_params
    $request = new \Yaf\Request\Simple("CLI", ucfirst(strtolower($argv[1])), ucfirst(strtolower($argv[2])), ucfirst(strtolower($argv[3])), array());
}
else {
    $request = new \Yaf\Request\Simple();
}

$app->bootstrap()->getDispatcher()->dispatch($request);


?>
