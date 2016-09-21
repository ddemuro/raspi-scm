<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs = array(
    'Relay Changes' => array('index'),
    $model->date => array('view', 'id' => $model->date),
    'Update',
);

$this->menu = array(
    array('label' => 'List RelayChanges', 'url' => array('index')),
    array('label' => 'Create RelayChanges', 'url' => array('create')),
    array('label' => 'View RelayChanges', 'url' => array('view', 'id' => $model->date)),
    array('label' => 'Manage RelayChanges', 'url' => array('admin')),
);
?>

<h1>Update RelayChanges <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
