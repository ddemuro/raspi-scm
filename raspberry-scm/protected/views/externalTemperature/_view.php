<?php
/* @var $this ExternalTemperatureController */
/* @var $data ExternalTemperature */
?>
<?php if (isset($data)): ?>
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

<?php if (isset($model)): ?>
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
