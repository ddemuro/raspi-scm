<?php
/* @var $this LoggerController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Loggers',
);

$this->menu=array(
	array('label'=>'Create Logger', 'url'=>array('create')),
	array('label'=>'Manage Logger', 'url'=>array('admin')),
);
?>

<h1>Loggers</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
