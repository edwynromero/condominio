<?php

/**
 * This is the model base class for the table "mip_user".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "User".
 *
 * Columns in table "mip_user" available as properties of the model,
 * followed by relations of table "mip_user" available as properties of the model.
 *
 * @property integer $id
 * @property string $name
 * @property string $password
 * @property string $last_connection
 * @property string $token
 * @property integer $person_id
 * @property integer $is_admin
 *
 * @property AuthAssignment[] $authAssignments
 * @property Person $person
 */
abstract class BaseUser extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_user';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'User|Users', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, password', 'required'),
			array('person_id, is_admin', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>64),
			array('password', 'length', 'max'=>45),
			array('last_connection, token', 'safe'),
			array('last_connection, token, person_id, is_admin', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, password, last_connection, token, person_id, is_admin', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'authAssignments' => array(self::HAS_MANY, 'AuthAssignment', 'userid'),
			'person' => array(self::BELONGS_TO, 'Person', 'person_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'name' => Yii::t('app', 'Name'),
			'password' => Yii::t('app', 'Password'),
			'last_connection' => Yii::t('app', 'Last Connection'),
			'token' => Yii::t('app', 'Token'),
			'person_id' => null,
			'is_admin' => Yii::t('app', 'Is Admin'),
			'authAssignments' => null,
			'person' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('password', $this->password, true);
		$criteria->compare('last_connection', $this->last_connection, true);
		$criteria->compare('token', $this->token, true);
		$criteria->compare('person_id', $this->person_id);
		$criteria->compare('is_admin', $this->is_admin);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}