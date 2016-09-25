<?php
/* @var $this RelayChangesController */
/* @var $model RelayChanges */

$this->breadcrumbs = array(
    'Relay Changes' => array('index'),
    $model->date,
);

$this->menu = array(
    array('label' => 'List Relay Changes', 'url' => array('index')),
    array('label' => 'Create Relay Changes', 'url' => array('create')),
    array('label' => 'Update Relay Changes', 'url' => array('update', 'id' => $model->date)),
    array('label' => 'Delete Relay Changes', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->date), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Relay Changes', 'url' => array('admin')),
);
?>

<h1>View Relay Changes #<?php echo $model->date; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'date',
        'relay_number',
        'action',
        'log',
    ),
));
?>
