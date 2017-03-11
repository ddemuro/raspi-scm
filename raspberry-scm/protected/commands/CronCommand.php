<?php

//Time limit = 0
set_time_limit(0);

function get_string_between($string, $start, $end) {
    $expl = explode($start, $string);
    $expl1 = explode($end, $expl[1]);
    return $expl1[0];
}

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
    public $from_time = 0;
    private $to_time = 0;
    public $mail_sent = false;
    public $supress_mail = false;
    public $start = 0;
    public $mypid = -1;

    /**
     * Controller constructor
     */
    public function run($args) {
        // If we want the script to echo information to STDOUT.
        $this->debug = true;
        $this->email("Starting test... - Any alert past this e-mail are ACTUAL alerts.", 'ALERT: Raspberry system check has started.');
        $this->start = date("Y-m-d H:i:s", time());
        $this->mypid = getmypid();
        Yii::app()->functions->writeToFile('/tmp/raspi-scm.pid', $this->mypid);
        while (true) {
            // Every 12 hours
            if (round(abs(strtotime(date("Y-m-d H:i:s", time())) - $this->start) / 60, 2) >= 720) {
                $this->start = date("Y-m-d H:i:s", time());
                try {
                    $this->logCPUTemp(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logGPUTemp(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logExternalTemperature(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logRelayStatus(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logUPSStatus(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                // Every 30 sec, only updates if we've had changes
            } else {
                try {
                    $this->logCPUTemp(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logGPUTemp(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logExternalTemperature(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logRelayStatus(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
                try {
                    $this->logUPSStatus(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                    continue;
                }
            }
            //We sleep before next loop.
            $currentMemory = (memory_get_peak_usage(true) / 1024 / 1024);
            $mem_usage = (memory_get_usage(true) / 1024 / 1024);
            $this->debug("Sleeping before a new loop.", false);
            sleep(Yii::app()->params['run_every'] * 60);
            $this->debug("Peak memory usage: " . $currentMemory . " MB\r\n", false);
            $this->debug("Actual memory usage: " . $mem_usage . " MB\r\n", false);
            gc_collect_cycles();
        }
    }

    /**
     * Log the actual status of the relay board
     * @param type $force
     * @return type
     */
    public function logCPUTemp($force) {
        $res = (float) Yii::app()->TemperatureController->getInternalCPUTemp();
        if ($res == -1) {
            $this->debug("Error checking with raspberry pi..., check log...\n", false);
        }
        $flag = Yii::app()->functions->getFlag("internal_tmp");
        if ($res != NULL && strcmp("internal_tmp", $res) == 0 && !$force) {
            return;
        }
        Yii::app()->functions->removeFlag("internal_tmp");
        Yii::app()->functions->writeFlag("internal_tmp", $res);
        $tempModel = new InternalTemperature();
        $tempModel->temperature = floatval($res);
        $tempModel->type = 'CPU';
        $tempModel->setIsNewRecord(true);
        if(!$tempModel->save())
            $this->debug("Error saving CPU temperature. $tempModel->temperature Error: ".var_export($tempModel->getErrors(), true), false);
        $str = $tempModel->ToString();
        $this->debug("$str \r\n", false);
        unset($tempModel);
        unset($model);
        unset($res);
    }

    /**
     * Log the actual status of the relay board
     * @param type $force
     * @return type
     */
    public function logGPUTemp($force) {
        $res = (float) Yii::app()->TemperatureController->getInternalGPUTemp();
        if ($res == -1) {
            $this->debug("Error checking with raspberry pi..., check log...\n", false);
        }
        $flag = Yii::app()->functions->getFlag("internal_gtmp");
        if ($res != NULL && strcmp("internal_gtmp", $res) == 0 && !$force) {
            return;
        }
        Yii::app()->functions->removeFlag("internal_gtmp");
        Yii::app()->functions->writeFlag("internal_gtmp", $res);
        $tempModel = new InternalTemperature();
        $tempModel->temperature = floatval($res);
        $tempModel->type = 'GPU';
        $tempModel->setIsNewRecord(true);
        if(!$tempModel->save())
            $this->debug("Error saving GPU temperature. $tempModel->temperature Error: ".var_export($tempModel->getErrors(), true), false);
        $str = $tempModel->ToString();
        $this->debug("$str \r\n", false);
        unset($tempModel);
        unset($model);
        unset($res);
    }

    /**
     * Log the actual status of the relay board
     * @param type $force
     * @return type
     */
    public function logUPSStatus($force) {
        // If no UPS configured
        if (!Yii::app()->UpsManager->checkUPSConfigured()) {
            $this->debug("UPS not configured..." + PHP_EOL, false);
            return null;
        }
        $this->debug("Running UPS check..." + PHP_EOL, false);
        $s = Setting::model()->findByAttributes(array('setting_id' => 'ups'));
        if (count($s) == 1) {
            $uinfo = Yii::app()->UpsManager->getAll($s->setting, $s->extended);
            $this->debug("Checking UPS $s->setting, $s->extended $uinfo..." + PHP_EOL, false);
            if ($uinfo == -100) {
                $this->debug("UPS is not found...\r\n", false);
                return;
            }
            if ($uinfo == NULL) {
                $this->debug("UPS is not configured...\r\n", false);
                return;
            }
            $flag = Yii::app()->functions->getFlag("$s->setting-$s->extended");
            if ($flag == null || !Yii::app()->functions->textInArray($uinfo, $flag->status) || $force) {
                Yii::app()->functions->writeFlag("$s->setting-$s->extended", $uinfo);
                $this->debug("Saving details...", false);
                $u = new Ups();
                $u->setting = "$s->setting-$s->extended";
                $u->ups_details = $uinfo;
                $u->setIsNewRecord(true);
                if ($u->save()) {
                    $this->debug("New UPS status saved.");
                    $this->email("$s->setting & $s->extended status changed: $uinfo", "UPS Changed status: $s->setting @ $s->extended");
                    $this->debug("Adding ups info. Status changed");
                } else {
                    $this->debug("Error saving UPS Status. ".var_export($u->getErrors(), true));
                }
            }
        } else {
            foreach ($s as $ups) {
                $uinfo = Yii::app()->UpsManager->getAll($ups->setting, $ups->extended);
                $this->debug("Checking UPS $ups->setting, $ups->extended $uinfo...\r\n", false);
                if ($uinfo == -100) {
                    $this->debug("UPS is not found...\r\n", false);
                    continue;
                }
                if ($uinfo == NULL) {
                    $this->debug("UPS is not configured...\r\n", false);
                    continue;
                }
                $flag = Yii::app()->functions->getFlag("$ups->setting-$ups->extended");
                if ($flag == null || !Yii::app()->functions->textInArray($uinfo, $flag->status) || $force) {
                    Yii::app()->functions->writeFlag("$ups->setting-$ups->extended", $uinfo);
                    $u = new Ups();
                    $u->setting = "$ups->setting & $ups->extended";
                    $u->ups_details = $uinfo;
                    $u->setIsNewRecord(true);
                    if ($u->save()) {
                        $this->debug("New UPS status saved.");
                        $this->email("$s->setting & $s->extended status changed: $uinfo", "UPS Changed status: $s->setting @ $s->extended");
                    } else {
                        $this->debug("Error saving UPS Status. ".var_export($u->getErrors(), true));
                    }
                    $this->email("$ups->setting & $ups->extended status changed: $uinfo", "UPS Changed status: $ups->setting@$ups->extended");
                    $this->debug("Adding ups info. Status changed");
                }
            }
        }
        $this->debug("Finished checking UPS status.\n", false);
        unset($s);
    }

    /**
     * Add log entry with the external temperature for each sensor
     * @param type $force
     */
    public function logExternalTemperature($force) {
        if (!Yii::app()->TemperatureController->checkExternalSensorConfigured())
            return null;
        $model = Setting::model()->findAll('setting_id=:sett', array(':sett' => 'external_temp_sensor_pin'));
        foreach ($model as $pin) {
            $res = Yii::app()->TemperatureController->getHumidityTemp($pin->setting, $pin->extended);
            $this->debug("Checking with pin: $pin->setting and extended: $pin->extended. \r\n", false);
            if ($res === NULL || Yii::app()->functions->textInArray($res, 'Error')) {
                $this->debug("Error loading temperature information, skipping... \n Confirm you've added he root password to the config files....");
                continue;
            }
            $flag = Yii::app()->functions->getFlag("ex_tmp-$pin->setting");
            if ($flag != NULL && Yii::app()->functions->textInArray($flag->status, $res) && !$force) {
                $this->debug("Same information for external temperature, skipping...");
                continue;
            }
            Yii::app()->functions->removeFlag("ex_tmp_$pin->setting");
            Yii::app()->functions->writeFlag("ex_tmp_$pin->setting", "$res[1].$res[0]");
            $tempModel = new ExternalTemperature();
            $tempModel->temperature = $res[1];
            $tempModel->humidity = $res[0];
            $tempModel->setIsNewRecord(true);
            // Decide if alert is required
            $this->temperatureAlert($tempModel->temperature, $tempModel->humidity);
            $tempModel->log = "DataPIN=$pin->setting";
            if(!$tempModel->save())
                $this->debug("Error saving external temperature. \r\n".var_export($tempModel->getErrors(), true), false);
            unset($tempModel);
            unset($model);
            unset($str);
            unset($res);
        }
    }

    /**
     * @param temperature to calculate alert.
     * @param humidity to calculate alert.
     */
    public function temperatureAlert($temp, $humidity) {
        $max_temp = Yii::app()->functions->yiiparam('max_temp', NULL);
        $min_temp = Yii::app()->functions->yiiparam('min_temp', NULL);
        $max_warn_temp = Yii::app()->functions->yiiparam('max_warn_temp', NULL);
        $min_warn_temp = Yii::app()->functions->yiiparam('min_warn_temp', NULL);
        $min_humidty = Yii::app()->functions->yiiparam('min_humidity', NULL);
        $warn_humidity = Yii::app()->functions->yiiparam('warn_humidity', NULL);
        $max_humidity = Yii::app()->functions->yiiparam('max_humidity', NULL);
        $acon = false;
        // Temperature exceeded the max temperature
        $this->debug("Max warn temp: $max_warn_temp, Min warn temp: $min_warn_temp, Max Temp: $max_temp, Min Temp: $min_temp, Max Humidity: $max_humidity, Warn Humidity: $warn_humidity, $");
        if ($temp > $max_temp) {
            $this->email("Maximum temperature exceeded: Current: $temp, Maximum: $max_temp", 'ALERT: Maximum temperature was exceeded.', true);
            $this->debug("Maximum temperature exceeded: Current: $temp, Maximum: $max_temp", 'ALERT: Maximum temperature was exceeded.');
            $this->useIRControlAC($max_warn_temp - 5, true);
            $acon = true;
            if ($humidity > $max_humidity) {
                $this->useIRControlAC($max_warn_temp - 5, true);
                $acon = true;
                $this->email("Maximum humidity exceeded: Current: $humidity, Maximum: $max_humidity", 'ALERT: Maximum humidity was exceeded.', true);
                $this->debug("Maximum humidity exceeded: Current: $humidity, Maximum: $max_humidity", 'ALERT: Maximum humidity was exceeded.');
            }
        }
        // Temperature below minimum
        if ($temp < $min_temp) {
            $this->useIRControlAC($max_warn_temp - 5, false);
            $this->email("Minimum temperature exceeded: Current: $temp, Minimum: $max_temp", 'ALERT: Minimum temperature was exceeded.', true);
            $this->debug("Minimum temperature exceeded: Current: $temp, Minimum: $max_temp", 'ALERT: Minimum temperature was exceeded.');
            if ($humidity < $min_humidity) {
                $this->useIRControlAC($max_warn_temp - 5, false);
                $this->email("Minimum humidity exceeded: Current: $humidity, Minimum: $max_humidity", 'ALERT: Minimum humidity was exceeded.', true);
                $this->debug("Minimum humidity exceeded: Current: $humidity, Minimum: $max_humidity", 'ALERT: Minimum humidity was exceeded.');
                return;
            }
            return;
        }
        // Temperature below warn
        if ($temp < $min_warn_temp) {
            $this->email("Minimum warning temperature exceeded: Current: $temp, Minimum: $max_temp", 'WARNING: Minimum temperature was exceeded.');
            $this->debug("Minimum warning temperature exceeded: Current: $temp, Minimum: $max_temp", 'WARNING: Minimum temperature was exceeded.');
            $this->useIRControlAC($max_warn_temp - 5, false);
        }
        // Temperature exceeded the max warning temperature
        if ($temp > $max_warn_temp) {
            $this->useIRControlAC($max_warn_temp - 5, true);
            $acon = true;
            $this->email("Maximum warning temperature exceeded: Current: $temp, Maximum: $max_temp", 'WARNING: Maximum temperature was exceeded.');
            $this->debug("Maximum warning temperature exceeded: Current: $temp, Maximum: $max_temp", 'WARNING: Maximum temperature was exceeded.');
        }
        if ($warn_humidity > $humidity) {
            $this->useIRControlAC($max_warn_temp - 5, true);
            $acon = true;
            $this->email("Warning, humidity over warning level. Current: $humidity", "Current: $humidity, Max warn level: $warn_humidity.");
            $this->debug("Warning, humidity over warning level. Current: $humidity", "Current: $humidity, Max warn level: $warn_humidity.");
        }
        if (!$acon)
            $this->useIRControlAC(null, false);
        unset($max_temp);
        unset($min_temp);
        unset($max_warn_temp);
        unset($min_warn_temp);
        unset($min_humidty);
        unset($warn_humidity);
        unset($max_humidity);
    }

    /**
     * If needed and we're able to control an AC Unit, we use this method to
     * call the remote utils.
     * @param $temp = temperature after turning on...
     * @param $on (If temperature is set, and on is set, it'll be turned on, and temp set after)
     * if $temp == null and on = false, turns it off.
     */
    public function useIRControlAC($temp, $on) {
        $irman = new InfraredManager();
        // If not configured, cannot be used.
        if ($irman->checkIRConfigured()) {
            return null;
        }

        $model = Setting::model()->findByAttributes(array('setting_id' => 'ir_util_name', 'extended' => 'AirConditioner'));
        $flag = Yii::app()->functions->getFlag("ir:" + $model->setting);      
        $curr_status = Yii::app()->functions->checkFileExists("/opt/scripts/ac_on");
        $curr_temp = (int)Yii::app()->functions->readFromFile("/opt/scripts/ac_tmp");
        $ontxt = false;
        if($flag != null){
            $ontxt = Yii::app()->functions->textInArray($flag->status, "on");
        }
        $event = "";
        
        // Turns on the AC if it's not on.
        if ($on && !$curr_status || !$ontxt) {
            $irman->irPower($model->setting);
            Yii::app()->functions->writeFlag("ir:" + $model->setting, "on");
            Yii::app()->functions->writeToFile("/opt/scripts/ac_on", "");
            $event += "IR: $model->setting turning on;";
        }

        // Turns off the AC if it's on.
        if (!$on && $curr_status || $ontxt) {
            $irman->irPower($model->setting);
            Yii::app()->functions->writeFlag("ir:" + $model->setting, "off");
            unlink("/opt/scripts/ac_on");
            $event += "IR: $model->setting turning off;";
        }

        // Set temperature if chosen to
        if ($on && $curr_temp != null && $temp >= intval(Yii::app()->functions->yiiparam('min_ac_temp', null))) {
            $irman->setTemperature($model->setting, $temp);
            $event += "setting temperature: $temp";
        }
        
        $this->email("IR Change: $event", "IR Event");
        // Set the event
        $ir = new InfraredEvents();
        $ir->device = $model->setting;
        $ir->setIsNewRecord(true);
        $ir->event = $event;
        $ir->extended = "Autosetting AC by cron control.";
        if ($ir->save()) {
            $this->debug("IR Event saved, $event");
        } else {
            $this->debug("Error saving event... logged.".var_export($ir->getErrors(), true));
        }
        Yii::app()->functions->addToWebLog($event);
        unset($irman);
        unset($model);
        unset($flag);
        unset($event);
    }

    /**
     * Sends email alerting of change
     * @param alert Sends message.
     * @param subject Subject to be sent on email.
     * @param force (If we ignore the supress time)
     */
    public function email($alert, $subject, $force = false) {
        if (!$this->supress_mail) {
            // Time since supress
            $this->to_time = strtotime(date("Y-m-d H:i:s", time() + intval(Yii::app()->params['mail_antispam'])));
        }
        if ($this->supress_mail && round(abs(strtotime(date("Y-m-d H:i:s", time())) - $this->from_time) / 60, 2) <= 0) {
            $this->supress_mail = false;
        }
        if (!$this->supress_mail || $force) {
            $mail = new YiiMailer();
            //$mail->clearLayout();//if layout is already set in config
            $mail->setFrom('alerts@derekdemuro.com', 'Raspberry Alert System.');
            $mail->setTo(Yii::app()->params['alertEmail']);
            $mail->setCc(Yii::app()->params['adminEmail']);
            $mail->setSubject($subject);
            $mail->setBody($alert);
            $mail->send();
            $this->supress_mail = true;
        }
        unset($mail);
    }

    /**
     * Log the actual status of the relay board
     * @param type $force
     * @return type
     */
    public function logRelayStatus($force) {
        $crelay = Yii::app()->functions->yiiparam('crelay', NULL);
        if ($crelay === NULL || Yii::app()->RelayController->checkCRelay() != true) {
            $this->debug("Error checking with CRelay..., check log...\n", false);
            return NULL;
        }
        $res = Yii::app()->RelayController->getRelayStatus(NULL, true);
        $flag = Yii::app()->functions->getFlag("relay_status");
        if ($flag != NULL && Yii::app()->functions->textInArray($flag->status, $res) == 0 && !$force) {
            return;
        }
        Yii::app()->functions->removeFlag('relay_status');
        Yii::app()->functions->writeFlag('relay_status', $res);
        $relay = new RelayChanges();
        $relay->relay_number = -1;
        $relay->action = $res;
        $relay->setIsNewRecord(true);
        $relay->log = "Logging status of relays for informational purposes only.";
        $this->debug("Relay info: $res", false);
        if ($relay->save()) {
            $this->debug("New relay status saved.", true);
        } else {
            $this->debug("Error saving new relay status. ".var_export($relay->getErrors(), true), true);
        }
        unset($res);
        unset($flag);
        unset($relay);
    }

    /**
     * Prints messages on DEBUG.
     * @param type $msg Message to print.
     * @param type $log [Boolean, if no log, we just echo]
     */
    private function debug($msg, $log = true) {
        if ($this->debug) {
            if ($log) {
                sleep(1);
                Yii::app()->functions->addToWebLog($msg);
            } else {
                echo $msg;
            }
        }
        unset($msg);
    }

}
