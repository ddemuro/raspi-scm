<?php
/* @var $this InternalTemperatureController */
/* @var $data InternalTemperature */
?>

<div class="view">

    <?php if(isset($data)): ?>
    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('temperature')); ?>:</b>
    <?php echo CHtml::encode($data->temperature); ?>
    <br />
    
   <?php endif; ?>

</div>
