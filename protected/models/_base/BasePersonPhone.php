<?php

/**
 * This is the model base class for the table "mip_person_phone".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "PersonPhone".
 *
 * Columns in table "mip_person_phone" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property integer $person_id
 * @property string $prefix
 * @property string $number
 * @property integer $is_main
 * @property string $type
 * @property integer $country_id
 *
 */
abstract class BasePersonPhone extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_person_phone';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'PersonPhone|PersonPhones', $n);
	}

	public static function representingColumn() {
		return 'prefix';
	}

	public function rules() {
		return array(
			array('person_id, prefix, number, country_id', 'required'),
			array('person_id, is_main, country_id', 'numerical', 'integerOnly'=>true),
			array('prefix', 'length', 'max'=>5),
			array('number', 'length', 'max'=>9),
			array('type', 'length', 'max'=>2),
			array('is_main, type', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, person_id, prefix, number, is_main, type, country_id', 'safe', 'on'=>'search'),
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
			'person_id' => Yii::t('app', 'Person'),
			'prefix' => Yii::t('app', 'Prefix'),
			'number' => Yii::t('app', 'Number'),
			'is_main' => Yii::t('app', 'Is Main'),
			'type' => Yii::t('app', 'Type'),
			'country_id' => Yii::t('app', 'Country'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('person_id', $this->person_id);
		$criteria->compare('prefix', $this->prefix, true);
		$criteria->compare('number', $this->number, true);
		$criteria->compare('is_main', $this->is_main);
		$criteria->compare('type', $this->type, true);
		$criteria->compare('country_id', $this->country_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}