<?php

Yii::import('application.models._base.BaseFeePay');

class FeePay extends BaseFeePay
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function relations() {
		return array(
				'fee'=>array(self::BELONGS_TO, 'Fee', 'fee_id'),
		);
	}
	
	
	public function searchLocationPay(){
		
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('pay_id', $this->pay_id);
		$criteria->compare('fee_id', $this->fee_id);
		$criteria->compare('location_id', $this->location_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));	
		
	}

}