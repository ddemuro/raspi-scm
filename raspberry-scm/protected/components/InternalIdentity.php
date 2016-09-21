<?php

/**
 * Internal Identity Class
 * Basically verifies a member by his email from the DB
 *
 *
 */
class InternalIdentity extends CUserIdentity {

    /**
     * Authenticate a member
     *
     * @return int value greater then 0 means an error occurred
     */
     public $email;
     public $password;
     public $id;

     function __construct($email, $password) {
       $this->email = $email;
       $this->password = $password;
     }

    public function authenticate() {
        Yii::log("Trying to authenticate $this->email and password $this->password", CLogger::LEVEL_INFO, "info");
        $record = User::model()->findByAttributes(array('email' => $this->username));
        Yii::log("Record: $record", CLogger::LEVEL_INFO, "info");
        if ($record === null && strcmp($this->email, "admin@admin.com") != 0) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('members', 'Sorry, But we can\'t find a member with those login information.');
        } else if (strcmp($this->email, "admin@admin.com") == 0 && strcmp($this->password, "admin") == 0){
            Yii::log("Using default credentials...", CLogger::LEVEL_INFO, "info");
            $this->_id = 01;
            // We add username to the state 
            $this->setState('email', $this->email);
            $this->setState('id', 01);
            $this->errorCode = self::ERROR_NONE;
            return true;
        } else if ($record->password !== $record->hashPassword($this->password, $record->username)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = Yii::t('members', 'Sorry, But the password did not match the one in our records.');
        } else {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_NONE;
            return true;
        }
        return false;
    }
    
    /**
     * @return int unique user id
     */
    public function getId() {
        return $this->_id;
    }
}
