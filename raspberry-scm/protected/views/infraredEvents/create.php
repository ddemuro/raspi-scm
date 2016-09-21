<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs = array(
    'Infrared Events' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List InfraredEvents', 'url' => array('index')),
    array('label' => 'Manage InfraredEvents', 'url' => array('admin')),
);
?>

<h1>Create InfraredEvents</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
