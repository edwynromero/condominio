<?php

Yii::import('application.models._base.BaseAccountingPeriod');

/**
 * 
 * 
 * @property integer $id
 * @property string $label
 * @property string $from
 * @property string $to
 * @property integer $fiscal_year_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property AccountingMoveLine[] $accountingMoveLines
 * @property FiscalYear $fiscalYear
 * @property AccountingPeriodStatus $status0
 */
class AccountingPeriod extends BaseAccountingPeriod
{
    
    /**
     * 
     * @param type $className
     * @return type
     */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        
        
    /**
     * 
     * @return type
     */
    public function attributeLabels() {
    return array(
        'id' => Yii::t('app', 'ID'),
        'label' => Yii::t('app', 'Label'),
        'from' => Yii::t('app', 'From'),
        'to' => Yii::t('app', 'To'),
        'fiscal_year_id' => Yii::t('app', 'fiscalYear'),
        'created_at' => Yii::t('app', 'Created At'),
        'updated_at' => Yii::t('app', 'Updated At'),
        'status' => Yii::t('app', 'Status'),
        'accountingMoveLines' => null,
        'fiscalYear' => null,
        'status0' => null,
    );
	}
        
        
        
    /**
     * 
     * @return type
     */
    public function rules() {
    return array(
        array('label, from, to, fiscal_year_id, status', 'required'),
        array('fiscal_year_id', 'numerical', 'integerOnly'=>true),
        array('label', 'length', 'max'=>64),
        array('status', 'length', 'max'=>4),
        array('updated_at', 'safe'),
        array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
        array('id, label, from, to, fiscal_year_id, created_at, updated_at, status', 'safe', 'on'=>'search'),
                    array('label','checkLabel', 'on'=>'create'),
                    array('label','checkLabel', 'on'=>'labelRepeat'),
         array('from','date','format'=>'yyyy-MM-dd'),
         array('to','date', 'format'=>'yyyy-MM-dd'),  
         array('to', 'compare','compareAttribute'=>'from','operator'=>'>='),        
    );
	}
        
        
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkLabel($attribute, $params){

        $number = AccountingPeriod::model()->find('label=:label',array(':label'=>$this->label));
        if(count($number)){
         $this->addError($attribute, MipHelper::t('Label')." ".MipHelper::t('is repeat'));
        }
   }
   
   
   
   /**
    * 
    * @param string $label
    * @param string $from
    * @param string $to
    * @param string $status
    * @param integer $fiscalYear
    * @return \AccountingPeriod
    */
   public static function create($label, $from, $to, $status, $fiscalYear ){
       
        $period                 = new AccountingPeriod();
        $period->label          = $label;
        $period->from           = $from;
        $period->to             = $to;
        $period->status         = $status;
        $period->fiscal_year_id = $fiscalYear->id;
        $period->created_at     = MipHelper::getCurrentTimeStampDateDb();
        $period->updated_at     = MipHelper::getCurrentTimeStampDateDb();
       
       return $period;
   }
        
        
}