<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs = array(
    'Infrared Events' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Infrared Events', 'url' => array('index')),
    array('label' => 'Manage Infrared Events', 'url' => array('admin')),
);
?>

<h1>Create Infrared Events</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
