<?php
/* @var $this LoggerController */
/* @var $model Logger */

$this->breadcrumbs = array(
    'Loggers' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Logger', 'url' => array('index')),
    array('label' => 'Manage Logger', 'url' => array('admin')),
);
?>

<h1>Create Logger</h1>

<?php $this->renderPartial('_form', array('model' => $model)); ?>
