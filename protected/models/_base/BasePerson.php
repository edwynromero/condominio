<?php

/**
 * This is the model base class for the table "mip_person".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Person".
 *
 * Columns in table "mip_person" available as properties of the model,
 * followed by relations of table "mip_person" available as properties of the model.
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identity_code
 * @property string $identity_type
 * @property integer $active
 * @property string $inactive_description
 * @property integer $group_person_id
 *
 * @property GroupPerson $groupPerson
 */
abstract class BasePerson extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_person';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Person|People', $n);
	}

	public static function representingColumn() {
		return 'first_name';
	}

	public function rules() {
		return array(
			array('first_name, last_name, full_name, identity_code, identity_type', 'required'),
			array('active, group_person_id', 'numerical', 'integerOnly'=>true),
			array('first_name, last_name', 'length', 'max'=>60),
			array('full_name', 'length', 'max'=>120),
			array('identity_code', 'length', 'max'=>16),
			array('identity_type', 'length', 'max'=>1),
			array('inactive_description', 'length', 'max'=>255),
			array('active, inactive_description, group_person_id', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, first_name, last_name, full_name, identity_code, identity_type, active, inactive_description, group_person_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'groupPerson' => array(self::BELONGS_TO, 'GroupPerson', 'group_person_id'),
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
			'active' => Yii::t('app', 'Active'),
			'inactive_description' => Yii::t('app', 'Inactive Description'),
			'group_person_id' => null,
			'groupPerson' => null,
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
		$criteria->compare('active', $this->active);
		$criteria->compare('inactive_description', $this->inactive_description, true);
		$criteria->compare('group_person_id', $this->group_person_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}