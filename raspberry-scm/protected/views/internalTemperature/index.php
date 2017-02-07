<?php
/* @var $this InternalTemperatureController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Internal Temperatures',
);

$this->menu = array(
    array('label' => 'Create InternalTemperature', 'url' => array('create')),
    array('label' => 'Manage InternalTemperature', 'url' => array('admin')),
    array('label' => 'Show CPU Temperature', 'url' => array('viewstaticcpu')),
    array('label' => 'Show GPU Temperature', 'url' => array('viewstaticgpu')),
);
?>

<h1>Internal Temperatures</h1>


<div id="all">
    <div class="main">
    <?php
    $this->widget('zii.widgets.CListView', array(
        'dataProvider' => $dataProvider,
        'itemView' => '_view',
    ));?>
    </div>
    <div class="main">
    <h1>Last week's temperatures and sensor</h1>
    <div style='float: right;'>
        <h5 style='color: rgb(173, 10, 10); float:right;'>CPU</h5>
        <br>
        <h5 style='color: rgb(27, 102, 242); float:right;'>GPU</h5>
    </div>
    <?php 
    $this->widget(
        'chartjs.widgets.ChLine', 
        array(
            'width' => 800,
            'height' => 500,
            'htmlOptions' => array(),
            'labels' => $times,
            'datasets' => array(
                array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(255, 0, 0, 0.3)",
                    "pointStrokeColor" => "#AD0A0A",
                    "data" => $tempsCPU
                ),
                array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(0, 0, 255, 0.3)",
                    "pointStrokeColor" => "#1B66F2",
                    "data" => $tempsGPU
                )      
            ),
            'options' => array()
        )
    );
    ?>
    </div>
</div>
