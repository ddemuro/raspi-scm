<?php
/* @var $this ExternalTemperatureController */
/* @var $data ExternalTemperature */
?>

<?php if (isset($multi) && $multi == true): ?>
    <?php foreach ($model as $m): ?>
        <div class="view">

            <b><?php echo CHtml::encode($m->getAttributeLabel('date')); ?>:</b>
            <?php echo CHtml::link(CHtml::encode($m->date), array('view', 'id' => $m->date)); ?>
            <br />

            <b><?php echo CHtml::encode($m->getAttributeLabel('humidity')); ?>:</b>
            <?php echo CHtml::encode($m->humidity); ?>
            <br />

            <b><?php echo CHtml::encode($m->getAttributeLabel('temperature')); ?>:</b>
            <?php echo CHtml::encode($m->temperature); ?>
            <br />

            <b><?php echo CHtml::encode($m->getAttributeLabel('log')); ?>:</b>
            <?php echo CHtml::encode($m->log); ?>
            <br />

        </div>
    <?php endforeach; ?>
<?php else: ?>
            <div class="view">

            <b><?php echo CHtml::encode($model->getAttributeLabel('date')); ?>:</b>
            <?php echo CHtml::link(CHtml::encode($model->date), array('view', 'id' => $m->date)); ?>
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
<?php endif; ?>
