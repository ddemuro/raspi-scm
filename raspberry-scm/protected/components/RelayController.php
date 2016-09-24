<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class RelayController extends CApplicationComponent {
    
    /**
     * Check if Crelay is running, start it otherwise.
     * @return boolean
     */
    public function checkCRelay(){
        $getexec = Yii::app()->functions->yiiparam('crelay', NULL);
        $pid = Yii::app()->functions->processExists('crelay');
        if($pid == false){
            Yii::log('CRelay was not running, starting...', CLogger::LEVEL_WARNING, "info");
            shell_exec("$getexec -d &disown");
        }
        $pid = Yii::app()->functions->processExists('crelay');
        if($pid){
            return true;
        }
        Yii::log('Unable to start crelay error raised...', CLogger::LEVEL_ERROR, "info");
        return false;
    }
    
    /**
     * Returns an ordered array with:
     * RelayNumber:1|0 for status.
     * Select only one to reply
     * TRUE | FALSE if relay number is provided
     * ARRAY if none.
     */
    public function getRelayStatus($relnumber, $toString){
        // Get cURL resource
        $curl = curl_init();
        // Set some options - we are passing in a useragent too here
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://localhost:8000/gpio',
            CURLOPT_USERAGENT => 'Raspberry Pi SCM'
        ));
        // Send the request & save response to $resp
        $resp = curl_exec($curl);
        // Validate card was detected
        if (strcmp("ERROR: No compatible device detected !", $resp) == 0){
            Yii::log('Error, no Relay card could be detected, please check USB connection...', CLogger::LEVEL_ERROR, "warn");     
            return -1;
        }
        // Close request to clear up some resources
        curl_close($curl);
        $resp = explode("\n", $resp);
        if($relnumber != NULL && $relnumber > -1){
            $pieces = explode(" ", $resp[$relnumber]);
            $state = explode(":", $pieces[1]);
            $relay_number = intval($state[0]);
            if(intval($state[0]) == 1)
                return true;
            else
                return false;
        }
        if($toString == 1)
            return $resp;
        $relay_info = array();
        foreach($resp as $line){
            $pieces = explode(" ", $line);
            $state = explode(":", $pieces[1]);
            $relay_number = intval($state[0]);
            $relay_state = intval($state[1]);
            array_push($relay_info, array($relay_number => $relay_state));
        }
        return $relay_info;
    }
    
    /**
     * Changes the status of a relay
     * @param type $relay_number
     * @param type $status (0 OFF | 1 ON | 2 PULSE)
     * @return type
     */
    public function changeRelayStatus($relay_number, $status){
        $crelay = Yii::app()->functions->yiiparam('crelay',NULL);
        if($crelay === NULL){
            Yii::log('CRelay not installed or configured in the main.php file.', CLogger::LEVEL_WARNING, "info");
            return NULL;
        }
        // Get status
        $req_status = $this->getRelayStatus($relay_number);
        if($req_status == -1){
            Yii::log('Trying to set the state to the same state of relay.', CLogger::LEVEL_INFO, "info");
            return -1;
        }
        if($req_status && $status == 1){
            Yii::log('Trying to set the state to the same state of relay.', CLogger::LEVEL_INFO, "info");
        }else{
        // Get cURL resource
            $curl = curl_init();
            // Set some options - we are passing in a useragent too here
            curl_setopt_array($curl, array(
                CURLOPT_RETURNTRANSFER => 1,
                CURLOPT_URL => 'http://localhost:8000/gpio',
                CURLOPT_USERAGENT => 'Raspberry Pi SCM',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => array(
                    pin => $relay_number,
                    status => $status
                )
            ));
            // Send the request & save response to $resp
            $resp = curl_exec($curl);
            // Close request to clear up some resources
            curl_close($curl);
        }
    }

}
