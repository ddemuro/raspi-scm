<?php
/* @var $this InternalTemperatureController */
/* @var $data InternalTemperature */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('temperature')); ?>:</b>
    <?php echo CHtml::encode($data->temperature); ?>
    <br />


</div>
