<?php

// Load main config file
$main = include_once('main.php');

// Production configurations
$production = array(
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
        'crelay_url' => 'http://localhost:8000/gpio',
        'infrared_prog' => 'irsend',
        'max_temp' => '31',
        'min_temp' => '16',
        'max_warn_temp' => '28',
        'min_warn_temp' => '20',
        'rootpwd' => 'xxxxxx',
    ),
);

// we merge everything with the extra dbs
$wdb = CMap::mergeArray($production, $main);

//merge both configurations and return them
return CMap::mergeArray($main, $wdb);
