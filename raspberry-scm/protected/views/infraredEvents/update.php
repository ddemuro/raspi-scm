<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs = array(
    'Infrared Events' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List Infrared Events', 'url' => array('index')),
    array('label' => 'Create Infrared Events', 'url' => array('create')),
    array('label' => 'View Infrared Events', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage Infrared Events', 'url' => array('admin')),
);
?>

<h1>Update Infrared Events <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
