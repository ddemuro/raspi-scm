<?php
/* @var $this RelayChangesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Relay Changes',
);

$this->menu=array(
	array('label'=>'Create RelayChanges', 'url'=>array('create')),
	array('label'=>'Manage RelayChanges', 'url'=>array('admin')),
);
?>

<h1>Relay Changes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
