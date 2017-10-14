<?php

Yii::import('application.models._base.BaseFee');

/**
 * 
 * @author astarot
 *
 * @property integer $id
 * @property string $name
 * @property string $summary
 * @property string $begin_date
 * @property string $end_date
 * @property string $value
 * @property integer $fee_type_id
 *
 * @property FeeType $feeType
 * @property FeePay[] $feePays
 */
class Fee extends BaseFee
{
	
	/**
	 * 
	 * @param system $className
	 * @return Ambigous <CActiveRecord, unknown, multitype:>
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * 
	 * @return string
	 */
	public function getFullReference()
	{
		return $this->name;
	}
	
	
	/**
	 * (non-PHPdoc)
	 * @see BaseFee::attributeLabels()
	 */
	public function attributeLabels() {
		return array(
				'id' => Yii::t('app', 'ID'),
				'name' => Yii::t('app', 'Name'),
				'summary' => Yii::t('app', 'Summary'),
				'begin_date' => Yii::t('app', 'Begin Date'),
				'end_date' => Yii::t('app', 'End Date'),
				'value' => Yii::t('app', 'Value'),
				'fee_type_id' => Yii::t('app', 'Fee Type'),
				'feeType' => null,
				'feePays' => null,
		);
	}	
	

	/**
	 *  Obtiene las Cuotas asociadas al Pago
	 * @param integer $pay_id
	 */
	public static function getAmountFeeCanceledByPay($pay_id)
	{
		$criteria = new CDbCriteria();
		$criteria->params = array();
		$criteria->join = " INNER JOIN " . FeePay::model()->tableName() . " fp ";
		$criteria->join .=" ON ( fp.fee_id = t.id AND fp.pay_id = :pay_id )";
		$criteria->params[":pay_id"] = $pay_id;		
		$fees =  self::model()->findAll($criteria);
		
		$amount = 0;		
		/* @var $fee Fee */
		foreach( $fees as $fee )
		{
			$amount += $fee->value;
		}
		
		return $amount;
	}
	
	
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('begin_date', $this->begin_date, true);
		$criteria->compare('end_date', $this->end_date, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('fee_type_id', $this->fee_type_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
		            'defaultOrder'=>'id DESC',
		     ),
		));
	}



	public function rules(){
		$rules=parent::rules();
		$rules[]=array('begin_date','date','format'=>'yyyy-MM-dd');
		$rules[]=array('end_date','date','format'=>'yyyy-MM-dd');
		$rules[]=array('value','numerical');
		return $rules;
	}
	
}