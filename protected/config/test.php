<?php

return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
  
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
				'basePath' =>dirname(__FILE__) . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'tests' . DIRECTORY_SEPARATOR . 'fixtures' . DIRECTORY_SEPARATOR 
			),
			//uncomment the following to provide test database connection
			/*'db'=>array(
		 		'connectionString' => 'mysql:host=localhost;port=80;dbname=mirador_remoto',
		 		'emulatePrepare' => true,
		 		'username' => 'root',
		 		'password' => '',
		 		'charset' => 'utf8',
		 		'enableParamLogging'=>false,
		           ),
			*/
		),
	)
);
