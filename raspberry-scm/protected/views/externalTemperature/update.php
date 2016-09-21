<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List ExternalTemperature', 'url' => array('index')),
    array('label' => 'Create ExternalTemperature', 'url' => array('create')),
    array('label' => 'View ExternalTemperature', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage ExternalTemperature', 'url' => array('admin')),
);
?>

<h1>Update ExternalTemperature <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
