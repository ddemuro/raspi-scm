<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs=array(
	'Relay Changes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List RelayChanges', 'url'=>array('index')),
	array('label'=>'Manage RelayChanges', 'url'=>array('admin')),
);
?>

<h1>Create RelayChanges</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>