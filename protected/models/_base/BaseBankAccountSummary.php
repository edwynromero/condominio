<?php

/**
 * This is the model base class for the table "mip_bank_account_summary".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "BankAccountSummary".
 *
 * Columns in table "mip_bank_account_summary" available as properties of the model,
 * followed by relations of table "mip_bank_account_summary" available as properties of the model.
 *
 * @property integer $id
 * @property integer $month
 * @property integer $year
 * @property string $data
 * @property string $file_name
 * @property integer $bank_account_id
 *
 * @property MipBankAccountEntry[] $mipBankAccountEntries
 * @property MipBankAccount $bankAccount
 */
abstract class BaseBankAccountSummary extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'mip_bank_account_summary';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'BankAccountSummary|BankAccountSummaries', $n);
	}

	public static function representingColumn() {
		return 'data';
	}

	public function rules() {
		return array(
			array('month, year, bank_account_id', 'required'),
			array('month, year, bank_account_id', 'numerical', 'integerOnly'=>true),
			array('data, file_name', 'safe'),
			array('data, file_name', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, month, year, data, file_name, bank_account_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'mipBankAccountEntries' => array(self::HAS_MANY, 'BankAccountEntry', 'bank_account_summary_id'),
			'bankAccount' => array(self::BELONGS_TO, 'BankAccount', 'bank_account_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'month' => Yii::t('app', 'Month'),
			'year' => Yii::t('app', 'Year'),
			'data' => Yii::t('app', 'Data'),
			'file_name' => Yii::t('app', 'File Name'),
			'bank_account_id' => null,
			'mipBankAccountEntries' => null,
			'bankAccount' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('month', $this->month);
		$criteria->compare('year', $this->year);
		$criteria->compare('data', $this->data, true);
		$criteria->compare('file_name', $this->file_name, true);
		$criteria->compare('bank_account_id', $this->bank_account_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}