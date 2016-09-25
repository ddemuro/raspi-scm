<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs = array(
    'Relay Changes' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List Relay Changes', 'url' => array('index')),
    array('label' => 'Create Relay Changes', 'url' => array('create')),
    array('label' => 'View Relay Changes', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage Relay Changes', 'url' => array('admin')),
);
?>

<h1>Update Relay Changes <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
