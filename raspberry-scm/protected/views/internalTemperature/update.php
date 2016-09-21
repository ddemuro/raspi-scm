<?php
/* @var $this InternalTemperatureController */
/* @var $model InternalTemperature */

$this->breadcrumbs = array(
    'Internal Temperatures' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List InternalTemperature', 'url' => array('index')),
    array('label' => 'Create InternalTemperature', 'url' => array('create')),
    array('label' => 'View InternalTemperature', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage InternalTemperature', 'url' => array('admin')),
);
?>

<h1>Update InternalTemperature <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
