<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs=array(
	'Relay Changes'=>array('index'),
	$model->date,
);

$this->menu=array(
	array('label'=>'List RelayChanges', 'url'=>array('index')),
	array('label'=>'Create RelayChanges', 'url'=>array('create')),
	array('label'=>'Update RelayChanges', 'url'=>array('update', 'id'=>$model->date)),
	array('label'=>'Delete RelayChanges', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->date),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage RelayChanges', 'url'=>array('admin')),
);
?>

<h1>View RelayChanges #<?php echo $model->date; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'date',
		'relay_number',
		'action',
		'log',
	),
)); ?>
