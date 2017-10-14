<?php

Yii::import('application.models._base.BasePay');


/**
 * Pagos del Mirador
 * 
 * @property  $id Description
 * @property  $pay_date Description
 * @property  $value_cash Description
 * @property  $person_id Description
 * @property  $location_code_payed Description
 * @property  $safe Description
 * 
 */
class Pay extends BasePay
{
    
        const PAY_TYPE_CASH_LABEL = "Cash";
    
	public $actual_pay = 0;

	private $_actual_pay = null;
	private $_deferred_pay = null;
        
        
	
	
	/**
	 * 
	 * @param system $className
	 * @return Ambigous <CActiveRecord, unknown, multitype:>
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see BasePay::rules()
	 */
	public function rules() {
		return array(
				array('pay_date, value_cash, person_id', 'required'),
				array('person_id', 'numerical', 'integerOnly'=>true),
				array('value_cash', 'length', 'max'=>10),
				array('id, pay_date, value_cash, person_id, location_code_payed', 'safe', 'on'=>'search'),
				array('pay_date','date','format' => 'yyyy-MM-dd'),
				array('value_cash','numerical'),
		);
	}	
	
	
	/**
	 * (non-PHPdoc)
	 * @see BasePay::attributeLabels()
	 */
	public function attributeLabels() {		
		return CMap::mergeArray(parent::attributeLabels(), array(
			'actualPay' =>MipHelper::t("Actual Pay"),
			'deferredPay' =>MipHelper::t("Deferred Pay"),
		));
	}	
	
	/**
	 * 
	 * @return number
	 */
	public function getDeferredPay()
	{
		$this->populateInfoPay();
		return $this->_deferred_pay;
	}
	
	
	/**
	 * 
	 * @return number
	 */
	public function getActualPay()
	{
		$this->populateInfoPay();
		return $this->_actual_pay;
	}
	
	
	
	/**
	 * 
	 */
	public function getLocationsPayed()
	{
		
	}
	
	/**
	 * 
	 */
	private function populateInfoPay()
	{	
		if( is_null( $this->_deferred_pay ) || is_null( $this->_actual_pay ) )
		{
			$result = MipHelper::getPayNotCashInfoBalance($this->id);
			$this->_deferred_pay = $result["pay_unchecked"];
			$this->_actual_pay  = $result["pay_checked"] + $this->value_cash;
		}		
	}
	
	
	/**
	 * 
	 * @return string
	 */
	public function getFullReference()
	{
		return MipHelper::getPersonName( $this->person_id ) . " - " . MipHelper::parseDateFromDb( $this->pay_date ) . " - #" . $this->id ;
	}
	
	/**
	 * 
	 * @return number
	 */
	public function getValueNotCash($checked = false )
	{
		$criteria = new CDbCriteria();
		$criteria->condition = " pay_id = :pay_id ";
		
		$params = array(':pay_id'=>$this->id);
		
		if( !empty( $checked ) )
		{
			$criteria->condition .= " AND checked = :checked ";
			$params[':checked'] = $checked;
		}
		
		$criteria->params =  $params;
		
		$payNotCashInfos = PayNotCashInfo::model()->findAll($criteria);
		
		$valueNotCashChecked = 0;
		$valueNotCashNotChecked = 0;
		
		
		/* @var $payNotCashInfo PayNotCashInfo */
		foreach( $payNotCashInfos as $payNotCashInfo )
		{
			if( $payNotCashInfo->checked )
				$valueNotCashChecked += $payNotCashInfo->value;
			else 
				$valueNotCashNotChecked += $payNotCashInfo->value;
		}
		return array( 'checked'=>$valueNotCashChecked, 'unchecked' => $valueNotCashNotChecked );
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see BasePay::search()
	 */
	public function search() {
		$criteria = new CDbCriteria;
		$criteria->alias ="t";
		$criteria->join = "";
		$criteria->params = array();
	
		$criteria->compare('t.id', $this->id);
		
		$criteria->compare('value_cash', $this->value_cash, true);
		
		if( !empty($this->pay_date) )
		{			
			if( MipHelper::isValidDate($this->pay_date) )
			{
				$criteria->addCondition(" pay_date = :pay_date ");
				$criteria->params[":pay_date"] = MipHelper::parseDateToDb( $this->pay_date ) ;			
			}
			else
			{
				$criteria->addCondition(" DATE_FORMAT(pay_date, '%d/%m/%Y') LIKE (:pay_date) ");
				$criteria->params[":pay_date"] = $this->pay_date;
			}

		}
		
		if(!empty( $this->person_id ))
		{
			if( is_numeric( $this->person_id ))
			{				
				$criteria->join .= " INNER JOIN " . Person::model()->tableName() . " p ";
				$criteria->join .= " ON ( t.person_id = p.id AND  p.id = :person_id )";
				$criteria->params[":person_id"] = $this->person_id;				
			}	
			else
			{
				$person_name = strtoupper( $this->person_id );
				$criteria->join .= " INNER JOIN " . Person::model()->tableName() . " p ";
				$criteria->join .= " ON ( t.person_id = p.id AND ( ( UPPER(p.first_name) LIKE :person_name OR  UPPER(p.last_name) LIKE :person_name ) OR UPPER(p.full_name) LIKE :person_name ))";
				$criteria->params[":person_name"] = $person_name;
			}		
		}
		
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
    			'sort'=>array(
    					'defaultOrder'=>'pay_date DESC',
    			)
		));
	}	
	
}