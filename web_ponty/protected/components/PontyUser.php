<?php

/**
 * This Class represents a PontyUser
 * It can be an Admin or an User.
 * 
 * @author Andreas Vratny
 * @version 0.1
 * @package application.components
 */
class PontyUser extends CWebUser {

//Save the model to avoid loading twice
    private $_model;

    /**
     * @var integer
     * Every time a user edit or show an stack, the stackID will be saved here
     */
    public $choosenStack;

    /**
     * This is a function that checks if the User is a Admin
     * in the User model to be equal to 1, that means it's admin
     * access it by Yii::app()->user->isAdmin()
     * 
     * @return boolean */
    function getisAdmin() {
        $user = $this->loadUser(Yii::app()->user->id);
        if ($user != null) {
            return $user->is_admin == 1;
        }
        else
            return false;
    }

    /**
     * This function loads the Usermodel wich will be stored in $_model
     * 
     * @return User */
    protected function loadUser($id = null) {
        if ($this->_model === null) {
            if ($id !== null)
                $this->_model = User::model()->findByPk($id);
        }
        return $this->_model;
    }

}

?>