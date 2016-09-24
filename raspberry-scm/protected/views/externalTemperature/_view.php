<?php
/* @var $this ExternalTemperatureController */
/* @var $data ExternalTemperature */
?>

<?php 
if (isset($multi) && $multi == true): ?>
    <?php foreach($multi as $model): ?>
    <div class="view">

        <b><?php echo CHtml::encode($model->getAttributeLabel('date')); ?>:</b>
        <?php echo CHtml::link(CHtml::encode($model->date), array('view', 'id' => $model->date)); ?>
        <br />

        <b><?php echo CHtml::encode($model->getAttributeLabel('humidity')); ?>:</b>
        <?php echo CHtml::encode($model->humidity); ?>
        <br />

        <b><?php echo CHtml::encode($model->getAttributeLabel('temperature')); ?>:</b>
        <?php echo CHtml::encode($model->temperature); ?>
        <br />

        <b><?php echo CHtml::encode($model->getAttributeLabel('log')); ?>:</b>
        <?php echo CHtml::encode($model->log); ?>
        <br />

    </div>

    <?php endforeach; ?>
<?php else: ?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('date')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->date), array('view', 'id' => $data->date)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('humidity')); ?>:</b>
    <?php echo CHtml::encode($data->humidity); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('temperature')); ?>:</b>
    <?php echo CHtml::encode($data->temperature); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('log')); ?>:</b>
    <?php echo CHtml::encode($data->log); ?>
    <br />

</div>

<?php endif; ?>
