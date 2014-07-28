<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity {

    private $_id;

    const ERROR_BLOCKED = 1251212;

    public function authenticate() {
        $record = User::model()->findByAttributes(array('email' => $this->username));
        if ($record === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        else if ($record->password !== sha1($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
        else
        if ($record->blocked != 0) {
            $this->errorCode = self::ERROR_BLOCKED;
        } else {
            $this->_id = $record->id;

            $this->setState('email', $record->email);
            $this->setState('user', $record);
            $this->errorCode = self::ERROR_NONE;
        }
        return !$this->errorCode;
    }

    public function getId() {
        return $this->_id;
    }

}