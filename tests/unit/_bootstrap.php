<?php
// Here you can initialize variables that will be available to your tests
require_once(dirname(__FILE__).'/../../vendor/autoload.php');
// change the following paths if necessary
$yiit=dirname(__FILE__).'/../../framework/yiit.php';
$config=dirname(__FILE__).'/../../protected/config/test.php';

require_once($yiit);

Yii::createWebApplication($config);