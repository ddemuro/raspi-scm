<?php

//Time limit = 0
set_time_limit(0);

/**
 * This Command executable
 * Allows us to run a cron to make sure prices are up to date against
 * providers and other services.
 * 
 * In the event we need recurrent billing when this runs we expend the invoices
 * 
 * In the event a Cart has been open for more than a month, we close it as
 * unbought.
 * 
 * This Cron will connect to all Hosting providers to check we still have free
 * space.
 */
class CronCommand extends CConsoleCommand {

    public $debug = false;

    /**
     * Controller constructor
     */
    public function run() {
        $runs = 0;
        // If we want the script to echo information to STDOUT.
        $this->debug = true;
        while (true) {
            // As we send keep alives every minute, in the last 30 seconds he should be online
            $time = date("Y-m-d H:i:s", time() + 30);
            $this->debug("Ready for another run at: $time");
            // Every 12 hours
            if ($runs == 21600) {
                $this->logCPUTemp(true);
                $this->logExternalTemperature(true);
                $this->logRelayStatus(true);
                $runs = 0;
                // Every 30 sec, only updates if we've had changes
            } else {
                $this->logCPUTemp(false);
                $this->logExternalTemperature(false);
                $this->logRelayStatus(false);
            }
            unset($time);
            //We sleep before next loop.
            $currentMemory = (memory_get_peak_usage(true) / 1024 / 1024);
            $mem_usage = (memory_get_usage(true) / 1024 / 1024);
            usleep(3000000);
            $this->debug("Peak memory usage: " . $currentMemory . " MB\r\n", false);
            $this->debug("Actual memory usage: " . $mem_usage . " MB\r\n", false);
            $runs++;
            gc_collect_cycles();
        }
    }

    // Log the actual status of the relay board
    public function logCPUTemp($force) {
        $res = Yii::app()->TemperatureController->getInternalCPUTemp();
        if ($res == -1) {
            $this->debug("Error checking with relay board..., check log...\n", false);
        }
        $flag = Yii::app()->functions->getFlag("internal_tmp");
        if ($res != NULL && strcmp("internal_tmp", $res) == 0 && $force != false) {
            return;
        }
        Yii::app()->functions->removeFlag("internal_tmp");
        Yii::app()->functions->writeFlag("internal_tmp", $res);
        $tempModel = new InternalTemperature();
        $tempModel->temperature = $res;
        $tempModel->date = date("Y-m-d H:i:s", time());
        $tempModel->save();
        $str = $tempModel->ToString();
        $this->debug("$str \n", false);
        unset($tempModel);
        unset($model);
        unset($res);
    }

    // Add log entry with the external temperature for each sensor
    public function logExternalTemperature($force) {
        $model = Setting::model()->findAll('setting_id=:sett', array(':sett' => 'external_temp_sensor_pin'));
        foreach ($model as $pin) {
            $res = Yii::app()->TemperatureController->getHumidityTemp($pin->setting, $pin->extended);
            $vd = var_dump($res);
            $this->debug("Checking with pin: $pin->setting and extended: $pin->extended. $vd \n", false);
            if ($res === NULL || count($res) <= 1) {
                Yii::log("Error loading temperature information, skipping...");
                Yii::log("Confirm you've added he root password to the config files....");
                continue;
            }
            $flag = Yii::app()->functions->getFlag("ex_tmp_$pin->setting");
            if ($flag != NULL && strcmp("ex_tmp_$pin->setting", $res) == 0 && $force != false) {
                return;
            }
            Yii::app()->functions->removeFlag("ex_tmp_$pin->setting");
            Yii::app()->functions->writeFlag("ex_tmp_$pin->setting", $res);
            $tempModel = new ExternalTemperature();
            $tempModel->temperature = $res[1];
            $tempModel->humidity = $res[0];
            $tempModel->date = date("Y-m-d H:i:s", time());
            $tempModel->log = "DataPIN=$pin->setting";
            $tempModel->save();
            $str = $tempModel->ToString();
            $this->debug("$str \n", false);
            unset($tempModel);
            unset($model);
            unset($res);
        }
    }

    // Log the actual status of the relay board
    public function logRelayStatus($force) {
        $relayInfo = Yii::app()->RelayController->getRelayStatus(NULL, false);
        $relayInfo = var_dump($relayInfo);
        $this->debug("Relay information: $relayInfo");
        unset($relayInfo);
        var_dump(Yii::app()->RelayController->changeRelayStatus(1, 1));
        $relayInfo = Yii::app()->RelayController->getRelayStatus(NULL, false);
        unset($relayInfo);
    }

    /**
     * Prints messages on DEBUG.
     * @param type $msg Message to print.
     * @param type $log [Boolean, if no log, we just echo]
     */
    private function debug($msg, $log = true) {
        if ($this->debug) {
            if ($log) {
                Yii::log($msg, CLogger::LEVEL_ERROR);
            } else {
                echo $msg;
            }
        }
        unset($msg);
    }

}
