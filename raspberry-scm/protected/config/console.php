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

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
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
    // application components
    'components' => array(
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning, trace, profile, info',
                ),
            ),
        ),
        'functions' => array('class' => 'application.components.Functions',),
        'TemperatureController' => array('class' => 'application.components.TemperatureController',),
        'RelayController' => array('class' => 'application.components.RelayController',),
        'InfraredManager' => array('class' => 'application.components.InfraredManager',),
        'RootElevator' => array('class' => 'application.components.RootElevator',),
        'phpseclib' => array('class' => 'ext.phpseclib.PhpSecLib'),
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
