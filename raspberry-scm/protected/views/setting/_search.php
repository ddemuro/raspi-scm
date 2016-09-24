<?php
/* @var $this SettingController */
/* @var $model Setting */
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
        <?php echo $form->label($model, 'id'); ?>
        <?php echo $form->textField($model, 'id'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'setting_id'); ?>
        <?php echo $form->textField($model, 'setting_id', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'setting'); ?>
        <?php echo $form->textField($model, 'setting', array('size' => 60, 'maxlength' => 255)); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'extended'); ?>
        <?php echo $form->textArea($model, 'extended', array('rows' => 6, 'cols' => 50)); ?>
    </div>
    
    <div class="row">
        <?php echo $form->label($model, 'comment'); ?>
        <?php echo $form->textArea($model, 'comment', array('rows' => 10, 'cols' => 50)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
