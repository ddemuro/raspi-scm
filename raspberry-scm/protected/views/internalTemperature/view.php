<?php
/* @var $this InternalTemperatureController */
/* @var $model InternalTemperature */

$this->breadcrumbs = array(
    'Internal Temperatures' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List InternalTemperature', 'url' => array('index')),
    array('label' => 'Create InternalTemperature', 'url' => array('create')),
    array('label' => 'Update InternalTemperature', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete InternalTemperature', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage InternalTemperature', 'url' => array('admin')),
);
?>

<h1>View InternalTemperature #<?php echo $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'temperature',
    ),
));
?>
