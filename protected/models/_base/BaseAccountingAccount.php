<?php

/**
 * This is the model base class for the table "mip_accounting_account".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountingAccount".
 *
 * Columns in table "mip_accounting_account" available as properties of the model,
 * followed by relations of table "mip_accounting_account" available as properties of the model.
 *
 * @property integer $id
 * @property integer $parent_account_id
 * @property string $type
 * @property integer $code
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 * @property string $access_key
 * @property string $kind
 * @property string $note
 * @property integer $deprecated
 *
 * @property AccountingAccount $parentAccount
 * @property AccountingAccount[] $accountingAccounts
 * @property AccountingAccountKind $kind0
 * @property AccountingAccountType $type0
 * @property AccountingAlias[] $accountingAliases
 * @property AccountingMoveLine[] $accountingMoveLines
 */
abstract class BaseAccountingAccount extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_accounting_account';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'AccountingAccount|AccountingAccounts', $n);
	}

	public static function representingColumn() {
		return 'created_at';
	}

	public function rules() {
		return array(
			array('type, created_at', 'required'),
			array('parent_account_id, code, deprecated', 'numerical', 'integerOnly'=>true),
			array('type, kind', 'length', 'max'=>4),
			array('label', 'length', 'max'=>45),
			array('access_key', 'length', 'max'=>6),
			array('updated_at, note', 'safe'),
			array('parent_account_id, code, label, updated_at, access_key, kind, note, deprecated', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, parent_account_id, type, code, label, created_at, updated_at, access_key, kind, note, deprecated', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'parentAccount' => array(self::BELONGS_TO, 'AccountingAccount', 'parent_account_id'),
			'accountingAccounts' => array(self::HAS_MANY, 'AccountingAccount', 'parent_account_id'),
			'kind0' => array(self::BELONGS_TO, 'AccountingAccountKind', 'kind'),
			'type0' => array(self::BELONGS_TO, 'AccountingAccountType', 'type'),
			'accountingAliases' => array(self::HAS_MANY, 'AccountingAlias', 'account_id'),
			'accountingMoveLines' => array(self::HAS_MANY, 'AccountingMoveLine', 'accounting_account_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'parent_account_id' => null,
			'type' => null,
			'code' => Yii::t('app', 'Code'),
			'label' => Yii::t('app', 'Label'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'access_key' => Yii::t('app', 'Access Key'),
			'kind' => null,
			'note' => Yii::t('app', 'Note'),
			'deprecated' => Yii::t('app', 'Deprecated'),
			'parentAccount' => null,
			'accountingAccounts' => null,
			'kind0' => null,
			'type0' => null,
			'accountingAliases' => null,
			'accountingMoveLines' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('parent_account_id', $this->parent_account_id);
		$criteria->compare('type', $this->type);
		$criteria->compare('code', $this->code);
		$criteria->compare('label', $this->label, true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('access_key', $this->access_key, true);
		$criteria->compare('kind', $this->kind);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('deprecated', $this->deprecated);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}