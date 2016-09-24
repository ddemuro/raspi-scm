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
    public function debug($datapin, $tempprog){
        if(YII_DEBUG === TRUE){
            Yii::log("DataPin: $datapin, Program: $tempprog", CLogger::LEVEL_ERROR, "info");
        }
    }
    
    /**
     * Gets Humidity and Temperature as array on DHT sensors.
     * @param type $datapin
     * @return type
     */
    public function getHumidityTemp($datapin){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug($datapin, $tempprog);
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = shell_exec("$tempprog -MJP $datapin");
        } while(strcmp($res, "Error") ==0);
        $respli = explode(" ", $res);
        return$respli;        
    }
    
    /**
     * Get temperature from sensor like DHT11.
     * @param type $datapin
     * @return type
     */
    public function getTemperature($datapin){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug($datapin, $tempprog);
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = shell_exec("$tempprog -MJP $datapin");
        } while(strcmp($res, "Error") ==0);
        $respli = explode(" ", $res);
        return[1];
    }
    
    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getHumidity($datapin){
        $tempprog = Yii::app()->functions->yiiparam('external_sensor_program', NULL);
        $this->debug($datapin, $tempprog);
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense externally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        do {
            $res = shell_exec("$tempprog  -MJP $datapin");
        } while(strcmp($res, "Error") ==0);
        $respli = explode(" ", $res);
        return[0];
    }
    
    /**
     * Get humidity from sensors like DHT11
     * @param type $datapin
     * @return type
     */
    public function getInternalCPUTemp(){
        $tempprog = Yii::app()->functions->yiiparam('cpu_tmp', NULL);
        $this->debug(-1, $tempprog);
        if($tempprog == NULL){
            Yii::log('No temperature sensor configured, cannot sense inernally...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        $res = shell_exec($tempprog);
        $f2 = substr($res, 0, 2);
        $l2 = substr($res, 2, 2);
        return "$f2.$l2";
    }

}
