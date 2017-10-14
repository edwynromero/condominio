<?php

Yii::import('application.models._base.BaseUser');

class User extends BaseUser
{
	
	public $password_confirm;
	
	public function rules() {
		return array(
				array('name', 'required'),
				array('person_id, is_admin', 'numerical', 'integerOnly'=>true),
				array('name', 'length', 'max'=>64),
				array('password', 'length', 'max'=>45),
				array('password', 'required', 'on'=>'create'),
				
			//		array('password', 'unsafe', 'on'=>'update'),
				array('name', 'unique'),
				array('last_connection, token, password_confirm', 'safe'),
				array('last_connection, token, person_id, is_admin', 'default', 'setOnEmpty' => true, 'value' => null),
				array('id, name, password, last_connection, token, person_id, is_admin', 'safe', 'on'=>'search'),
		);
	}	
	
	public function attributeLabels() {
		return array(
				'id' => Yii::t('app', 'ID'),
				'name' => Yii::t('app', 'UserName'),
				'password' => Yii::t('app', 'Password'),
				'last_connection' => Yii::t('app', 'Last Connection'),
				'token' => Yii::t('app', 'Token'),
				'person_id' => Yii::t('app', 'Person'),
				'is_admin' => Yii::t('app', 'Is Admin'),
				'authAssignments' => null,
				'person' => Yii::t('app', 'Person'),
				'password_confirm' => Yii::t('app', 'Confirmación Clave'),
		);
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}