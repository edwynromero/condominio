<?php

/**
 * This is the model base class for the table "mip_group_person".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "GroupPerson".
 *
 * Columns in table "mip_group_person" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property integer $active
 *
 */
abstract class BaseGroupPerson extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_group_person';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'GroupPerson|GroupPeople', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name, type', 'required'),
			array('active', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>160),
			array('type', 'length', 'max'=>1),
			array('active', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, type, active', 'safe', 'on'=>'search'),
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
			'name' => Yii::t('app', 'Name'),
			'type' => Yii::t('app', 'Type'),
			'active' => Yii::t('app', 'Active'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('type', $this->type, true);
		$criteria->compare('active', $this->active);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}