<?php

/**
 * Various common functions
 */
class Functions extends CApplicationComponent {

    public function init() {
        
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
        // As we send keep alives every minute, in the last 30 seconds he should be online
        $time = date("Y-m-d H:i:s", time() - 10);
        $existingFlags = Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
        if (count($existingFlags) > 0) {
            return false;
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
        // As we send keep alives every minute, in the last 30 seconds he should be online
        $time = date("Y-m-d H:i:s", time() - 10);
        $existingFlags = Flags::model()->findAll('flag_name=:flgname', array(':flgname' => $name));
        if ($existingFlags != NULL && $existingFlags > 0)
            return $existingFlags->delete();
        return false;
    }

}
