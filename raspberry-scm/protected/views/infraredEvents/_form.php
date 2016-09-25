<?php
/* @var $this InfraredEventsController */
/* @var $model InfraredEvents */
/* @var $form CActiveForm */
$categories = array(
    // Turn ON and OFF AC.
    0 => 'KEY_POWER',
    // Change temp up on AC
    1 => 'KEY_VOLUMEUP',
    // Change temp on AC down
    2 => 'KEY_VOLUMEDOWN',
    // 
    3 => 'KEY_T',
    // Change Mode
    4 => 'KEY_FN',
    5 => 'KEY_BRIGHTNESSUP',
    6 => 'KEY_BRIGHTNESSDOWN',
    7 => 'KEY_BRIGHTNESS_ZERO',
    8 => 'KEY_SLEEP',
    9 => 'KEY_TIME',
);
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'infrared-events-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'date'); ?>
        <?php echo $form->textField($model, 'date'); ?>
        <?php echo $form->error($model, 'date'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'device'); ?>
        <?php echo $form->textField($model, 'device', array('size' => 60, 'maxlength' => 255)); ?>
        <?php echo $form->error($model, 'device'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'event'); ?>
        <?php echo $form->dropDownList($model, 'event', $categories); ?>
        <?php echo $form->error($model, 'event'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'extended'); ?>
        <?php echo $form->textArea($model, 'extended', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'extended'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
