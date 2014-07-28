<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class MailExportForm extends CFormModel {

    public $email;
    public $subject;
    public $body;
    public $stack;

    /**
     * Declares the validation rules.
     */
    public function rules() {
        return array(
            // name, email, subject and body are required
            array('email, subject', 'required'),
            // email has to be a valid email address
            array('email', 'email'),
                // verifyCode needs to be entered correctly
        );
    }

    /**
     * Declares customized attribute labels.
     * If not declared here, an attribute would have a label that is
     * the same as its name with the first letter in upper case.
     */
    public function attributeLabels() {
        return array(
            'email' => 'Send to',
            'subject' => 'Subject',
            'body' => 'Body',
            'stack' => 'Data',
        );
    }

}