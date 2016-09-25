<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'relay-changes-form',
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
        <?php echo $form->labelEx($model, 'relay_number'); ?>
        <?php echo $form->textField($model, 'relay_number'); ?>
        <?php echo $form->error($model, 'relay_number'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'action'); ?>
        <?php echo $form->dropDownList($model, 'action', $categories); ?>
        <?php echo $form->error($model, 'action'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'log'); ?>
        <?php echo $form->textArea($model, 'log', array('rows' => 6, 'cols' => 50)); ?>
        <?php echo $form->error($model, 'log'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->
