<?php

// Load main config file
$main = include_once('main.php');

// Production configurations
$production = array(    
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => '************',
        'alertEmail' => array('************'),
        'external_sensor_program' => '/opt/raspberrypi/temperature/dht_sensor',
        //'ups_status' => '/usr/sbin/upsc',
        'cpu_tmp' => '/sys/class/thermal/thermal_zone0/temp',
        'gpu_tmp' => '/opt/vc/bin/vcgencmd measure_temp',
        //'crelay' => '/opt/raspberrypi/relay/crelay.bin',
        ///'crelay_url' => 'http://localhost:8000/gpio',
        //'infrared_prog' => 'irsend',
        // Exceeded this temperature/humidity alerts will resume every half the anti-spam.
        'max_temp' => '30',
        'min_temp' => '5',
        'min_humidity' => '40',
        'max_humidity' => '80',
        // Alert will be issued but not if during antispam.
        'max_warn_temp' => '20',
        'min_warn_temp' => '15',
        'warn_humidity' => '60',
        // How long to supress alerts in minutes.
        'mail_antispam' => '30',
        // Every how long to check
        'run_every' => '10',
        // Password
        'rootpwd' => '************',
        // How many days can the key be used
        'loggedInDays' => '60'
    ),
);

// we merge everything with the extra dbs
$wdb = CMap::mergeArray($production, $main);

//merge both configurations and return them
return CMap::mergeArray($main, $wdb);
