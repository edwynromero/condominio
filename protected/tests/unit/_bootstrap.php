<?php
// Here you can initialize variables that will be available to your tests

$check_openshift = getenv('OPENSHIFT_MYSQL_DB_HOST');

if( empty($check_openshift) )
{
	define('DB_HOST', '127.0.0.1');
	define('DB_PORT', '3306');
	define('DB_USER', 'root');
	define('DB_PASS', '1234');
	define('DB_NAME', 'mirador_remoto');
	define('KLOG_SQL_ENABLE', true);
	define('KLOG_APP_ENABLE', true);
}
else 
{
	//  parametros de openshift
	define('DB_HOST', getenv('OPENSHIFT_MYSQL_DB_HOST'));
	define('DB_PORT',getenv('OPENSHIFT_MYSQL_DB_PORT'));
	define('DB_USER',getenv('OPENSHIFT_MYSQL_DB_USERNAME'));
	define('DB_PASS',getenv('OPENSHIFT_MYSQL_DB_PASSWORD'));
	define('DB_NAME',getenv('OPENSHIFT_GEAR_NAME'));
	define('KLOG_SQL_ENABLE', false);
	define('KLOG_APP_ENABLE', false);
}
require_once(dirname(__FILE__).'/../../vendor/autoload.php');
// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../../framework/yiit.php';
$config=dirname(__FILE__).'/../../config/test.php';

require_once($yiit);

Yii::createWebApplication($config);