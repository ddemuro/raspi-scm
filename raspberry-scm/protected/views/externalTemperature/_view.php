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
<?php endif; ?>
