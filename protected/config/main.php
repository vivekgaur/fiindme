<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Fiind me',
	'homeUrl'=> array('deal/admin'),
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		// Add this comment
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'india1234',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				 // REST patterns
			 array('find/list', 'pattern'=>'find/<model:\w+>', 'verb'=>'GET'),
			 array('find/view', 'pattern'=>'find/<model:\w+>/<id:\d+>', 'verb'=>'GET'),
			 array('find/viewtotal', 'pattern'=>'find/<model:\w+>/total/<id:\d+>', 'verb'=>'GET'),
			 array('find/merchant', 'pattern'=>'find/<model:\w+>/merchant/<id:\d+>', 'verb'=>'GET'),
			 array('find/confirm', 'pattern'=>'find/<model:\w+>/merchant/<id:\d+>/<code:\d+>', 'verb'=>'PUT'),
			 array('find/update', 'pattern'=>'find/<model:\w+>/<id:\d+>', 'verb'=>'PUT'),
			 array('find/delete', 'pattern'=>'find/<model:\w+>/<id:\d+>', 'verb'=>'DELETE'),
			 array('find/create', 'pattern'=>'find/<model:\w+>', 'verb'=>'POST'),     
			 '<controller:\w+>/<id:\d+>'=>'<controller>/view',
			 '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
			 '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=fiindme_test',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'MeriMot1',
			'charset' => 'utf8',
		),
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'trace,info,error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);