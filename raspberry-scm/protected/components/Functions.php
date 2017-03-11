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
    public function simpleAccessProvision() {
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
    public function textInArray($arr, $text) {
        if (is_string($arr))
            return strpos($arr, $text) !== false;
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
        //$existingFlags = Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
        $record = Flags::model()->find(array(
            'select' => 'flag_name',
            'condition' => 'flag_name=:flgname',
            'params' => array(':flgname' => $name))
        );

        if ($record != null) {
            $record->delete();
            $newFlag = new Flags();
            $newFlag->flag_name = $name;
            $newFlag->setIsNewRecord(true);
            $newFlag->status = $status;
            return $newFlag->save();
        } else {
            $newFlag = new Flags();
            $newFlag->setIsNewRecord(true);
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
        return Flags::model()->find('flag_name=:flgname', array(':flgname' => $name));
    }

    /**
     * Removes flag to database
     */
    public function removeFlag($name) {
        $existingFlags = Flags::model()->find('flag_name=:flgname', array(':flgname' => $name));
        if ($existingFlags != NULL && count($existingFlags) > 0) {
            $existingFlags->delete();
            return true;
        }
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
        $log->log = $logline;
        $log->setIsNewRecord(true);
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
    public function writeToFile($file, $towrite) {
        try {
            $myfile = fopen($file, "w");
            fwrite($myfile, $towrite);
        } catch (Exception $ex) {
            $this->addToWebLog("Error writing to $file, " . var_dump($towrite));
        } finally {
            fclose($myfile);
        }
    }

    /**
     * Reads file
     * @param type $file
     */
    public function readFromFile($file) {
        try {
            $myfile = fopen($file, "r");
            $res = fread($myfile, filesize($file));
        } catch (Exception $e) {
            return null;
        } finally {
            fclose($myfile);
        }
        return $res;
    }

    /**
     * Reads file
     * @param type $file
     */
    public function checkFileExists($file) {
        try {
            return file_exists($file);
        } catch (Exception $e) {
            return false;
        }
    }

}
