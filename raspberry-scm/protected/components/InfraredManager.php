<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class InfraredManager extends CApplicationComponent {

    /**
     * Sends command to button directly to IR
     * @param type $utilname
     * @return type
     */
    public function irPower($utilname){
        $temoprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        if($temoprog == NULL){
            Yii::log('No infrared found...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        if($temoprog = Yii::app()->functions->writeFlag('infrared_on', 1))
            shell_exec("$temoprog  SEND_ONCE $utilname KEY_POWER");
        else{
            Yii::log('Infrared already sent that status', CLogger::LEVEL_ERROR, "info");
        }
        
    }

    /**
     * Infrared volme up for a program
     * @param type $utilname
     * @return type
     */
    public function irVolumeUp($utilname){
        $temoprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        if($temoprog == NULL){
            Yii::log('No infrared found...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        shell_exec("$temoprog  SEND_ONCE $utilname KEY_VOLUMEUP");
        Yii::log('Infrared volume went up.', CLogger::LEVEL_INFO, "info");
    }

    
    /**
     * Infrared volme up for a program
     * @param type $utilname
     * @return type
     */
    public function irVolumeDown($utilname){
        $temoprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        if($temoprog == NULL){
            Yii::log('No infrared found...', CLogger::LEVEL_ERROR, "info");
            return NULL;
        }
        shell_exec("$temoprog  SEND_ONCE $utilname KEY_VOLUMEDOWN");
        Yii::log('Infrared volume went up.', CLogger::LEVEL_INFO, "info");
    }
    
    /**
     * Set minimal temperature on AC
     */
    public function setMinTempAC(){
        $mintemp = Yii::app()->functions->yiiparam('min_temp', 16);
        $maxtemp = Yii::app()->functions->yiiparam('max_temp', 31);
        for($i = 0; $i <= $maxtemp; $i++){
            shell_exec("$temoprog  SEND_ONCE $utilname KEY_VOLUMEDOWN");        
            usleep(1000000);
        }
    }
    
    /**
     * Set minimal temperature on AC
     */
    public function setMaxTempAC(){
        $mintemp = Yii::app()->functions->yiiparam('min_temp', 16);
        $maxtemp = Yii::app()->functions->yiiparam('max_temp', 31);
        for($i = 0; $i <= $maxtemp; $i++){
            shell_exec("$temoprog  SEND_ONCE $utilname KEY_VOLUMEUP");        
            usleep(1000000);
        }
    }
    
    
}
