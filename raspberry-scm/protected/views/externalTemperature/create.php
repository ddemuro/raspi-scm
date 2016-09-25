<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List External Temperature', 'url' => array('index')),
    array('label' => 'Manage External Temperature', 'url' => array('admin')),
);
?>

<h1>Create External Temperature</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
