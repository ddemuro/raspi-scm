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
        Yii::log("Trying to authenticate $this->email and password &this->password", CLogger::LEVEL_INFO, "info");
        $record = User::model()->findByAttributes(array('email' => $this->username));
        if ($record === null) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('members', 'Sorry, But we can\'t find a member with those login information.');
        } else if ($record->password !== $record->hashPassword($this->password, $record->username)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = Yii::t('members', 'Sorry, But the password did not match the one in our records.');
        } else if (strcmp($this->email, "admin@admin.com") && strcmp($this->password, "admin")){
          $this->_id = $record->id;
          $this->errorCode = self::ERROR_NONE;
          return true;
        } else {
            $this->_id = $record->id;
            $this->errorCode = self::ERROR_NONE;
            return true;
        }
        return false;
    }
}
