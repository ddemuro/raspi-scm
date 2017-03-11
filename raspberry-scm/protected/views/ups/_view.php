<?php
/* @var $this UpsController */
/* @var $data Ups */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('ups_details')); ?>:</b>
    <?php echo CHtml::encode($data->ups_details); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('setting')); ?>:</b>
    <?php echo CHtml::encode($data->setting); ?>
    <br />


</div>
