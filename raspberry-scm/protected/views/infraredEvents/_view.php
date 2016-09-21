<?php
/* @var $this InfraredEventsController */
/* @var $data InfraredEvents */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id'=>$data->date)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('device')); ?>:</b>
	<?php echo CHtml::encode($data->device); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('event')); ?>:</b>
	<?php echo CHtml::encode($data->event); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('extended')); ?>:</b>
	<?php echo CHtml::encode($data->extended); ?>
	<br />


</div>