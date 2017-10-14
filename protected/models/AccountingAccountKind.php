<?php

Yii::import('application.models._base.BaseAccountingAccountKind');

/**
 * 
 *
 * @property string $key
 * @property string $title
 * @property string $created_at
 * @property string $updated_at
 * @property integer $deprecated
 *
 * @property AccountingAccount[] $accountingAccounts
 */
class AccountingAccountKind extends BaseAccountingAccountKind
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    

    /**
     * 
     * @return [[string=>string]]
     */
    public function rules() {
		return array(
			array('key, title, created_at', 'required'),
			array('deprecated, position', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>4),
			array('title', 'length', 'max'=>32),
			array('updated_at', 'safe'),
			array('updated_at, deprecated, position', 'default', 'setOnEmpty' => true, 'value' => null),
			array('key, title, created_at, updated_at, deprecated, position', 'safe', 'on'=>'search'),
		);
	}
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultOthers(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Others");
        $model->key = "0000";
        $model->position = "9999";
        return $model;
        
    }
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultView(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "View");
        $model->key = "1000";
        $model->position = "0";
        return $model;
        
    }
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultPayable(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Payable" );
        $model->key = "2000";
        $model->position = "1";
        return $model;
        
    }
    
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultReceivable(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Receivable" );
        $model->key = "3000";
        $model->position = "2";
        return $model;
        
    }
    
        
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultExpense(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Expense" );
        $model->key = "4000";
        $model->position = "3";
        return $model;
        
    }
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultRevenue(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Revenue" );
        $model->key = "5000";
        $model->position = "4";
        return $model;
        
    }
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultBank(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Bank" );
        $model->key = "6000";
        $model->position = "5";
        return $model;
        
    }
    
    
    /**
     * 
     * @return \AccountingAccountKind
     */
    public static function defaultCash(){
        $model = new AccountingAccountKind;
        $model->title = AccountingHelper::t( "Cash" );
        $model->key = "7000";
        $model->position = "6";
        return $model;
        
    }
    
    
    /**
     * 
     * @param boolean $withViewKind 
     * @return [AccountingAccountKind]
     */
    public static function getDefaults($withViewKind=true){
        $defaults = [];
        if($withViewKind){
            $defaults[] = self::defaultView();
        }
        
        $defaults[] = self::defaultPayable();
        $defaults[] = self::defaultReceivable();
        $defaults[] = self::defaultExpense();
        $defaults[] = self::defaultRevenue();  
        $defaults[] = self::defaultBank();
        $defaults[] = self::defaultCash();
        $defaults[] = self::defaultOthers();

        return $defaults;
    }
    
    
    
}