
<?php

//Time limit = 0
set_time_limit(0);

/**
 * User controller Home page
 */
class ServiceCommand extends CConsoleCommand {

    public $debugFlag = true;

    /**
     * Controller constructor
     */
    public function run() {
        // As we send keep alives every minute, in the last 30 seconds he should be online
        $time = date("Y-m-d H:i:s", time() - 10);
        
        unset($time);
        unset($criteriaMembers);
        unset($members);
        //We sleep before next loop.
        $currentMemory = (memory_get_peak_usage(true) / 1024 / 1024);
        $mem_usage = (memory_get_usage(true) / 1024 / 1024);

        $this->debug("Peak memory usage: " . $currentMemory . " MB\r\n", false);
        $this->debug("Actual memory usage: " . $mem_usage . " MB\r\n", false);
    }

    
    /**
     * Upgrades the application
     */
    private function upgradeApp(){
        
        $res = Yii::app()->RootElevator->executeRoot("$temoprog  SEND_ONCE $utilname $command", false);
    }

    /**
     * Prints messages on DEBUG.
     * @param type $msg Message to print.
     * @param type $log [Boolean, if no log, we just echo]
     */
    private function debug($msg, $log = true) {
        if ($this->debugFlag) {
            if ($log) {
                Yii::log($msg, CLogger::LEVEL_ERROR);
            } else {
                echo $msg;
            }
        }
        unset($msg);
    }

}
