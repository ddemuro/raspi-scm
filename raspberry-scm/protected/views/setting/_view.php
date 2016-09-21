<?php
/* @var $this SettingController */
/* @var $data Setting */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id' => $data->id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('setting_id')); ?>:</b>
    <?php echo CHtml::encode($data->setting_id); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('setting')); ?>:</b>
    <?php echo CHtml::encode($data->setting); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('extended')); ?>:</b>
    <?php echo CHtml::encode($data->extended); ?>
    <br />


</div>
