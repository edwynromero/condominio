<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
    
	// autoloading model and component classes
	'import'=>array(
        'application.components.*',
		'application.components.migrations.*',
        'application.components.commands.*',
        'application.models.*',
        'application.models.base.*',
        'ext.giix.components.*',
	),


	// application components
	'components'=>array(	
		
		 'db'=>array(
                    'connectionString' => 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME,
                    'emulatePrepare' => true,
                    'username' => DB_USER,
                    'password' => DB_PASS,
                    'charset' => 'utf8',
                    'enableProfiling'=>true,
                    'enableParamLogging'=>true,
		 ),
		// uncomment the following to use a MySQL database
		/*
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=testdrive',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);