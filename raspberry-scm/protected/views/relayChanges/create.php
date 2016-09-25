<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs = array(
    'Relay Changes' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Relay Changes', 'url' => array('index')),
    array('label' => 'Manage Relay Changes', 'url' => array('admin')),
);
?>

<h1>Create Relay Changes</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
