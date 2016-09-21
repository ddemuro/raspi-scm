<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */

$this->breadcrumbs=array(
	'Infrared Events'=>array('index'),
	$model->date=>array('view','id'=>$model->date),
	'Update',
);

$this->menu=array(
	array('label'=>'List InfraredEvents', 'url'=>array('index')),
	array('label'=>'Create InfraredEvents', 'url'=>array('create')),
	array('label'=>'View InfraredEvents', 'url'=>array('view', 'id'=>$model->date)),
	array('label'=>'Manage InfraredEvents', 'url'=>array('admin')),
);
?>

<h1>Update InfraredEvents <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>