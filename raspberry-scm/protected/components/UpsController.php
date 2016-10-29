<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class TemperatureController extends CApplicationComponent {

    /**
     * Possible variables to get from upsc
     */
    public $upsvars = array(
        'battery.charge',
        'battery.voltage',
        'battery.voltage.high',
        'battery.voltage.low',
        'battery.voltage.nominal',
        'device.type',
        'driver.name',
        'driver.parameter.pollinterval',
        'driver.parameter.port',
        'driver.version',
        'driver.version.internal',
        'input.current.nominal',
        'input.frequency',
        'input.frequency.nominal',
        'input.voltage',
        'input.voltage.fault',
        'input.voltage.nominal',
        'output.voltage',
        'ups.beeper.status',
        'ups.delay.shutdown',
        'ups.delay.start',
        'ups.load',
        'ups.productid',
        'ups.status',
        'ups.temperature',
        'ups.type',
        'ups.vendorid'
    );
    
    /**
     * If we're running in debug, we want to log the input.
     * @param type $datapin
     * @param type $tempprog
     */
    public function debug($msg) {
        if (YII_DEBUG === TRUE) {
            Yii::log("UPS controller: $msg", CLogger::LEVEL_ERROR, "info");
        }
    }

    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $name [upsname]
     * @param type $setting [localhost ... params]
     */
    public function getUPSStatus($name, $setting) {
        $upsprog = Yii::app()->functions->yiiparam('ups_status', NULL);
        $this->debug("Setting: $settings, UPS Name: $name, Program: $upsprog");
        if ($tempprog == NULL) {
            Yii::log('No ups configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$upsprog $name@$setting ups.status 2>&1", false);
        array_splice($res, 0, 1);
        $this->debug("UPS Status Return: $res");
        if(strcmp($res[0], 'Error: Unknown UPS') == 0)
            return -100;
        return strcmp("OL", $res[1]) == 0;
    }
    
    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $name [upsname]
     * @param type $setting [localhost ... params]
     * @param type $status == ups.online, ups.voltage...
     */
    public function getAllStatuses($name, $setting, $status) {
        $upsprog = Yii::app()->functions->yiiparam('ups_status', NULL);
        $this->debug("Setting: $settings, UPS Name: $name, Program: $upsprog");
        if ($tempprog == NULL) {
            Yii::log('No ups configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$upsprog $name@$setting $status 2>&1", false);
        array_splice($res, 0, 1);
        $this->debug("UPS Status Return: $res");
        if(strcmp($res[0], 'Error: Unknown UPS') == 0)
            return -100;
        return $res;
    }

    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $name [upsname]
     * @param type $setting [localhost ... params]
     */    
    public function getAll($name, $setting){
        $upsprog = Yii::app()->functions->yiiparam('ups_status', NULL);
        $this->debug("Setting: $settings, UPS Name: $name, Program: $upsprog");
        if ($tempprog == NULL) {
            Yii::log('No ups configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$upsprog $name@$setting 2>&1", false);
        $this->debug("UPS Status Return: $res");
        return array_splice($res, 0, 1);
    }

}
