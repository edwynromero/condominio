<?php

Yii::import('application.models._base.BaseRegisterRequest');

/**
 * Clase que representa a la Entidad de Registro de Usuarios
 * 
 * @author astarot
 *
 */
class RegisterRequest extends BaseRegisterRequest
{
	
	public $user_password_confirm;
	public $person_email_confirm;
	
	const STATUS_WAITING = 0;
	const STATUS_APPROVED = 1;	
	const STATUS_REJECTED = 2;
	
	
	public function  attributeLabels()
	{ 
		return CMap::mergeArray(parent::attributeLabels(), array(
			'user_password_confirm' => Yii::t('app', 'User Password Confirm'),
			'person_email_confirm' => Yii::t('app', 'Personal Email Confirm'),
		));
	}
	
	
	/**
	 * 
	 */
	public static function getStatusList()
	{
		return array(
			RegisterRequest::STATUS_WAITING=>MipHelper::t('STATUS_WAITING'),
			RegisterRequest::STATUS_APPROVED=>MipHelper::t('STATUS_APPROVED'),
			RegisterRequest::STATUS_REJECTED=>MipHelper::t('STATUS_REJECTED'),
		);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see BaseRegisterRequest::rules()
	 */
	public function rules()
	{
		$rules =  CMap::mergeArray(parent::rules(), array(
			array('person_email','email', 'message' => MipHelper::t('The "personal email" is not email valid')),
			array('phone_number, phone_prefix, identity_code', 'numerical'),
			array('user_name','checkUserName'),
			array('user_password', 'required', 'on'=>'create, update_password'),
			array('user_password', 'length', 'min'=>6, 'max'=>16),
			array('user_password', 'match', 'pattern'=>'/\d/', 'message'=> MipHelper::t('Password must contain at least one numeric digit') ),
			array('user_password', 'match', 'pattern'=>'((?=.*[a-z]))', 'message'=>MipHelper::t('Password must contain at least one lower case character') ),
			array('user_password', 'match', 'pattern'=>'((?=.*[A-Z]))', 'message'=>MipHelper::t('Password must contain at least one upper case character') ),
			array('user_password_confirm', 'compare', 'compareAttribute'=>'user_password', 'message' => MipHelper::t("The password, and confirmation has been equal"), 'on'=>array('create', 'update_password', 'update_password_email')),
			array('person_email_confirm', 'compare', 'compareAttribute'=>'person_email', 'message' => MipHelper::t("The Personal Email, and confirmation, has been equal"), 'on'=>array('create', 'update_email', 'update_password_email')),

				
		));
		return $rules;
	}
	
	
	/**
	 * 
	 * @param unknown $attribute
	 * @param unknown $parameters
	 */
	public function checkUserName($attribute, $parameters)
	{
		if(  User::model()->count('name = :name', array(':name'=>$this->$attribute)) > 0 )
		{
			$this->addError($attribute,  MipHelper::t('The User Name has been used, try other'));
		}
		
	}
	
	/**
	 * 
	 * @param system $className
	 * @return CActiveRecord
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}