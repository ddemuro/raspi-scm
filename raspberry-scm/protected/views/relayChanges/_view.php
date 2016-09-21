<?php
/* @var $this RelayChangesController */
/* @var $data RelayChanges */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id'=>$data->date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('relay_number')); ?>:</b>
	<?php echo CHtml::encode($data->relay_number); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('action')); ?>:</b>
	<?php echo CHtml::encode($data->action); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('log')); ?>:</b>
	<?php echo CHtml::encode($data->log); ?>
	<br />


</div>