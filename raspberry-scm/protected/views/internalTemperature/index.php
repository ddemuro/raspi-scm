<?php
/* @var $this InternalTemperatureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Internal Temperatures',
);

$this->menu=array(
	array('label'=>'Create InternalTemperature', 'url'=>array('create')),
	array('label'=>'Manage InternalTemperature', 'url'=>array('admin')),
);
?>

<h1>Internal Temperatures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
