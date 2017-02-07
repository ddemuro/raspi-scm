<?php

/**
 * Various common functions
 */
class Functions extends CApplicationComponent {

    public function init() {
        
    }

    /**
     * If you hit this method, and you are not an administrator...
     * You're thrown a 403 error.
     * @throws CHttpException
     */
    public function simpleAccessProvision(){
        if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, Yii::t('error', 'Sorry, You don\'t have the required permissions to enter this section'));
        }
    }
    
    /**
     * Function to compress and encode strings
     * @property @string array to encode
     * @return Encoded string.
     * */
    public function _encode_string_array($stringArray) {
        $s = strtr(base64_encode(addslashes(gzcompress(serialize($stringArray), 9))), '+/=', '-_,');
        return $s;
    }

    /**
     * Function to decompress and encode strings, and decode
     * @property @string array to decode
     * @return Decoded string.
     * */
    public function _decode_string_array($stringArray) {
        $s = unserialize(gzuncompress(stripslashes(base64_decode(strtr($stringArray, '-_,', '+/=')))));
        return $s;
    }

    /**
     * Var Dump cleaning buffer.
     * @param type $var
     * @return String
     */
    public function varDump($var) {
        ob_start();
        var_dump($var);
        $result = ob_get_clean();
        return $result;
    }

    /**
     * Returns parameter if available.
     * @param type $name of parameter
     * @param type $default default parameter value if not found
     * @return type var
     */
    public function yiiparam($name, $default = null) {
        if (isset(Yii::app()->params[$name]))
            return Yii::app()->params[$name];
        else
            return $default;
    }

    /**
     * True if text is in any point in arr
     * @param type $arr
     * @param type $text
     */
    public function textInArray($arr, $text){
        if(is_string($arr))
            return strcmp($arr, $text) == 0;
        return in_array($text, $arr, true);
    }
    
    /**
     * To check if there's a process already running.
     * @param type $processName
     * @return boolean
     */
    function processExists($processName) {
        $pids = Yii::app()->RootElevator->executeRoot("ps -A | grep -i $processName | grep -v grep", NULL);
        if (count($pids) > 0) {
            return true;
        }
        return false;
    }

    /**
     * Writes flag to database
     */
    public function writeFlag($name, $status) {
        $existingFlags = Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
        if (count($existingFlags) > 0) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('flag_name',$name);
            Flags::model()->deleteAll($criteria);
            $newFlag = new Flags();
            $newFlag->flag_name = $name;
            $newFlag->status = $status;
            return $newFlag->save();
        } else {
            $newFlag = new Flags();
            $newFlag->flag_name = $name;
            $newFlag->status = $status;
            return $newFlag->save();
        }
    }

    /**
     * Returns all flags for a name
     * @param type $name
     */
    public function getFlag($name) {
        return Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
    }

    /**
     * Removes flag to database
     */
    public function removeFlag($name) {
        $time = date('Y-m-d H:m:s');
        $existingFlags = Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
        if ($existingFlags != NULL && count($existingFlags) > 0)
            return $existingFlags->delete();
        return false;
    }
    
    /**
     * Manages the weblog
     * @param type $name
     * @return boolean
     */
    public function addToWebLog($logline) {
        $res = false;
        $log = new Logger();
        $log->setIsNewRecord(true);
        $log->log = $logline;
        $res = $log->save();
        unset($date);
        unset($log);
        return $res;
    }

    /**
     * Write to file
     * @param type $file
     * @param type $towrite
     */
    public function writeToFile($file, $towrite){
        $myfile = fopen($file, "w");
        fwrite($myfile, $towrite);
        fclose($myfile);
    }
    
}

