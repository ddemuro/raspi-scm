<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List ExternalTemperature', 'url' => array('index')),
    array('label' => 'Manage ExternalTemperature', 'url' => array('admin')),
);
?>

<h1>Create ExternalTemperature</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
