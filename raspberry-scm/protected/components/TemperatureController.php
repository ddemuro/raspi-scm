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
    public function debug($msg){
        if(YII_DEBUG === TRUE){
            Yii::log("Temperature controller: $msg", CLogger::LEVEL_ERROR, "info");
        }
    }
    
    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $datapin
     * @return type
     */
    public function getHumidityTemp($datapin, $extended){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
        } while(strcmp($res, "Error ") ==0);
        $this->debug("Humidity Temp Return: $res");
        str_replace(" ", "", $res);
        $respli = explode("%", $res);
        return$respli;        
    }
    
    /**
     * Get temperature from sensor like DHT11.
     * @param type $datapin
     * @return type
     */
    public function getTemperature($datapin, $extended){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
        } while(strcmp($res, "Error ") ==0);
        $this->debug("Temperature Return: $res");
        str_replace(" ", "", $res);
        $respli = explode("%", $res);
        return[1];
    }
    
    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getHumidity($datapin, $extended){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug("DataPin: $datapin, Program: $tempprog");
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = Yii::app()->RootElevator->executeRoot("$tempprog -MJP $datapin $extended 2>&1", false);
        } while(strcmp($res, "Error ") ==0);
        $this->debug("Humidity Return: $res");
        str_replace(" ", "", $res);
        $respli = explode("%", $res);
        return[0];
    }
    
    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getInternalCPUTemp(){
        $tempprog = Yii::app()->functions->yiiparam('cpu_tmp', NULL);
        $this->debug("Program: $tempprog");
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense inernally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$tempprog 2>&1", false);
        $res = shell_exec("$tempprog 2>&1");
        $this->debug("Internal Temperature Return: $res");
        $f2 = substr($res, 0, 2);
        $l2 = substr($res, 2, 2);
        return "$f2.$l2";
    }

    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getInternalGPUTemp(){
        $tempprog = Yii::app()->functions->yiiparam('gpu_tmp', NULL);
        $this->debug("Program: $tempprog");
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense inernally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = Yii::app()->RootElevator->executeRoot("$tempprog 2>&1", false);
        $res = shell_exec("$tempprog 2>&1");
        $this->debug("Internal GPU Temperature Return: $res");
        $f2 = substr($res, 0, 2);
        $l2 = substr($res, 2, 2);
        return "$f2.$l2";
    }

}
