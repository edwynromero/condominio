<?php

Yii::import('application.models._base.BaseAccountingMoveLine');


/**
*
 * @property integer $id
 * @property integer $accounting_move_id
 * @property integer $accounting_account_id
 * @property integer $accounting_period_id
 * @property string $debt
 * @property string $credt
 * @property string $date_at
 * @property string $created_at
 * @property string $updated_at
 * @property integer $reconciled
 *
 * @property AccountingMove $accountingMove
 * @property AccountingAccount $accountingAccount
 * @property AccountingPeriod $accountingPeriod
 * 
 */
class AccountingMoveLine extends BaseAccountingMoveLine
{
        
    var $amount;
    var $accountingMoveDate;

    var $date_update;
    
    public $isCredit = null;
        
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
            'label' => AccountingHelper::t('Move Line Label'),
            'accounting_move_id' => Yii::t('app', 'AccountingMove'),
            'accounting_account_id' => AccountingHelper::t('app', 'Accounting Account'),
            'accounting_period_id' => Yii::t('app', 'AccountingPeriod'),
            'debt' => Yii::t('app', 'Debt'),
            'credt' => Yii::t('app', 'Credt'),
            'date_at' => Yii::t('app', 'Date At'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'reconciled' => Yii::t('app', 'Reconciled'),
            'accountingMove' => Yii::t('app', 'AccountingMove'),
            'accountingAccount' => null,
            'accountingPeriod' => null,
            'amount'=>Yii::t('app', 'amount'),
        );
    }


    /**
     * 
     * @return type
     */
    public function rules() {
        return array(
            array('accounting_account_id, accounting_period_id, debt, credt, date_at, reconciled, amount', 'required'),
            array('accounting_move_id, accounting_account_id, accounting_period_id, reconciled', 'numerical', 'integerOnly'=>true),
            array('label', 'length', 'max'=>128),
            array('debt, credt', 'length', 'max'=>10),
            array('updated_at, isCredit', 'safe'),
            array('label, updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
            array('id, label, accounting_move_id, accounting_account_id, accounting_period_id, debt, credt, date_at, created_at, updated_at, reconciled', 'safe', 'on'=>'search'),
            array('debt,credt', 'checkDebtAndCredt'),
            array('date_at', 'checkDateAt'),
            array('date_at', 'compare', 'compareAttribute'=>'accountingMoveDate', 'operator'=>'>=' ),
        );
    }
    
    
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkDateAt($attribute, $params){
        
        $atributeLabel = $this->attributeLabels()[$attribute];
        $begindate  = MipHelper::parseTimestampFromDateDb($this->accountingMove->date_at);
        $endDate    = MipHelper::parseTimestampFromDateDb($this->accountingPeriod->to);
        $date       = MipHelper::parseTimestampFromDateDb($this->date_at);
        
        $begindateOutput  = MipHelper::parseDateFromDb($this->accountingMove->date_at);
        $endDateOutput    = MipHelper::parseDateFromDb($this->accountingPeriod->from);

        if( !(  $begindate <= $date &&  $date <= $endDate ) ){
            $this->addError($attribute, AccountingHelper::t( 'The {attribute} has betwen {begindate} and {enddate}.', array('{attribute}' => $atributeLabel, '{begindate}' => $begindateOutput, '{enddate}'  => $endDateOutput )));  
            return false;
        }
        
    }    
    
    
    
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkDebtAndCredt($attribute, $params){

        $atributeLabel = $this->attributeLabels()[$attribute];
        if( is_null($this->isCredit)){

            $this->addError( $attribute,  AccountingHelper::t( 'Is required check the seat how Credit or Debit') );  
            return false;
        }
        
        if( $this->credt < 0 || $this->debt < 0  ){
            $this->addError("amount", AccountingHelper::t( 'The amount has been great what 0.00 (zero)') );  
            return false;  
        }

    }

    
    /**
     * 
     * @param type $id
     * @return \CActiveDataProvider
     */
    public function searchAccountingMoveLineDetail($id) {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('accounting_move_id', $id);
        $criteria->compare('accounting_account_id', $this->accounting_account_id);
        $criteria->compare('accounting_period_id', $this->accounting_period_id);
        $criteria->compare('debt', $this->debt, true);

                $criteria->compare('credt', $this->credt, true); 

        $criteria->compare('date_at', $this->date_at, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('reconciled', $this->reconciled);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    /**
     * 
     * @param integer $id  Accounting Account Id
     * @return \CActiveDataProvider
     */
    public function searchSeatsFromAccount($id, $pagination = null) {
        $criteria = new CDbCriteria;

        $criteria->compare('accounting_account_id', $id);
        $criteria->compare('accounting_period_id', $this->accounting_period_id);
        $criteria->compare('debt', $this->debt, true);

        $criteria->compare('credt', $this->credt, true); 

        $criteria->compare('date_at', $this->date_at, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('reconciled', $this->reconciled);
        
        $dataProvierParameters = array(
            'criteria' => $criteria,
        );
        
        if(!is_null($pagination)){
            $dataProvierParameters["pagination"] = $pagination;
        }

        return new CActiveDataProvider($this, $dataProvierParameters);
    }
    
    
     
}