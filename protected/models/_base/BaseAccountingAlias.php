<?php

/**
 * This is the model base class for the table "mip_accounting_alias".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountingAlias".
 *
 * Columns in table "mip_accounting_alias" available as properties of the model,
 * followed by relations of table "mip_accounting_alias" available as properties of the model.
 *
 * @property string $key
 * @property integer $account_id
 * @property string $label
 * @property string $alias
 *
 * @property AccountingAccount $account
 */
abstract class BaseAccountingAlias extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_accounting_alias';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AccountingAlias|AccountingAliases', $n);
	}

	public static function representingColumn() {
		return 'label';
	}

	public function rules() {
		return array(
			array('key, account_id, label', 'required'),
			array('account_id', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>6),
			array('label, alias', 'length', 'max'=>64),
			array('alias', 'default', 'setOnEmpty' => true, 'value' => null),
			array('key, account_id, label, alias', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'account' => array(self::BELONGS_TO, 'AccountingAccount', 'account_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'key' => Yii::t('app', 'Key'),
			'account_id' => null,
			'label' => Yii::t('app', 'Label'),
			'alias' => Yii::t('app', 'Alias'),
			'account' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('key', $this->key, true);
		$criteria->compare('account_id', $this->account_id);
		$criteria->compare('label', $this->label, true);
		$criteria->compare('alias', $this->alias, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}