<?php
/* @var $this LoggerController */
/* @var $model Logger */

$this->breadcrumbs=array(
	'Loggers'=>array('index'),
	$model->date=>array('view','id'=>$model->date),
	'Update',
);

$this->menu=array(
	array('label'=>'List Logger', 'url'=>array('index')),
	array('label'=>'Create Logger', 'url'=>array('create')),
	array('label'=>'View Logger', 'url'=>array('view', 'id'=>$model->date)),
	array('label'=>'Manage Logger', 'url'=>array('admin')),
);
?>

<h1>Update Logger <?php echo $model->date; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>