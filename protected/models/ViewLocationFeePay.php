<?php

Yii::import('application.models._base.BaseViewLocationFeePay');

class ViewLocationFeePay extends BaseViewLocationFeePay
{
	public $person_id;
	
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function searchByPerson() {
		$criteria = new CDbCriteria;
	
		$criteria->compare('feed_id', $this->feed_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('begin_date', $this->begin_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('location_id', $this->location_id);
		$criteria->compare('code', $this->code);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('fee_pay_id', $this->fee_pay_id);
		$criteria->compare('fee_payed', $this->fee_payed);
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}
		
	/**
	 * Provider para filtrar por Cuotas Pendientes y Pagadas
	 * @return CActiveDataProvider
	 */
	public function searchByPay() {
		$criteria = new CDbCriteria;
		
		$parameters = array();
		
		

		$criteria->compare('location_id', $this->location_id);

		if( !is_null( $this->pay_id ) )
		{
			$pay = Pay::model()->findByPk( $this->pay_id );
			
			$criteria->addCondition(" ( pay_id IS NULL  OR pay_id = :pay_id )  AND begin_date <= :pay_date" );
			$parameters[":pay_id"] = $this->pay_id;
			$parameters[":pay_date"] = $pay->pay_date;
		}
		
		$criteria->params = CMap::mergeArray($criteria->params , $parameters);
		
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
                                'sort'=>array(
                                        'defaultOrder'=>'begin_date ASC',
                                ),
		));
	}
	
	/**
	 * 
	 * @return CActiveDataProvider
	 */
	public function searchFull($limit = -1) {
		$criteria = new CDbCriteria;
	
		$criteria->compare('feed_id', $this->feed_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('begin_date', $this->begin_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('location_id', $this->location_id);
		$criteria->compare('code', $this->code, true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('pay_id', $this->pay_id);
		$criteria->compare('fee_pay_id', $this->fee_pay_id);
		$criteria->compare('fee_payed', $this->fee_payed);
		$criteria->order = "begin_date DESC";
		$criteria->limit = $limit;
		
	
		return self::model()->findAll($criteria);
	}	
	
	
	public function search() {
		$criteria = new CDbCriteria;
	
		$criteria->compare('feed_id', $this->feed_id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('begin_date', $this->begin_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('location_id', $this->location_id);
		$criteria->compare('code', strtoupper( $this->code ) );
		$criteria->compare('status', $this->status, true);
		$criteria->compare('pay_id', $this->pay_id);
		$criteria->compare('fee_pay_id', $this->fee_pay_id);
		$criteria->compare('fee_payed', $this->fee_payed);
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
				'sort'=>array(
		            'defaultOrder'=>'fee_pay_id DESC',
		        ),
		));
	}
	
}