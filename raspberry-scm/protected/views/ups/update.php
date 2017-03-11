<?php
/* @var $this UpsController */
/* @var $model Ups */

$this->breadcrumbs = array(
    'Ups' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List Ups', 'url' => array('index')),
    array('label' => 'Create Ups', 'url' => array('create')),
    array('label' => 'View Ups', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage Ups', 'url' => array('admin')),
);
?>

<h1>Update Ups <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
