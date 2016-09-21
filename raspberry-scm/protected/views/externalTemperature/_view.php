<?php
/* @var $this ExternalTemperatureController */
/* @var $data ExternalTemperature */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('humidity')); ?>:</b>
    <?php echo CHtml::encode($data->humidity); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('temperature')); ?>:</b>
    <?php echo CHtml::encode($data->temperature); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('log')); ?>:</b>
    <?php echo CHtml::encode($data->log); ?>
    <br />


</div>
