<?php
/* @var $this LoggerController */
/* @var $model Logger */

$this->breadcrumbs = array(
    'Loggers' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List Logger', 'url' => array('index')),
    array('label' => 'Create Logger', 'url' => array('create')),
    array('label' => 'Update Logger', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete Logger', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Logger', 'url' => array('admin')),
);
?>

<h1>View Logger #<?php echo $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'log',
    ),
));
?>
