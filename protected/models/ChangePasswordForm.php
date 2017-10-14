<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class ChangePasswordForm extends CFormModel
{
	public $password;
	public $password_confirm;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('password, password_confirm', 'required', 'message' => MipHelper::t("The {attribute} cannot be blank")),
			array('password_confirm', 'compare', 'compareAttribute'=>'password', 'message' => MipHelper::t("The password, and confirmation has been equal")),
			array('password', 'length', 'min'=>6, 'max'=>12),
			array('password', 'match', 'pattern'=>'/\d/', 'message'=> MipHelper::t('Password must contain at least one numeric digit') ),
			array('password', 'match', 'pattern'=>'((?=.*[a-z]))', 'message'=>MipHelper::t('Password must contain at least one lower case character') ),
			array('password', 'match', 'pattern'=>'((?=.*[A-Z]))', 'message'=>MipHelper::t('Password must contain at least one upper case character') ),
				
				
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>MipHelper::t('Password'),
			'password_confirm'=>MipHelper::t('Confirm Password'),
		);
	}


}
