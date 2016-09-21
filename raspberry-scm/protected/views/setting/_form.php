<?php
/* @var $this SettingController */
/* @var $model Setting */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'setting-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'setting_id'); ?>
		<?php echo $form->textField($model,'setting_id',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'setting_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'setting'); ?>
		<?php echo $form->textField($model,'setting',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'setting'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'extended'); ?>
		<?php echo $form->textArea($model,'extended',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'extended'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->