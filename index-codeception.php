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
// Definitions
$yii=dirname(__FILE__).'/framework/yii.php';
$yiit=dirname(__FILE__).'/framework/yiit.php';
$config=dirname(__FILE__).'/protected/config/test_functional.php';


defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('YII_DEBUG') or define('YII_DEBUG',true);
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);

// Load Yii and Composer extensions
require_once($yii);
require_once __DIR__.DS.'vendor'.DS.'autoload.php';
return array(
       'class' => 'CWebApplication',
       'config' => $config,
);
