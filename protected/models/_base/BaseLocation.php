<?php

/**
 * This is the model base class for the table "mip_location".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Location".
 *
 * Columns in table "mip_location" available as properties of the model,
 * followed by relations of table "mip_location" available as properties of the model.
 *
 * @property integer $id
 * @property string $code
 * @property string $status
 * @property string $initial_debt
 * @property integer $is_built
 * @property string $comments
 *
 * @property FeePay[] $feePays
 * @property LocationGeometry[] $locationGeometries
 * @property Owner[] $owners
 */
abstract class BaseLocation extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_location';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Location|Locations', $n);
	}

	public static function representingColumn() {
		return 'code';
	}

	public function rules() {
		return array(
			array('code', 'required'),
			array('is_built', 'numerical', 'integerOnly'=>true),
			array('code, initial_debt', 'length', 'max'=>10),
			array('status', 'length', 'max'=>1),
			array('comments', 'length', 'max'=>120),
			array('status, initial_debt, is_built, comments', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, code, status, initial_debt, is_built, comments', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'feePays' => array(self::HAS_MANY, 'FeePay', 'location_id'),
			'locationGeometries' => array(self::HAS_MANY, 'LocationGeometry', 'location_id'),
			'owners' => array(self::HAS_MANY, 'Owner', 'location_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'code' => Yii::t('app', 'Code'),
			'status' => Yii::t('app', 'Status'),
			'initial_debt' => Yii::t('app', 'Initial Debt'),
			'is_built' => Yii::t('app', 'Is Built'),
			'comments' => Yii::t('app', 'Comments'),
			'feePays' => null,
			'locationGeometries' => null,
			'owners' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('initial_debt', $this->initial_debt, true);
		$criteria->compare('is_built', $this->is_built);
		$criteria->compare('comments', $this->comments, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}