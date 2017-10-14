<?php

Yii::import('application.models._base.BaseAccountingJournalType');


/**
 * 
 * Columns in table "mip_accounting_journal_type" available as properties of the model,
 * followed by relations of table "mip_accounting_journal_type" available as properties of the model.
 *
 * @property string $key
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property integer $deprecated
 *
 * @property AccountingJournal[] $accountingJournals
 */
class AccountingJournalType extends BaseAccountingJournalType
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
     * @return \AccountingJournalType
     */
    public static function defaultTypeSale(){

        $type = new AccountingJournalType();
        $type->key = "J010";
        $type->title = "Sale";
        $type->deprecated = 0;
        return $type;
    }
    
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeIncome(){

        $type = new AccountingJournalType();
        $type->key = "J011";
        $type->title = "Income";
        $type->deprecated = 0;
        return $type;
    }

    
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypePurchase(){

        $type = new AccountingJournalType();
        $type->key = "J020";
        $type->title = "Purchase";
        $type->deprecated = 0;
        return $type;
    }
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeExpense(){

        $type = new AccountingJournalType();
        $type->key = "J021";
        $type->title = "Expense";
        $type->deprecated = 0;
        return $type;
    }

    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeCash(){

        $type = new AccountingJournalType();
        $type->key = "J030";
        $type->title = "Cash";
        $type->deprecated = 0;
        return $type;
    }
    
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeGeneral(){

        $type = new AccountingJournalType();
        $type->key = "J040";
        $type->title = "General";
        $type->deprecated = 0;
        return $type;
    }
    
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeSituation(){

        $type = new AccountingJournalType();
        $type->key = "J050";
        $type->title = "Situation";
        $type->deprecated = 0;
        return $type;
    }
    
    
    /**
     * 
     * @return \AccountingJournalType
     */
    public static function defaultTypeBank(){

        $type = new AccountingJournalType();
        $type->key = "J060";
        $type->title = "Bank";
        $type->deprecated = 0;
        return $type;
    }
    
    
    /**
     * 
     * @return array
     */
    public static function getDefaults(){
        
        $defaults = array();
        $defaults[] = self::defaultTypePurchase();
        $defaults[] = self::defaultTypeExpense();
        $defaults[] = self::defaultTypeSale();
        $defaults[] = self::defaultTypeIncome();
        $defaults[] = self::defaultTypeBank();
        $defaults[] = self::defaultTypeCash();
        $defaults[] = self::defaultTypeSituation();
        $defaults[] = self::defaultTypeGeneral();
        return $defaults;
        
    }
    
    
    /**
     * 
     * @return string
     */
    public function getLabel(){
        return AccountingHelper::t($this->title);
    }
    
}