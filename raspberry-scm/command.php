<?php
// change the following paths if necessary
$yii = dirname(__FILE__) . '/framework/yii.php';
$config = dirname(__FILE__) . '/protected/config/';

// Define root directory
defined('ROOT_PATH') or define('ROOT_PATH', dirname(__FILE__) . '/');

// Make sure runtime and assets are properly chmod
if (!is_writeable(ROOT_PATH . 'protected/runtime')) {
    die('Please chmod 0777 ' . ROOT_PATH . 'protected/runtime');
}

$configFile = 'console.php';

//We load YII
require_once($yii);

Yii::createConsoleApplication($config.$configFile)->run();
