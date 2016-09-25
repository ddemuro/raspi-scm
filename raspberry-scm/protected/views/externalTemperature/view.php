<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List External Temperature', 'url' => array('index')),
    array('label' => 'Create External Temperature', 'url' => array('create')),
    array('label' => 'Update External Temperature', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete External Temperature', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage External Temperature', 'url' => array('admin')),
);
?>

<h1>View ExternalTemperature #<?php echo $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'humidity',
        'temperature',
        'log',
    ),
));
?>
