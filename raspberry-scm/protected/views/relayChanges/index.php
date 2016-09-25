<?php
/* @var $this RelayChangesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Relay Changes',
);

$this->menu = array(
    array('label' => 'Create Relay Changes', 'url' => array('create')),
    array('label' => 'Manage Relay Changes', 'url' => array('admin')),
);
?>

<h1>Relay Changes</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
