<?php

Yii::import('application.models._base.BaseBankAccountEntry');

class BankAccountEntry extends BaseBankAccountEntry
{
    const CONST_TYPE_ENTRY_INCOME = 'I';
    const CONST_TYPE_ENTRY_OUTFLOW = 'O';
    const CONST_TYPE_ENTRY_BALANCE = 'B';


    
    /**
     * Verifica sies un ingreso
     * @return Bool
     */
    public function getIsIncome(){
        return $this->type == self::CONST_TYPE_ENTRY_INCOME;
    }
    
    /**
     * Verifica si es un Egreso
     * @return Bool
     */
    public function getIsOutcome(){
        return $this->type == self::CONST_TYPE_ENTRY_OUTCOME;
    }
    
    
    public static function model($className=__CLASS__) {
            return parent::model($className);
    }


    public function rules(){
        $rules = parent::rules();
        $rules[] = array('begin_date','compare','compareAttribute'=>'end_date','operator'=>'<=');

        $rules[] = array('type','typeValidate');

        return $rules;

   }


   public function typeValidate($attribute,$params){
       
        if( !(  $this->type == BankAccountEntry::CONST_TYPE_ENTRY_OUTFLOW ||  
                $this->type == BankAccountEntry::CONST_TYPE_ENTRY_INCOME ||  
                $this->type == BankAccountEntry::CONST_TYPE_ENTRY_BALANCE ) ){

                $this->addError($attribute, "type value not accepted, just 'I' or 'O'");

        }



   }

}