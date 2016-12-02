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
    public $_id;

    function __construct($email, $password) {
        $this->email = $email;
        $this->password = $password;
    }

    public function authenticate() {
        Yii::log("Trying to authenticate $this->email and password $this->password", CLogger::LEVEL_INFO, "info");
        $record = User::model()->findByAttributes(array('email' => $this->email));
        if (strcmp($this->email, $record->email) == 0 && strcmp($record->hashPassword($this->password, $this->email), $record->password) == 0) {
            $this->_id = $record->id;
            // We add username to the state 
            $this->setState('email', $record->email);
            $this->setState('username', explode('@', $record->email)[0]);
            $this->setState('id', $record->id);
            $this->errorCode = self::ERROR_NONE;
            return true;
        } else if ($record->password !== $record->hashPassword($this->password, $record->email)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = Yii::t('members', 'Sorry, But the password did not match the one in our records.');
        }
        $this->errorCode = self::ERROR_USERNAME_INVALID;
        $this->errorMessage = Yii::t('members', 'Sorry, But we can\'t find a member with those login information.');
        return false;
    }

    /**
     * @return int unique user id
     */
    public function getId() {
        return $this->_id;
    }

}
