<?php

/**
 * This is the model base class for the table "mip_fee_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FeeType".
 *
 * Columns in table "mip_fee_type" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $description
 * @property string $value
 * @property integer $active
 * @property integer $is_regular
 *
 */
abstract class BaseFeeType extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_fee_type';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'FeeType|FeeTypes', $n);
	}

	public static function representingColumn() {
		return 'title';
	}

	public function rules() {
		return array(
			array('title, summary, active, is_regular', 'required'),
			array('active, is_regular', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>60),
			array('summary', 'length', 'max'=>255),
			array('value', 'length', 'max'=>10),
			array('description', 'safe'),
			array('description, value', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, title, summary, description, value, active, is_regular', 'safe', 'on'=>'search'),
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
			'title' => Yii::t('app', 'Title'),
			'summary' => Yii::t('app', 'Summary'),
			'description' => Yii::t('app', 'Description'),
			'value' => Yii::t('app', 'Value'),
			'active' => Yii::t('app', 'Active'),
			'is_regular' => Yii::t('app', 'Is Regular'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('is_regular', $this->is_regular);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}