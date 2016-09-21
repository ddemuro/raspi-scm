<?php
/* @var $this InternalTemperatureController */
/* @var $model InternalTemperature */

$this->breadcrumbs = array(
    'Internal Temperatures' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List InternalTemperature', 'url' => array('index')),
    array('label' => 'Manage InternalTemperature', 'url' => array('admin')),
);
?>

<h1>Create InternalTemperature</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
