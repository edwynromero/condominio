<?php

class BankTransactionUpload extends CActiveForm
{
	
	public $bankAccount;
	public $csvFileUploaded;
	
	public function rules()
	{
		return array(
			
			array('csvFileUploaded', 'file', 'types'=>'csv, txt'),
		);
	}
	
}