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
    public function irPower($utilname) {
        if(!$this->checkIRConfigured())
            return null;
        $irprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        if ($irprog = Yii::app()->functions->writeFlag('infrared_on', 1))
            return Yii::app()->RootElevator->executeRoot("$irprog  SEND_ONCE $utilname KEY_POWER", null, true);
        else {
            Yii::log('Infrared already sent that status', CLogger::LEVEL_ERROR, "info");
        }
    }

    /**
     * Infrared volme up for a program
     * @param type $utilname
     * @return type
     */
    public function irVolumeUp($utilname) {
        if(!$this->checkIRConfigured())
            return null;
        $irprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        return Yii::app()->RootElevator->executeRoot("$irprog  SEND_ONCE $utilname KEY_VOLUMEUP", null, true);
        Yii::log('Infrared volume went up.', CLogger::LEVEL_INFO, "info");
    }

    /**
     * Infrared volme up for a program
     * @param type $utilname
     * @return type
     */
    public function irVolumeDown($utilname) {
        if(!$this->checkIRConfigured())
            return null;
        $irprog = Yii::app()->functions->yiiparam('infrared_prog', NULL);
        return Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname KEY_VOLUMEDOWN", null, true);
        Yii::log('Infrared volume went up.', CLogger::LEVEL_INFO, "info");
    }

    /**
     * Set minimal temperature on AC
     */
    public function setMinTempAC($utilname) {
        if(!$this->checkIRConfigured())
            return null;
        $mintemp = Yii::app()->functions->yiiparam('min_ac_temp', 16);
        $maxtemp = Yii::app()->functions->yiiparam('max_ac_temp', 31);
        $status = 0;
        for ($i = 0; $i <= $maxtemp; $i++) {
            $status = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname KEY_VOLUMEDOWN", null, true) == 0;
            sleep(1);
        }
        return $status;
    }

    /**
     * Set minimal temperature on AC
     */
    public function setMaxTempAC($utilname) {
        if(!$this->checkIRConfigured())
            return null;
        $mintemp = Yii::app()->functions->yiiparam('min_temp', 16);
        $maxtemp = Yii::app()->functions->yiiparam('max_temp', 31);
        $status = 0;
        for ($i = 0; $i <= $maxtemp; $i++) {
            $status = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname KEY_VOLUMEUP", null, true) == 0;
            sleep(1);
        }
        return $status;
    }

    
    /**
     * Set minimal temperature on AC
     */
    public function setTemperature($utilname, $temp) {
        if(!$this->checkIRConfigured())
            return null;
        $mintemp = Yii::app()->functions->yiiparam('min_ac_temp', 16);
        $maxtemp = Yii::app()->functions->yiiparam('max_ac_temp', 31);
        $tempset -= $mintemp;
        $status = 0;
        for ($i = 0; $i <= $maxtemp; $i++) {
            $status = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname KEY_VOLUMEDOWN", null, true) == 0;
            sleep(1);
        }
        
        for ($i = 0; $i <= $tempset; $i++) {
            $status = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname KEY_VOLUMEUP", null, true) == 0;
            sleep(1);
        }
        return $status;
    }

    
    /**
     * Returns true if IR is configured for use, false otherwise.
     * @return boolean
     */
    public function checkIRConfigured(){
        return Yii::app()->functions->yiiparam('infrared_prog', null) == null;
    }
}
