<?php

Yii::import('application.models._base.BaseBankAccountSummary');


/**
 * 
 */
class BankAccountSummary extends BaseBankAccountSummary
{
    const YEAR_MIN=2013;
    const MONTH_MIN=1;
    const MONTH_MAX=12;
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }
    
    
    /**
     * 
     * @return int
     */
    public static function getYearMax(){
        return date ("Y");
    }
    

    public function rules() {
            return array(
                    array('month, year, bank_account_id', 'required'),
                    array('month, year, bank_account_id', 'numerical', 'integerOnly'=>true),
                    array('data, file_name, bank_account_id', 'safe'),
                    array('data, file_name', 'default', 'setOnEmpty' => true, 'value' => null),
                    array('id, month, year, data, file_name, bank_account_id', 'safe', 'on'=>'search'),
                    array('year', 'checkUniqueness'),
                    array('year','yearValidate'),
                    array('month','monthValidate'),
            );
    }


    public function yearValidate($attribute, $params){
        if(($this->year < BizLogic::getBankAccountSummaryMinYear() )||($this->year > BankAccountSummary::getYearMax() )){

            $this->addError($attribute, "Year invalid");

        }
    }



    public function monthValidate($attribute, $params){
        if((($this->month < BankAccountSummary::MONTH_MIN) || ($this->month > BankAccountSummary::MONTH_MAX))){
            $this->addError($attribute, "month invalid");
        }
    }
    
    
 
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkUniqueness($attribute,$params)
    {
        $checkUniqueness = false;
        
        $model = self::model()->find(" month = :month AND year = :year ", array(":month" => $this->month, ":year" => $this->year ));
        
        if( $model != null && !$model->isNewRecord )
        {
            if($model->id == $this->id)
            {
               return true;
            }
        }
        else if($model == null)
        {
            return true;
        }
        
        $this->addError('id','This Month and Year already exist');
        return $checkUniqueness;
         
    }
    
}