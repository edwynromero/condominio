<?php

/**
 * This is the model base class for the table "mip_association_position".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AssociationPosition".
 *
 * Columns in table "mip_association_position" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $name
 * @property integer $is_main
 *
 */
abstract class BaseAssociationPosition extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_association_position';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AssociationPosition|AssociationPositions', $n);
	}

	public static function representingColumn() {
		return 'name';
	}

	public function rules() {
		return array(
			array('name', 'required'),
			array('is_main', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>255),
			array('is_main', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, name, is_main', 'safe', 'on'=>'search'),
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
			'is_main' => Yii::t('app', 'Is Main'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('is_main', $this->is_main);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}