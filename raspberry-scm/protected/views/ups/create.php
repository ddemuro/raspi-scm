<?php
/* @var $this UpsController */
/* @var $model Ups */

$this->breadcrumbs=array(
	'Ups'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Ups', 'url'=>array('index')),
	array('label'=>'Manage Ups', 'url'=>array('admin')),
);
?>

<h1>Create Ups</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>