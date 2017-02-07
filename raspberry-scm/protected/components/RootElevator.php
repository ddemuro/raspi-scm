<?php

/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class RootElevator extends CApplicationComponent {
    /*
     * To change this license header, choose License Headers in Project Properties.
     * To change this template file, choose Tools | Templates
     * and open the template in the editor.
     */

    /**
     * Run command against local host
     * @param type $cmd
     * @param SSH $retcallback
     */
    public function executeRoot($cmd, $retcallback, $retstatus=False) {
        $ssh = Yii::app()->phpseclib->createSSH2('localhost');
        $rootpwd = Yii::app()->functions->yiiparam('rootpwd', NULL);
        if ($rootpwd === NULL || !$ssh->login('root', $rootpwd)) {
            Yii::log("Error elevating to root. Could not establish ssh connection to localhost");
            return NULL;
        }
        if ($retcallback) {
            return array($ssh->exec($cmd), $ssh);
        }
        if($retstatus){
            $ssh->exec($cmd);
            return $ssh->getExitStatus();
        }
        return $ssh->exec($cmd);
    }

}
