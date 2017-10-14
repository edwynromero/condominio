<?php

/**
 * This is the model base class for the table "mip_register_request".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "RegisterRequest".
 *
 * Columns in table "mip_register_request" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identity_code
 * @property string $identity_type
 * @property integer $status
 * @property string $reference
 * @property string $phone_prefix
 * @property string $phone_number
 * @property string $phone_type
 * @property string $person_email
 * @property string $user_name
 * @property string $user_password
 *
 */
abstract class BaseRegisterRequest extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_register_request';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'RegisterRequest|RegisterRequests', $n);
	}

	public static function representingColumn() {
		return 'first_name';
	}

	public function rules() {
		return array(
			array('first_name, last_name, full_name, identity_code, identity_type, phone_prefix, phone_number, phone_type, person_email, user_name, user_password', 'required'),
			array('status', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>60),
			array('full_name', 'length', 'max'=>120),
			array('identity_code', 'length', 'max'=>16),
			array('identity_type', 'length', 'max'=>1),
			array('reference', 'length', 'max'=>512),
			array('phone_prefix', 'length', 'max'=>5),
			array('phone_number', 'length', 'max'=>9),
			array('phone_type', 'length', 'max'=>2),
			array('user_name', 'length', 'max'=>64),
			array('user_password', 'length', 'max'=>45),
			array('status, reference', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, first_name, last_name, full_name, identity_code, identity_type, status, reference, phone_prefix, phone_number, phone_type, person_email, user_name, user_password', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'first_name' => Yii::t('app', 'First Name'),
			'last_name' => Yii::t('app', 'Last Name'),
			'full_name' => Yii::t('app', 'Full Name'),
			'identity_code' => Yii::t('app', 'Identity Code'),
			'identity_type' => Yii::t('app', 'Identity Type'),
			'status' => Yii::t('app', 'Status'),
			'reference' => Yii::t('app', 'Reference'),
			'phone_prefix' => Yii::t('app', 'Phone Prefix'),
			'phone_number' => Yii::t('app', 'Phone Number'),
			'phone_type' => Yii::t('app', 'Phone Type'),
			'person_email' => Yii::t('app', 'Person Email'),
			'user_name' => Yii::t('app', 'User Name'),
			'user_password' => Yii::t('app', 'User Password'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('first_name', $this->first_name, true);
		$criteria->compare('last_name', $this->last_name, true);
		$criteria->compare('full_name', $this->full_name, true);
		$criteria->compare('identity_code', $this->identity_code, true);
		$criteria->compare('identity_type', $this->identity_type, true);
		$criteria->compare('status', $this->status);
		$criteria->compare('reference', $this->reference, true);
		$criteria->compare('phone_prefix', $this->phone_prefix, true);
		$criteria->compare('phone_number', $this->phone_number, true);
		$criteria->compare('phone_type', $this->phone_type, true);
		$criteria->compare('person_email', $this->person_email, true);
		$criteria->compare('user_name', $this->user_name, true);
		$criteria->compare('user_password', $this->user_password, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}