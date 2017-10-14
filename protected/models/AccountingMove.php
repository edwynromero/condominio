<?php

Yii::import('application.models._base.BaseAccountingMove');


/**
 * 
 *
 * @property integer $id
 * @property string $label
 * @property string $date_at
 * @property string $created_at
 * @property string $updated_at
 * @property string $status
 *
 * @property AccountingMoveStatus $status0
 * @property AccountingMoveLine[] $accountingMoveLines
 * @property AccountingMoveReference[] $accountingMoveReferences
 * @property AccountingMove $original Original Data from Model
 */
class AccountingMove extends BaseAccountingMove
{
    
    private $_failedOnClose = false;
    private $_original = null;
    
    
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
       
    
	public function attributeLabels() {
		return array(
			'id' => null,
			'journal_id' => AccountingHelper::t('Journal'),
			'label' => Yii::t('app', 'Label'),
			'date_at' => Yii::t('app', 'Date At'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'status' => Yii::t('app', 'Status'),
			'id0' => null,
			'status0' => null,
			'accountingMoveLines' => Yii::t('app', 'Accounting Move Lines'),
		);
	}


	public function rules() {
		return array(
			array('journal_id, label, date_at, created_at, status', 'required'),
			array('journal_id', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>128),
			array('status', 'length', 'max'=>4),
			array('updated_at', 'safe'),
			array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, journal_id, label, date_at, created_at, updated_at, status', 'safe', 'on'=>'search'),
            array('date_at', 'checkCanChangeDate'),
		);
	} 
    
    
        
    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('label', $this->label, true);
        $criteria->compare('date_at', $this->date_at, true);
        $criteria->compare('created_at', $this->created_at, true);
        $criteria->compare('updated_at', $this->updated_at, true);
        $criteria->compare('status', $this->status);


        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }
    
    
    /**
     * 
     * @return /AccountingMove
     */
    public function getOriginal(){
        if( is_null($this->_original) ){
            $this->_original = self::model()->findByPk( $this->id );
        }
        return is_null($this->_original)?$this:$this->_original ;
    }
    

    /**
     * 
     * @param string $attribute
     * @param string $params
     */
    public function checkCanChangeDate($attribute, $params){
        
        
        if( $this->original->date_at != $this->date_at  ){

            if( count($this->original->accountingMoveLines) > 0){
                $this->date_at = $this->original->date_at;
                $this->addError($attribute, AccountingHelper::t( "The date can't be changed why the object has at least one accounting seat." ));  
                return false;
            }

        }
        return true;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function checkCanBeClosed(){
        
        $debt = 0;
        $credt = 0;
        
        /** @var $accountingSeat AccountingMoveLine  */
        foreach($this->accountingMoveLines as $accountingMoveLine){
            $debt += $accountingMoveLine->debt;
            $credt += $accountingMoveLine->credt;
        }
        
        return ($debt == $credt);
    }
    
    
    
    /**
     * 
     * @return boolean
     */
    public function getFailedOnClose(){
    
        return $this->_failedOnClose;
    }
    

	/**
     * 
     * @return boolean
     */
    public function beforeSave() {
        
        $this->_failedOnClose = false;

        if( !$this->isNewRecord ){
            
            $original = $this->getOriginal();
            
            if(  AccountingMoveStatus::canCloseStatusKey( $original->status,  $this->status ) || AccountingMoveStatus::canConciliateStatusKey( $original->status,  $this->status ) ){
                if(!$this->checkCanBeClosed()){
                    $this->_failedOnClose = true;
                    $this->addError("status", AccountingHelper::t( "Can't be closed or conciliated why seats don't fit.") );
                }
            }
            return !$this->_failedOnClose && parent::beforeSave();
        }

        return parent::beforeSave();
    }
           
}