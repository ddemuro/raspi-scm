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
    public $from_time = 0;
    private $to_time = 0;
    public $mail_sent = false;
    public $supress_mail = false;
    public $start = 0;
    /**
     * Controller constructor
     */
    public function run($args) {
        // If we want the script to echo information to STDOUT.
        $this->debug = true;
        $this->email("Starting test... - Any alert past this e-mail are ACTUAL alerts.", 'ALERT: Raspberry system check has started.');
        $this->start = date("Y-m-d H:i:s", time());
        while (true) {
            // Every 12 hours
            if (round(abs(strtotime(date("Y-m-d H:i:s", time())) - $this->start) / 60,2) >= 720) {
                $this->start = date("Y-m-d H:i:s", time());
                try{
                    $this->logCPUTemp(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logExternalTemperature(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logRelayStatus(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logUPSStatus(true);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                // Every 30 sec, only updates if we've had changes
            } else {
                try{
                    $this->logCPUTemp(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logExternalTemperature(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logRelayStatus(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
                
                try{
                    $this->logUPSStatus(false);
                } catch (Exception $ex) {
                    $this->debug("Error: " + var_dump($ex));
                }
            }
            //We sleep before next loop.
            $currentMemory = (memory_get_peak_usage(true) / 1024 / 1024);
            $mem_usage = (memory_get_usage(true) / 1024 / 1024);
            sleep(Yii::app()->params['run_every']*60);
            $this->debug("Peak memory usage: " . $currentMemory . " MB\r\n", false);
            $this->debug("Actual memory usage: " . $mem_usage . " MB\r\n", false);
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
        $tempModel->temperature = floatval($res);
        $tempModel->date = date('Y-m-d H:m:s');
        $tempModel->date = date('CPU');
        $tempModel->save();
        $str = $tempModel->ToString();
        $this->debug("$str \r\n", false);
        unset($tempModel);
        unset($model);
        unset($res);
    }

    // Log the actual status of the relay board
    public function logUPSStatus($force) {
        $ups = Ups::model()->findAll();
        if($ups == NULL)
            return;
        foreach ($model as $ups) {
            $res = Yii::app()->UpsController->getAllStatuses($model['name'], $model['setting'], '');
            if ($res == -100) {
                $this->debug("UPS is not found...\r\n", false);
                continue;
            }
            if ($res == NULL) {
                $this->debug("UPS is not configured...\r\n", false);
                continue;
            }
            $flag = Yii::app()->functions->getFlag("ups_status");
            if ($res != NULL && count(array_diff($flag, $res)) == 0 && $force != false) {
                continue;
            }
            Yii::app()->functions->removeFlag("ups_status");
            Yii::app()->functions->writeFlag("ups_status", $res);
            $upsstatus = new UpsStatus();
            //array('id, date, status, change', 'required'),
            $upsstatus->id = $model['id'];
            $upsstatus->status = explode('\r\n', $flag);
            $upsstatus->change = array_diff($flag, $res);
            $upsstatus->date = date('Y-m-d H:m:s');
            $str = $upsstatus->ToString();
            $this->debug("$str \r\n", false);
            unset($upsstatus);
            unset($model);
            unset($str);
            unset($res);
        }
    }

    // Add log entry with the external temperature for each sensor
    public function logExternalTemperature($force) {
        $model = Setting::model()->findAll('setting_id=:sett', array(':sett' => 'external_temp_sensor_pin'));
        foreach ($model as $pin) {
            $res = Yii::app()->TemperatureController->getHumidityTemp($pin->setting, $pin->extended);
            $vd = var_dump($res);
            $this->debug("Checking with pin: $pin->setting and extended: $pin->extended. $vd \r\n", false);
            if ($res === NULL || count($res) <= 1) {
                $this->debug("Error loading temperature information, skipping...");
                $this->debug("Confirm you've added he root password to the config files....");
                continue;
            }
            $flag = Yii::app()->functions->getFlag("ex_tmp_$pin->setting");
            if ($flag != NULL && strcmp("ex_tmp_$pin->setting", $res) == 0 && $force != false) {
                continue;
            }
            Yii::app()->functions->removeFlag("ex_tmp_$pin->setting");
            Yii::app()->functions->writeFlag("ex_tmp_$pin->setting", $res);
            $tempModel = new ExternalTemperature();
            $tempModel->temperature = floatval($res[1]);
            $tempModel->humidity = floatval($res[0]);
            // Decide if alert is required
            $this->temperatureAlert($tempModel->temperature, $tempModel->humidity);
            $tempModel->date = date('Y-m-d H:m:s');
            $tempModel->log = "DataPIN=$pin->setting";
            $tempModel->save();
            $str = $tempModel->ToString();
            $this->debug("$str \r\n", false);
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
    public function temperatureAlert($temp, $humidity){
        $max_temp = Yii::app()->params['max_temp'];
        $min_temp = Yii::app()->params['min_temp'];
        $max_warn_temp = Yii::app()->params['max_warn_temp'];
        $min_warn_temp = Yii::app()->params['min_warn_temp'];
        $min_humidty = Yii::app()->params['min_humidity'];
        $warn_humidity = Yii::app()->params['warn_humidity'];
        $max_humidity = Yii::app()->params['max_humidity'];
        // Temperature exceeded the max temperature
        $this->debug("Max warn temp: $max_warn_temp, Min warn temp: $min_warn_temp, Max Temp: $max_temp, Min Temp: $min_temp, Max Humidity: $max_humidity, Warn Humidity: $warn_humidity, $");
        if($temp > $max_temp){
            $this->email("Maximum temperature exceeded: Current: $temp, Maximum: $max_temp", 'ALERT: Maximum temperature was exceeded.', true);
            $this->debug("Maximum temperature exceeded: Current: $temp, Maximum: $max_temp", 'ALERT: Maximum temperature was exceeded.');
            if ($humidity > $max_humidity){
                $this->email("Maximum humidity exceeded: Current: $humidity, Maximum: $max_humidity", 'ALERT: Maximum humidity was exceeded.', true);                
                $this->debug("Maximum humidity exceeded: Current: $humidity, Maximum: $max_humidity", 'ALERT: Maximum humidity was exceeded.');
            }
        }
        // Temperature below minimum
        if($temp < $min_temp){
            $this->email("Minimum temperature exceeded: Current: $temp, Minimum: $max_temp", 'ALERT: Minimum temperature was exceeded.', true);
            $this->debug("Minimum temperature exceeded: Current: $temp, Minimum: $max_temp", 'ALERT: Minimum temperature was exceeded.');
            if ($humidity < $min_humidity){
                $this->email("Minimum humidity exceeded: Current: $humidity, Minimum: $max_humidity", 'ALERT: Minimum humidity was exceeded.', true);                
                $this->debug("Minimum humidity exceeded: Current: $humidity, Minimum: $max_humidity", 'ALERT: Minimum humidity was exceeded.');
                return;
            }
            return;
        }
        // Temperature below warn
        if($temp < $min_warn_temp){
            $this->email("Minimum warning temperature exceeded: Current: $temp, Minimum: $max_temp", 'WARNING: Minimum temperature was exceeded.');
            $this->debug("Minimum warning temperature exceeded: Current: $temp, Minimum: $max_temp", 'WARNING: Minimum temperature was exceeded.');
        }
        // Temperature exceeded the max warning temperature
        if($temp > $max_warn_temp){
            $this->email("Maximum warning temperature exceeded: Current: $temp, Maximum: $max_temp", 'WARNING: Maximum temperature was exceeded.');
            $this->debug("Maximum warning temperature exceeded: Current: $temp, Maximum: $max_temp", 'WARNING: Maximum temperature was exceeded.');
        }
        if($warn_humidity > $humidity){
            $this->email("Warning, humidity over warning level. Current: $humidity", "Current: $humidity, Max warn level: $warn_humidity.");   
            $this->debug("Warning, humidity over warning level. Current: $humidity", "Current: $humidity, Max warn level: $warn_humidity.");
        }
        unset($max_temp);
        unset($min_temp);
        unset($max_warn_temp);
        unset($min_warn_temp);
        unset($min_humidty);
        unset($warn_humidity);
        unset($max_humidity);
    }

    /**
     * Sends email alerting of change
     * @param alert Sends message.
     * @param subject Subject to be sent on email.
     * @param force (If we ignore the supress time)
     */
    public function email($alert, $subject, $force = false){
        if(!$this->supress_mail){
            // Time since supress
            $this->to_time = strtotime(date("Y-m-d H:i:s", time() + intval(Yii::app()->params['mail_antispam'])));
        }
        if($this->supress_mail && round(abs(strtotime(date("Y-m-d H:i:s", time())) - $this->from_time) / 60,2) <= 0){
            $this->supress_mail = false;
        }
        if(!$this->supress_mail || $force){
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
    
    // Log the actual status of the relay board
    public function logRelayStatus($force) {
        $res = Yii::app()->RelayController->getRelayStatus(NULL, true);
        $flag = Yii::app()->functions->getFlag("relay_status");
        if ($flag != NULL && strcmp("relay_status", $res) == 0 && $force != false) {
            return;
        }
        Yii::app()->functions->removeFlag('relay_status');
        Yii::app()->functions->writeFlag('relay_status', $res);
        $relay = new RelayChanges();
        //array('date, relay_number, action, log', 'required'),
        //$relay->
        //Yii::app()->RelayController->changeRelayStatus(1, 1);
        //$this->debug("Relay info: $relayInfo", false);
        //var_dump($relayInfo);
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
