<?php
/* @var $this ExternalTemperatureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'External Temperatures',
);

$this->menu=array(
	array('label'=>'Create ExternalTemperature', 'url'=>array('create')),
	array('label'=>'Manage ExternalTemperature', 'url'=>array('admin')),
);
?>

<h1>External Temperatures</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
