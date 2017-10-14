<?php

Yii::import('application.models._base.BaseAccountingPeriodStatus');


/**
 *   
 * 
 * 
 * @property string $key
 * @property string $label
 * @property integer $at_year
 * @property integer $at_period
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AccountingPeriod[] $accountingPeriods
 * @property FiscalYear[] $fiscalYears
 */
class AccountingPeriodStatus extends BaseAccountingPeriodStatus
{	
	var $checkAtYearOrAtPeriod;

    
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
     * @return \CActiveDataProvider
     */
    public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('`key`', $this->key, true);
		$criteria->compare('label', $this->label, true);
		$criteria->compare('at_year', $this->at_year);
		$criteria->compare('at_period', $this->at_period);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
        
        
    /**
     * 
     * @return type
     */
    public function rules() {
		return array(
			array('key, label, at_year, at_period', 'required'),
			array('at_year, at_period', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>4),
			array('label', 'length', 'max'=>64),
			array('updated_at', 'safe'),
			array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('key, label, at_year, at_period, created_at, updated_at', 'safe', 'on'=>'search'),
            array('key','checkKey', 'on'=>'create'),
            array('key','checkKey', 'on'=>'keyRepeat'),
            array('label','checkLabel', 'on'=>'create'),
            array('label','checkLabel', 'on'=>'labelRepeat'),
            array('checkAtYearOrAtPeriod', 'checkAtYearOrAtPeriod'),
		);
	}
        
        
    /**
     * 
     * @param type $attribute
     * @param type $params
     */        
    public function checkKey($attribute, $params){

        $number= AccountingPeriodStatus::model()->find('`key`=:key',array(':key'=>$this->key));


        if(count($number)){
         $this->addError($attribute, MipHelper::t('Key')." ".MipHelper::t('is repeat'));
        }
    }

    
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkLabel($attribute, $params){

        $number = AccountingPeriodStatus::model()->find('label=:label',array(':label'=>$this->label));
        if(count($number)){
         $this->addError($attribute, MipHelper::t('Label')." ".MipHelper::t('is repeat'));
        }

    }
        

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkAtYearOrAtPeriod($attribute, $params){

        if($this->checkAtYearOrAtPeriod){
            $this->addError($attribute , MipHelper::t('Is required year or period'));
        }
    }

    
    /**
     * 
     * @return [/AccountingPeriodStatus]
     */
    public static function getDefaults(){
        $statusCollection = array();
        $statusCollection[] = self::defaultStatusOpen();
        $statusCollection[] = self::defaultStatusClosed();
        return $statusCollection;
    }
    
    
    /**
     *  Estatus por Abierto
     */
    public static function defaultStatusOpen(){
        return self::createDefaultStatus("ST01", "Open");
    }
    
    
    /**
     *  Estatus Cerrado
     */
    public static function defaultStatusClosed(){
        return self::createDefaultStatus("ST98", "Closed");
    }
    
    
    /**
     * 
     * @param string $key
     * @param string $label
     * @return \AccountingPeriodStatus
     */
    public static function createDefaultStatus($key, $label){
        $status             =   new AccountingPeriodStatus();
        $status->key        =   $key;
        $status->label      =   $label; 
        $status->at_period  =   1;
        $status->at_year    =   1;
        $status->updated_at =   MipHelper::getCurrentTimeStampDateDb();
        return $status;
    }

        
}