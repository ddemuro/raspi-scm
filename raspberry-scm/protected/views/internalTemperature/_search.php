<?php
/* @var $this InternalTemperatureController */
/* @var $model InternalTemperature */
/* @var $form CActiveForm */
?>

<div class="wide form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <?php echo $form->label($model, 'date'); ?>
        <?php echo $form->textField($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'temperature'); ?>
        <?php echo $form->textField($model, 'temperature', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
