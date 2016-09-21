<?php
/* @var $this ExternalTemperatureController */
/* @var $model ExternalTemperature */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'date'); ?>
		<?php echo $form->textField($model,'date'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'humidity'); ?>
		<?php echo $form->textField($model,'humidity'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'temperature'); ?>
		<?php echo $form->textField($model,'temperature'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'log'); ?>
		<?php echo $form->textArea($model,'log',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->