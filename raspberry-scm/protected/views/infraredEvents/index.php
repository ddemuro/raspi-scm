<?php
/* @var $this InfraredEventsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Infrared Events',
);

$this->menu=array(
	array('label'=>'Create InfraredEvents', 'url'=>array('create')),
	array('label'=>'Manage InfraredEvents', 'url'=>array('admin')),
);
?>

<h1>Infrared Events</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
