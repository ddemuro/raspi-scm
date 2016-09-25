<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */

$this->breadcrumbs = array(
    'External Temperatures' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List External Temperature', 'url' => array('index')),
    array('label' => 'Create External Temperature', 'url' => array('create')),
    array('label' => 'View External Temperature', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage External Temperature', 'url' => array('admin')),
);
?>

<h1>Update External Temperature <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
