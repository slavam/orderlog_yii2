<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'WEB-ЗАКАЗ',
    'sourceLanguage' => 'ru',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '12345678',
        // If removed, Gii defaults to localhost only. Edit carefully to taste.
        //'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),

        
        'urlManager'=>array(
		'urlFormat'=>'path',
		'rules'=>array(
        		'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
        	),
        ),
        


        // uncomment the following to enable URLs in path-format
        /*
          'urlManager'=>array(
          'urlFormat'=>'path',
          'rules'=>array(
          '<controller:\w+>/<id:\d+>'=>'<controller>/view',
          '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
          '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
          ),
          ),
         */
        'db' => array(
            'connectionString' => 'pgsql:host=dev1-d00;port=5432;dbname=orderlog_development',
            'username' => 'postgres',
            'password' => 'postgres',
            'charset' => 'UTF8',
            'enableProfiling' => true,
        ),
        'db1' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'oci:dbname=XE_FD;charset=UTF8', //FIN.DEP
            'username' => 'v_morhachov',
            'password' => 'v_morhachov',
            'enableProfiling' => true,
        ),
        'db3' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'oci:dbname=SRBANK3',
            'username' => 'kpi',
            'password' => 'MVM55010101',
            'charset' => 'UTF8',
            'enableProfiling' => true,
        ),
        'db4' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'sqlsrv:Server=appsrv\sqlexpress;Database=pxsuite', // mssql:host=localhost;dbname=testdb
            'username' => 'vbrdoc',
            'password' => '1q2w3e4r5t',
            'charset' => 'UTF8',
            'enableProfiling' => true,
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
/*
        'ClientScript' => array(
            'class' => 'ClientScript',
            'scriptMap' => array(
                //'jqueryForm' => Yii::app()->request->baseUrl.'/js/jquery.form.js',
                'jqueryForm' => 'http://127.0.0.1/demos/ordertest/js/jquery.form.js'
            ),
        ),
*/
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);