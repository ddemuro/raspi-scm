<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs = array(
    'Infrared Events' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List Infrared Events', 'url' => array('index')),
    array('label' => 'Create Infrared Events', 'url' => array('create')),
    array('label' => 'Update Infrared Events', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete Infrared Events', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Infrared Events', 'url' => array('admin')),
);
?>

<h1>View Infrared Events #<?php echo $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'device',
        'event',
        'extended',
    ),
));
?>
