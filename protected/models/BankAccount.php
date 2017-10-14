<?php

Yii::import('application.models._base.BaseBankAccount');

class BankAccount extends BaseBankAccount
{
	const ACCOUNT_TYPE_CHECK 		= "C";
	const ACCOUNT_TYPE_SAVING 		= "A";
	const ACCOUNT_TYPE_ONLY_MIP             = "I";
	
	const ACCOUNT_TYPE_CHECK_LABEL 		= "Check";
	const ACCOUNT_TYPE_SAVING_LABEL 	= "Saving";
	const ACCOUNT_TYPE_ONLY_MIP_LABEL 	= "Internal Mirador";
	
	public static function getAccountTypeList()
	{
		return array(
			self::ACCOUNT_TYPE_CHECK	=> MipHelper::t(self::ACCOUNT_TYPE_CHECK_LABEL),
			self::ACCOUNT_TYPE_SAVING	=> MipHelper::t(self::ACCOUNT_TYPE_SAVING_LABEL),
			self::ACCOUNT_TYPE_ONLY_MIP => MipHelper::t(self::ACCOUNT_TYPE_ONLY_MIP_LABEL),
		);
	}
	
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = parent::rules();
		return CMap::mergeArray($rules, array(
				array('account_type', 'required'),					
		));		
	}
	
	
	public function getFullReference()
	{
		return MipHelper::getBankName( $this->bank_id ) . " - " . $this->number . " (" . MipHelper::getAccountTypeName( $this->account_type ) . ")";	
	}
	
	public function getShortReference()
	{
		return MipHelper::getShortBankName( $this->bank_id ) . " - ***" .  substr($this->number, 0, 5);
	}
	
	
	public function searchAdmin()
	{
		$criteria = new CDbCriteria;
		$criteria->join =  " INNER JOIN " . Bank::model()->tableName() . " b ";
		$criteria->join .= " ON (t.bank_id = b.id )";
		
		$criteria->compare('id', $this->id);
		$criteria->compare('b.name', $this->bank_id, true);
		$criteria->compare('account_type', $this->account_type, true);
		$criteria->compare('number', $this->number, true);
		
		
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
		
	}
}