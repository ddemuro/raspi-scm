<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List ExternalTemperature', 'url' => array('index')),
    array('label' => 'Create ExternalTemperature', 'url' => array('create')),
    array('label' => 'Update ExternalTemperature', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete ExternalTemperature', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ExternalTemperature', 'url' => array('admin')),
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
