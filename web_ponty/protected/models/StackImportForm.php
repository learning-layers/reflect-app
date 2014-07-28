<?php

/**
 * StackImportForm class.
 * StackImportForm is the data structure for keeping
 * stackimport form data.
 */
class StackImportForm extends CFormModel
{
	public $publickey;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// publickey is required
			array('publickey', 'required'),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'publickey'=>'Public Key',
		);
	}
}