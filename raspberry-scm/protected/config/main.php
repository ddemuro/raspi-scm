<?php

// Sort cache options
$caches = array();
$fastCache = true;

// Sort the type of cache to use
if (function_exists('xcache_isset') &&
        ini_get('xcache.size') != 0 &&
        ini_get('xcache.mmap_path') != '/dev/zero') {
    // Using XCache
    $caches = array('class' => 'CXCache');
} else if (extension_loaded('apc')) {
    // Using APC
    $caches = array('class' => 'CApcCache');
} else if (function_exists('eaccelerator_get')) {
    // Using Eaccelerator
    $caches = array('class' => 'CEAcceleratorCache');
} else if (function_exists('zend_shm_cache_store')) {
    // Using ZendDataCache
    $caches = array('class' => 'CZendDataCache');
} else {
    // Using File Cache - fallback
    $caches = array('class' => 'CFileCache');
    $fastCache = false;
}

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Raspberry Remote Management System',
    // preloading 'log' component
    'preload' => array('log', 'session', 'db', 'cache', 'phpseclib'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.extensions.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'test',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('192.168.1.*', '::1'),
        ),
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CWebLogRoute',
                    'enabled' => true,
                    'levels' => 'info',
                ),
                array(
                    'class' => 'CProfileLogRoute',
                    'enabled' => false,
                ),
                array(
                    'logFile' => 'traceDebug.log',
                    'class' => 'CFileLogRoute',
                    'levels' => 'error,info, warning',
                ),
                array(
                    'class' => 'application.extensions.yiidebugtb.XWebDebugRouter',
                    'config' => 'alignLeft, opaque, runInDebug, fixedPos, collapsed, yamlStyle',
                    'levels' => 'error, warning, trace, profile, info',
                ),
            ),
        ),
        'functions' => array('class' => 'application.components.Functions',),
        'TemperatureController' => array('class' => 'application.components.TemperatureController',),
        'RelayController' => array('class' => 'application.components.RelayController',),
        'InfraredManager' => array('class' => 'application.components.InfraredManager',),
        'RootElevator' => array('class' => 'application.components.RootElevator',),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'ddemuro@gmail.com',
        'external_sensor_program' => '/opt/raspberrypi/dht_sensor/dht_sensor',
        'ups_status' => '/usr/sbin/upsc',
        'cpu_tmp' => '/sys/class/thermal/thermal_zone0/temp',
        'gpu_tmp' => '/opt/vc/bin/vcgencmd measure_temp',
        'crelay' => '/opt/raspberrypi/crelay',
        'infrared_prog' => 'irsend',
        'max_temp' => '31',
        'min_temp' => '16',
        'rootpwd' => 'xxxxxx',
    ),
);
