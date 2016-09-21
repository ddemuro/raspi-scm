<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs=array(
	'Infrared Events'=>array('index'),
	$model->date,
);

$this->menu=array(
	array('label'=>'List InfraredEvents', 'url'=>array('index')),
	array('label'=>'Create InfraredEvents', 'url'=>array('create')),
	array('label'=>'Update InfraredEvents', 'url'=>array('update', 'id'=>$model->date)),
	array('label'=>'Delete InfraredEvents', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->date),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage InfraredEvents', 'url'=>array('admin')),
);
?>

<h1>View InfraredEvents #<?php echo $model->date; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'date',
		'device',
		'event',
		'extended',
	),
)); ?>
