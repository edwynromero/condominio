<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Urbanización Mirador Panamericano',
	'language'=>'es',

	// preloading 'log' component
	'preload'=>array('log', 'bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.banks.*',
		'ext.giix.components.*', // giix components
		'ext.bootstrap.helpers.*',
		'ext.bootstrap.widgets.*',
		'ext.formatCurrency.*',
        'ext.bootstrap.*',
		'ext.report.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class' => 'system.gii.GiiModule',
			'generatorPaths' => array(
				'ext.giix.generators', // giix generators
				'ext.bootstrap.gii',
			),
			'password'=>'12345678',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'backend',
			'auth' => array(
			  'strictMode' => true, // when enabled authorization items cannot be assigned children of the same type.
			  'userClass' => 'User', // the name of the user model class.
			  'userIdColumn' => 'id', // the name of the user id column.
			  'userNameColumn' => 'name', // the name of the user name column.
			  'defaultLayout' => 'application.views.layouts.main', // the layout used by the module.
			  'viewDir' => null, // the path to view files to use with this module.
			),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,			
			'class' => 'auth.components.AuthWebUser',
			'allowAutoLogin' => true,
		),
		
		'dpsMailer' => array(
				'class' => 'ext.dpsmailer.components.dpsMailer',
				'sViewPath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.'/views/emails',
				'aFrom' => array( 'noresponder@mirador.com.ve' => 'Mirador Panamericano - Sistema OnLine' ),
				'aBehaviors' => array(
						'swift' => array(
								'class' => 'ext.dpsmailer.behaviors.dpsSwiftMailerBehavior',
								'sLibPath'=> dirname(__FILE__).DIRECTORY_SEPARATOR.'..'.'/extensions/dpsmailer/vendors/swiftmailer/lib',
								'sTransport' => 'Swift_SmtpTransport',
								'aOptions' => array(
										'Host'			=> 'smtp.mailgun.org',
										'Port'			=> 587,
										'Encryption'	=> 'tls',
										'Username'		=> 'postmaster@tumirador.com.ve',
										'Password'		=> 'fbb133772d3087b031892043e1dfd9b1',
								),
						),
			),
		),		
		
		'localtime'=>array(
				'class'=>'LocalTime',
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
			'itemTable'=>'mip_auth_item', 				// Tabla que contiene los elementos de autorizacion
			'itemChildTable'=>'mip_auth_item_child', 	// Tabla que contiene los elementos padre-hijo
			'assignmentTable'=>'mip_auth_assignment', 	// Tabla que contiene la signacion usuario-autorizacion
			'behaviors'=>array(
				'class'=>'auth.components.AuthBehavior'
			),	
		),		
			
		'bootstrap' => array(
				'class' => 'ext.bootstrap.components.Bootstrap'
		),		
		
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		'messages' => array (
				'class'=>'MipPhpMessageSource',
				// Pending on core: http://code.google.com/p/yii/issues/detail?id=2624
				'extensionBasePaths' => array(
						'giix' => 'ext.giix.messages', // giix messages directory.
				),
		),		
		
		
		
		 'db'=>array(
		 		'connectionString' => 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME,
		 		'emulatePrepare' => true,
		 		'username' => DB_USER,
		 		'password' => DB_PASS,
		 		'charset' => 'utf8',
                                'enableProfiling'=>true,
                                'enableParamLogging'=>true,
		 ),
				
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'enabled'=>KLOG_APP_ENABLE,	
					'categories' => 'application',
					'class'=>'CFileLogRoute',
					'levels'=>'error,info,warning',//'error,trace,info,warning',
				),
				// uncomment the following to show log messages on web pages
				array(
					'categories' => 'system.db.*',
					'class'=>'CFileLogRoute',
					'enabled'=>KLOG_SQL_ENABLE,
					'LogFile'=>'mysql_query.log',
				),
			),
		),
            
                 'ePdf' => array(
                        'class'         => 'ext.yii-pdf.EYiiPdf',
                        'params'        => array(
                            'mpdf'     => array(
                                'librarySourcePath' => 'application.vendors.mpdf.*',
                                'constants'         => array(
                                    '_MPDF_TEMP_PATH' => Yii::getPathOfAlias('application.runtime'),
                                ),
                                'class'=>'mpdf', // the literal class filename to be loaded from the vendors folder
                                'defaultParams'     => array( // More info: http://mpdf1.com/manual/index.php?tid=184
                                    'mode'              => '', //  This parameter specifies the mode of the new document.
                                    'format'            => 'Letter', // format A4, A5, ...
                                    'default_font_size' => 0, // Sets the default document font size in points (pt)
                                    'default_font'      => '', // Sets the default font-family for the new document.
                                    'mgl'               => 15, // margin_left. Sets the page margins for the new document.
                                    'mgr'               => 15, // margin_right
                                    'mgt'               => 40, // margin_top
                                    'mgb'               => 30, // margin_bottom
                                    'mgh'               => 9, // margin_header
                                    'mgf'               => 9, // margin_footer
                                    'orientation'       => 'P', // landscape or portrait orientation
                                )
                            )
                        ),
                    ),
            
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'roger.zavala@koiosoft.com',
                'pad_key_at_report' => 6,
                'report' => array(
                    'defaults_download_filename' =>'Download Filename d/m/y',
                    'account_state_download_filename' =>'Download State Account Report Filename @location@ @date@'
                ),
                'bank_account'=>array(
                    'year_max' => 4,
                    'months' => array(
                        1=>"January",
                        2=>"February",
                        3=>"March",
                        4=>"April",
                        5=>"May",
                        6=>"June",
                        7=>"July",
                        8=>"August",
                        9=>"September",
                        10=>"October",
                        11=>"November",
                        12=>"December",
                    ),
                ),
		'location_status_list'=>array( 
			'A'=>'Activo', 
			'V'=>'Vendido no Activo', 
			'S'=>'Sin Vender' 
		),
		'group_persons_type_list'=>array( 
			'F'=>'Familia', 
			'E' => 'Empresa' 
		),
		'identity_type_list'=>array( 
			'V'=>'Venezolano', 
			'E' => 'Extranjero', 
			'J' => 'Persona Jurídica', 
			'F'=>'Firma Personal', 
			'G' => 'Ente Gubernamental', 
		),
		'phone_type'=>array( 
			'P'=>'Personal', 
			'H'=>'Casa', 
			'W'=>'Trabajo', 
			'PM'=>'Móvil Personal', 
			'MW'=>'Móvil Trabajo', 
			'O'=>'Otro',
		),
		'email_type'=>array(
			'P'=>'Personal', 
			'W'=>'Trabajo', 
			'O'=>'Otro'
		),
		'not_cash_type_list'=>array( 
			'C'=>'Cheque', 
			'V'=>'Voucher', 
			'T'=>'Transferencia'
		),
		'voucher_key'=>'V',
		'default_country'=>'VE',
		'report_max_feeds_unpaied'=>7,
                'path_to_upload_bank_resume' => '/uploads/csv',
                'bank_account_summary_interval' => array('MIN_YEAR' => 2013),
                'accouting_alias' => '100000',
	),
);
	
	
