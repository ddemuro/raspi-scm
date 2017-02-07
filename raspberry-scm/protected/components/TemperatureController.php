<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class TemperatureController extends CApplicationComponent {

    /**
     * If we're running in debug, we want to log the input.
     * @param type $datapin
     * @param type $tempprog
     */
    public function debug($msg) {
        if (YII_DEBUG === TRUE) {
            Yii::log("Temperature controller: $msg", CLogger::LEVEL_ERROR, "info");
        }
    }

    /**
     * Returns if a configuration was found for an external sensor.
     */
    public function checkExternalSensorConfigured(){
        return Yii::app()->functions->yiiparam('external_sensor_program', NULL) != null;
    }
    
    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $datapin
     * @return type
     */
    public function getHumidityTemp($datapin, $extended) {
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        $res = NULL;
        $maxErrCnt = 10;
        if ($tempprog == NULL) {
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            if($maxErrCnt == 0)
                return NULL;
            sleep(1);
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
            $maxErrCnt--;
        } while (Yii::app()->functions->textInArray($res,"Error"));
        $this->debug("Humidity Temp Return: $res");
        $respli = explode(" ", $res);
        $respli[0] = (float)preg_replace('/\s+/', '', $respli[0]);
        $respli[1] = (float)preg_replace('/\s+/', '', $respli[1]);
        if($respli[0] == 0 || $respli[1] == 0)
            return NULL;
        return $respli;
    }

    /**
     * Get temperature from sensor like DHT11.
     * @param type $datapin
     * @return type
     */
    public function getTemperature($datapin, $extended) {
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        $res = NULL;
        if ($tempprog == NULL) {
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
        } while (Yii::app()->functions->textInArray($res,"Error"));
        $this->debug("Temperature Return: $res");
        str_replace(' ', '', $res);
        $respli = explode("%", $res);
        return floatval($respli[1]);
    }

    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getHumidity($datapin, $extended) {
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        if ($tempprog == NULL) {
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
        } while (Yii::app()->functions->textInArray($res,"Error"));
        $this->debug("Humidity Return: $res");
        str_replace(' ', '', $res);
        $respli = explode("%", $res);
        return floatval($respli[0]);
    }

    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getInternalCPUTemp() {
        $tempprog = Yii::app()->functions->yiiparam('cpu_tmp', NULL);
        $this->debug("Program: $tempprog");
        if ($tempprog == NULL) {
            Yii::log('No temperature sensor configured, cannot sense inernally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("cat $tempprog", false);
        $res = str_replace(' ', '', $res);
        if (strlen($res) == 5) {
            return NULL;
        }
        $res = ($res / 1000);
        $this->debug("Internal Temperature Return: $res");
        return floatval($res);
    }

    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getInternalGPUTemp() {
        $tempprog = Yii::app()->functions->yiiparam('gpu_tmp', NULL);
        $this->debug("Program: $tempprog");
        if ($tempprog == NULL) {
            Yii::log('No temperature sensor configured, cannot sense inernally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$tempprog", false);
        $res = str_replace('temp=', '', $res);
        $res = str_replace("'C", '', $res);
        $this->debug("Internal GPU Temperature Return: $res");
        return $res;
    }

}
