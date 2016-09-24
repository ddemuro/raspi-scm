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
        // Members rules
        $criteriaMembers = new CDbCriteria;
        // We check online members
        $criteriaMembers->addCondition('lastactivity >= "' . $time . '" ');
        $members = Members::model()->findAll($criteriaMembers);
        $this->debug("Members found with events to show " . count($members) . "\n", false);
        $this->periodicalRunnable($members);
        unset($time);
        unset($criteriaMembers);
        unset($members);
        //We sleep before next loop.
        //We sleep before next loop.
        $currentMemory = (memory_get_peak_usage(true) / 1024 / 1024);
        $mem_usage = (memory_get_usage(true) / 1024 / 1024);

        $this->debug("Peak memory usage: " . $currentMemory . " MB\r\n", false);
        $this->debug("Actual memory usage: " . $mem_usage . " MB\r\n", false);
    }

    /**
     * For better memory control, loop has been enclosed in function
     * @param type $debug
     * @param type $members
     * @return int
     */
    private function periodicalRunnable($members) {
        foreach ($members as $member) {
            foreach ($member->jsEvents as $trigger) {
                //Messages Data
                $cTrigger = new CDbCriteria;
                $cTrigger->compare('idMember', $member->id, false, 'AND');
                $cTrigger->compare('idEvent', $trigger->eventId, TRUE, 'AND');
                $trgr = JsTrigger::model()->find($cTrigger);
                //We switch per trigger type
                switch ($trigger->name) {
                    case "UpdateMsgCount":
                        $this->debug("Update message count for: $member->id \n", false);
                        $this->actionUpdateMsgCount($member->id);
                        break;
                    case "UpdateServerStats":
                        $this->debug("Update server status for: $member->id \n", false);
                        $this->actionUpdateServerStatus();
                        break;
                    case "UpdateMiniInbox":
                        $this->debug("Update mini inbox for: $member->id \n", false);
                        if ($trgr->extraData == 'full') {
                            $this->updateMiniInbox($member->id, 5);
                        } else {
                            $this->updateMiniInbox($member->id, 1);
                        }
                        break;
                    case "UpdateUnread":
                        $this->debug("Update unread for: $member->id \n", false);
                        if ($trgr->extraData == 'full') {
                            $this->updateUnreadMails($member->id, 5);
                        } else {
                            $this->updateUnreadMails($member->id, 1);
                        }
                        break;
                    default:
                        break;
                }
                // After trigger sent, we start again
                $this->debug("Deleting: $member->id, $trigger->eventId \n", false);
                if ($trgr !== null && $trgr->delete()) {
                    Yii::log("Error deleting $member->id, $trigger->eventId");
                }
                unset($trigger);
            }
            unset($member);
            unset($trgr);
            unset($cTrigger);
        }
        gc_collect_cycles();
    }

    /**
     * We update all user mails
     * @param type $id
     * @return type
     */
    private function updateMiniInbox($id, $limit = 1) {
        //Messages Data
        $cMail = new CDbCriteria;
        $sortMail = new CSort('MailForMember');
        $sortMail->defaultOrder = 'date ASC';
        $sortMail->applyOrder($cMail);
        $sortMail->attributes = array('usernameto' => $id);
        $cMail->compare('usernameto', $id, false, 'AND');
        if ($limit != 0) {
            $cMail->limit = $limit;
        }
        if ($limit > 1) {
            $event['clear'] = true;
        }
        $mails = MailForMember::model()->findAll($cMail);
        $mailCount = count($mails);
        // ==> Rework with frames.
        $eventStatic = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
        $eventStatic->setUserId($id);
        $eventStatic->setEventName('UpdateMiniInbox');
        $eventStatic['count'] = $mailCount;
        $eventStatic['NoMessagesText'] = Yii::t('admingeneral', 'You have no messages.');
        $eventStatic->send();
        unset($eventStatic);
        foreach ($mails as $mail) {
            $event = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
            $event->setUserId($id);
            $event->setEventName('UpdateMiniInbox');
            $event['fromText'] = Yii::t('admingeneral', 'From: ') . Members::model()->findByPk($mail->usernamefrom)->username;
            $event['subject'] = $mail->messagesubject;
            $event['message_read'] = $mail->message_read;
            $event['priority'] = $mail->priority;
            $event['uriViewMsg'] = Yii::app()->createUrl('membersmail/ViewMessage', array('messageId' => $mail->messageId));
            $event->send();
            unset($event);
        }
    }

    /**
     * We update all user mails
     * @param type $id
     * @return type
     */
    private function updateUnreadMails($id, $limit = 1) {
        $event = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
        $event->setUserId($id);
        $event->setEventName('UpdateUnreadMails');
        //Messages Data
        $cMail = new CDbCriteria;
        $sortMail = new CSort('MailForMember');
        $sortMail->defaultOrder = 'date ASC';
        $sortMail->applyOrder($cMail);
        $sortMail->attributes = array('usernameto' => $id);
        $cMail->compare('usernameto', $id, false, 'AND');
        if ($limit != 0) {
            $cMail->limit = $limit;
        }
        if ($limit > 1) {
            $event['clear'] = true;
        }
        $mails = MailForMember::model()->findAll($cMail);
        $mailCount = count($mails);
        $event['count'] = $mailCount;
        foreach ($mails as $mail) {
            $event['fromText'] = Yii::t('admingeneral', 'From: ') . Members::model()->findByPk($mail->usernamefrom)->username;
            $event['subject'] = $mail->messagesubject;
            //$event['ajaxButtonClose'] = CHtml::ajaxButton("x", Yii::app()->createUrl('membersmail/MarkRead', array('messageId' => $mail->messageId)), array('update' => '.mini-inbox'));
            $event['viewMessageIMG'] = '/themes/admin/default/';
            $event['viewMessageURL'] = Yii::app()->createUrl('membersmail/ViewMessage', array('messageId' => $mail->messageId));
        }
        $event->send();
    }

    /**
     * We update the messages count if changed.
     * @param type $userId
     */
    private function actionUpdateMsgCount($userId) {
        $event = Yii::app()->nodeSocket->getFrameFactory()->createUserEventFrame();
        $event->setUserId($userId);
        $event->setEventName('UpdateMsgCount');
        //Messages Data
        $cMail = new CDbCriteria;
        $cMail->compare('usernameto', $userId, false, 'AND');
        //$cMail->compare('message_read', array(0), TRUE, 'AND');
        $event['count'] = count(MailForMember::model()->findAll($cMail));
        $event->send();
    }

    /**
     * We update the server statistics if needed.
     */
    private function actionUpdateServerStatus() {
        $event = Yii::app()->nodeSocket->getFrameFactory()->createEventFrame();
        $event->setEventName('UpdateServerStatus');
        $outputCPU = shell_exec("ps aux|awk 'NR > 0 { s +=$3 /2 }; END {print s}'");
        $outputNorm = explode('.', $outputCPU);
        $disku = shell_exec("df -h /home | tail -1 | awk '{print $5}'");
        $edisku = explode('%', $disku);
        $event['CPUStat'] = $outputNorm[0];
        $event['DiskFree'] = $edisku[0];
        $event->send();
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
