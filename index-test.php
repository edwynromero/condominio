<?php
/**
 * This is the bootstrap file for test application.
 * This file should be removed when the application is deployed for production.
 */

$check_openshift = getenv('OPENSHIFT_MYSQL_DB_HOST');

if( empty($check_openshift) )
{
	define('DB_HOST', '127.0.0.1');
	define('DB_PORT', '80');
	define('DB_USER', 'root');
	define('DB_PASS', '12345678');
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

// change the following paths if necessary
$yii=dirname(__FILE__).'/framework/yii.php';
$config=dirname(__FILE__).'/protected/config/test.php';

// remove the following line when in production mode
defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);
Yii::createWebApplication($config)->run();
