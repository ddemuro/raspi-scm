<?php
/* @var $this LoggerController */
/* @var $data Logger */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('log')); ?>:</b>
    <?php echo CHtml::encode($data->log); ?>
    <br />


</div>
