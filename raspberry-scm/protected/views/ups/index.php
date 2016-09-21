<?php
/* @var $this UpsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Ups',
);

$this->menu = array(
    array('label' => 'Create Ups', 'url' => array('create')),
    array('label' => 'Manage Ups', 'url' => array('admin')),
);
?>

<h1>Ups</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
