<?php
/* @var $this InternalTemperatureController */
/* @var $data InternalTemperature */
?>

<div class="view">

    <?php if(isset($model)): ?>
    <b><?php echo CHtml::encode($model->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($model->date), array('view', 'id' => $model->date)); ?>
    <br />

    <b><?php echo CHtml::encode($model->getAttributeLabel('temperature')); ?>:</b>
    <?php echo CHtml::encode($model->temperature); ?>
    <br />
    
   <?php endif; ?>

</div>
