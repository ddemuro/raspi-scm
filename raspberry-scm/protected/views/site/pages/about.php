<?php
/* @var $this SiteController */

$this->pageTitle = Yii::app()->name . ' - About';
$this->breadcrumbs = array(
    'About',
);
?>
<h1>About</h1>

<p>This system was created to easily and remotely manage with a Raspberry Pi a remote system.</p>
<p>Provides an interface for:</p>
<ul>
    <li>UPS Information Recording and Alerting.</li>
    <li>Internal Temperature Recording and Alerting.</li>
    <li>External Temperature by using sensors DHT11/22 Recording and Alerting.</li>
    <li>Air conditioning systems by using InfraRed (lirc).</li>
    <li>Relay board controls compatible with Crelay.</li>
    <li>User management.</li>
    <li>Features coming soon.</li>
</ul>
