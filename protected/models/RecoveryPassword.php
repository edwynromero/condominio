<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class RecoveryPassword extends CFormModel
{
	public $email;
	public $email_confirm;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email_confirm, email', 'required', 'message' => MipHelper::t("{attribute} cannot be blank")),
			array('email_confirm', 'compare', 'compareAttribute'=>'email', 'message' => MipHelper::t("Recovery emails must be equal")),
			array('email_confirm, email','email', 'message' => MipHelper::t("Is not a valid email")),
			array('email', 'checkExistPassword'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'email'=>MipHelper::t('Email'),
			'email_confirm'=>MipHelper::t('Confirm Email'),
		);
	}
	
	
	/**
	 * 
	 */
	public function checkExistPassword($attribute, $parameters)
	{
		$email = $this->$attribute;
		$personEmails = PersonEmail::model()->findAll("email = :email", array(":email"=> $email));
		
		if( count($personEmails) > 1 )
		{
			$this->addError($attribute,  MipHelper::t('The email is registered two or more times'));
		}
		
		if(count($personEmails) == 0 )
		{
			$this->addError($attribute, MipHelper::t("The email don't exist, please try again with other or register your user"));
		}

	}


	/**
	 * 
	 */
	public function recovery()
	{
		$personEmail = PersonEmail::model()->find("email = :email", array(":email"=> $this->email));
		$person = Person::model()->findByPk($personEmail->person_id);
		$user = User::model()->find('person_id = :person_id', array(':person_id'=>$personEmail->person_id));
		
		if( $user )
		{
			$userExist = true;
			$getToken=rand(0, 99999);
			$getTime=date("H:i:s");
			$user->token  = md5($getToken.$getTime);
                    
			if( $user->save(false) )
			{
				Yii::app()->dpsMailer->sendByView(
				array( $personEmail->email => $person->getFullNameEmail() ),
				'frontend/forget/email_recovery', // template email view
				array( 'sUsername' =>$person->getFullNameEmail(),
				'sToken'=>$user->token,
				'sLogoPicPath' => Yii::app()->theme->basePath . '/img/logo_mirador_small.jpg',
				'sEmail'=>$this->email)
				);
				return true;
			}
			
			$this->addError("email", MipHelper::t("Has ocurred and error try recover the password"));
		}
		else 
		{
			$this->addError("email", MipHelper::t("The user don't exist, please request register"));
		}

		
		return false;
	}
}
