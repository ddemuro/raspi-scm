<?php
/* @var $this UpsController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Ups',
);

$this->menu = array(
    array('label' => 'Create Ups', 'url' => array('create')),
    array('label' => 'Manage Ups', 'url' => array('admin')),
    array('label' => 'View All UPS Info', 'url' => array('ViewAll')),
);
?>

<h1>Ups</h1>

<div id="all">
    <div class="main">
        <?php
        $this->widget('zii.widgets.CListView', array(
            'dataProvider' => $dataProvider,
            'itemView' => '_view',
        ));
        ?>
    </div>
    <div class="main">
        <h1>Last 7 days main information:</h1>
        <div style='float: right;'>
            <h5 style='color: rgb(99, 0, 0); float:right;'>Load</h5>
            <br>
            <h5 style='color: rgb(67, 196, 53); float:right;'>Battery Charge</h5>
            <br>
            <h5 style='color: rgb(240, 29, 29); float:right;'>Temperature</h5>
        </div>
        <?php
        $this->widget(
                'chartjs.widgets.ChLine', array(
            'width' => 800,
            'height' => 500,
            'htmlOptions' => array(),
            'labels' => $times,
            'datasets' => array(
                array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(255, 0, 0, 0.3)",
                    "pointStrokeColor" => "#F01D1D",
                    "data" => $temp
                ), array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(255, 0, 0, 0.3)",
                    "pointStrokeColor" => "#43C435",
                    "data" => $batt_charge
                ), array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(255, 0, 0, 0.3)",
                    "pointStrokeColor" => "#630000",
                    "data" => $load
                )
            ),
            'options' => array()
                )
        );
        ?>
        <h1>Last 7 days voltages:</h1>
        <div style='float: right;'>
            <h5 style='color: rgb(128, 160, 100); float:right;'>Input Voltage</h5>
            <br>
            <h5 style='color: rgb(189, 136, 21); float:right;'>Battery Voltage</h5>
        </div>
        <?php
        $this->widget(
                'chartjs.widgets.ChLine', array(
            'width' => 800,
            'height' => 500,
            'htmlOptions' => array(),
            'labels' => $times,
            'datasets' => array(
                array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(255, 0, 0, 0.3)",
                    "pointStrokeColor" => "#BD8815",
                    "data" => $batt_voltage
                ), array(
                    "fillColor" => "rgba(220,220,220,0.5)",
                    "strokeColor" => "rgba(220,220,220,1)",
                    "pointColor" => "rgba(0, 0, 255, 0.3)",
                    "pointStrokeColor" => "#00ACC7",
                    "data" => $input_voltage
                )
            ),
            'options' => array()
                )
        );
        ?>
    </div>
</div>
