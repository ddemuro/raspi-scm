<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */
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
        <?php echo $form->label($model, 'relay_number'); ?>
        <?php echo $form->textField($model, 'relay_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'action'); ?>
        <?php echo $form->textField($model, 'action'); ?>
    </div>

    <div class="row">
        <?php echo $form->label($model, 'log'); ?>
        <?php echo $form->textArea($model, 'log', array('rows' => 6, 'cols' => 50)); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Search'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- search-form -->
