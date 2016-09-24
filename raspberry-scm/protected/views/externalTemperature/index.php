<?php
/* @var $this ExternalTemperatureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'External Temperatures',
);

$this->menu = array(
    array('label' => 'Create External Temperature', 'url' => array('create')),
    array('label' => 'Manage External Temperature', 'url' => array('admin')),
    array('label' => 'Show External Temperature', 'url' => array('show')),
);
?>

<h1>External Temperatures</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
