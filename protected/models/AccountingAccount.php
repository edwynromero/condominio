<?php

Yii::import('application.models._base.BaseAccountingAccount');


/**
 * 
 * Columns in table "mip_accounting_account" available as properties of the model,
 * followed by relations of table "mip_accounting_account" available as properties of the model.
 *
 * @property integer $id
 * @property integer $parent_account_id
 * @property string $type
 * @property integer $code
 * @property string $label
 * @property string $created_at
 * @property string $updated_at
 * @property string $access_key
 * @property string $kind
 * @property string $note
 *
 * @property AccountingAccount $parentAccount
 * @property AccountingAccount[] $accountingAccounts
 * @property AccountingAccountKind $kind0
 * @property AccountingAccountType $type0
 * @property AccountingAlias[] $accountingAliases
 * @property AccountingMoveLine[] $accountingMoveLines
 */
class AccountingAccount extends BaseAccountingAccount
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
     * @return [string]
     */
    public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'parent_account_id' => null,
			'type' => null,
			'code' => Yii::t('app', 'Code'),
			'label' => Yii::t('app', 'Label'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'access_key' => Yii::t('app', 'Access Key'),
			'kind' => Yii::t('app', 'Internal Type'),
			'note' => AccountingHelper::t('Note'),
			'deprecated' => AccountingHelper::t('Deprecated'),
			'parentAccount' => null,
			'accountingAccounts' => null,
			'kind0' => null,
			'type0' => null,
			'accountingAliases' => null,
			'accountingMoveLines' => null,
		);
	}


    /**
     * 
     * @return [string]
     */
    public function rules() {
        return array(
                array('type, code, label', 'required'),
                array('parent_account_id, code, deprecated', 'numerical', 'integerOnly'=>true),
                array('type, kind', 'length', 'max'=>4),
                array('label', 'length', 'max'=>45),
                array('code', 'length', 'max'=>10),
                array('code','numerical','min'=>1,'max'=>999999999,'tooSmall'=>AccountingHelper::t('The code is too Short (Min: 1).'),'tooBig'=>AccountingHelper::t('The code is too Long (Max: 999.999.999).')),
                array('access_key', 'length', 'max'=>6),
                array('updated_at, note, deprecated', 'safe'),
                array('parent_account_id, code, label, updated_at, access_key, kind, note, deprecated', 'default', 'setOnEmpty' => true, 'value' => null),
                array('id, parent_account_id, type, code, label, created_at, updated_at, access_key, kind, note, deprecated', 'safe', 'on'=>'search'),
                array('code, label', 'checkDuplicate'),
                array('kind', 'checkKind'),
                array('code','checkCodeStruct'),
            );
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function checkCodeStruct(){
     
        $parent_code = $this->parentAccount->code;
 
        if( substr( $this->code, 0, strlen( $parent_code ) )  == $parent_code ){
            return  true;
        }
                
        $this->addError("code", AccountingHelper::t("The code structure has begin with: " . $parent_code . ".")  );
        return false;
    }
    
    
    /**
     * 
     * @return boolean
     */
    public function checkKind(){
  
        if( count($this->accountingMoveLines) > 0 && $this->kind == AccountingAccountKind::defaultView()->key ){
             $this->addError("kind", AccountingHelper::t("The Account Kind can't be View Type because has seats associated.")  );
             return false;
        }
        
        if( $this->kind != AccountingAccountKind::defaultView()->key ){
            
            if( count($this->accountingAccounts)  > 0 ){
                $this->addError("kind", AccountingHelper::t("The account type can not be different from 'View' because you already have other accounts as daughters.")  );
                return false;
            }
            
        }
        
        return true;
    }
    
     /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkDuplicate($attribute, $params){

        $criteria = new CDbCriteria();
        $criteria->condition = $attribute.'=:'.$attribute;
        $criteria->params = array(':'.$attribute=>$this->$attribute );
        
        if( !$this->isNewRecord ){
            $criteria->condition        .=  ' AND id <> :id ';
            $criteria->params[':id']    =   $this->id;
        }
            
        if( count( AccountingAccount::model()->findAll($criteria) ) > 0 ){
            $this->addError($attribute, MipHelper::t( $this->attributeLabels()[$attribute] )." ".MipHelper::t('is repeat'));
            return false;
        }
        
        return true;
    }
    

    /**
     * 
     * @return string
     */
    public static function representingColumn() {
        return 'label';
    }
    
    
    /**
     * 
     * @return type
     */
    public function getCodeWithLabel(){
        return $this->code . " - " . $this->label;
    }

    /**
     * 
     * @return [AccountingAccount]
     */
    public static function findAllWithoutChildrens($order = "code ASC, label ASC"){

        $criteria = new CDbCriteria();
        $criteria->condition = "t.kind <> :kind_view AND id NOT IN ( SELECT DISTINCT
                                                                ac2.id
                                                        FROM 
                                                                mip_accounting_account acc1
                                                                                INNER JOIN       mip_accounting_account ac2 
                                                                                        ON ( acc1.parent_account_id = ac2.id  ) )";
        $criteria->order = $order;
        $criteria->params = array( ":kind_view" => AccountingAccountKind::defaultView()->key);
        return AccountingAccount::model()->findAll($criteria);
    }
    
    
    
    /**
     * 
     * @return [AccountingAccount]
     */
    public static function findAllAccountViews(){
        $criteria = new CDbCriteria();
        $criteria->order = "code ASC";
        $criteria->condition = 'kind = :kind';
        $criteria->params = array( ':kind'=> AccountingAccountKind::defaultView()->key ) ;

        return AccountingAccount::model()->findAll( $criteria );
        
    }
    
    
        /**
     * 
     * @return [AccountingAccount]
     */
    public static function findAllAccountNotViews(){
        $criteria = new CDbCriteria();
        $criteria->order = "code ASC";
        $criteria->condition = 'kind <> :kind';
        $criteria->params = array( ':kind'=> AccountingAccountKind::defaultView()->key ) ;

        return AccountingAccount::model()->findAll( $criteria );
        
    }
    
    
    
    /**
     * 
     */
    public function getChilds(){
        return  self::model()->findAll("parent_account_id = :parent_account_id", array(":parent_account_id"=>$this->id));  
    }
    
    /**
     * 
     */
    public function getBrothers(){
        return  self::model()->findAll("parent_account_id = :parent_account_id AND id <> :id", array(":parent_account_id"=>$this->parent_account_id, ":id"=>$this->id));  
    }
    
    
    /**
     * 
     * @return \CActiveDataProvider
     */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('parent_account_id', $this->parent_account_id);  
		$criteria->compare('type', $this->type);
		$criteria->compare('code', $this->code);
		$criteria->compare('UPPER(label)', strtoupper( $this->label ), true);
		$criteria->compare('created_at', $this->created_at, true);
		$criteria->compare('updated_at', $this->updated_at, true);
		$criteria->compare('access_key', $this->access_key, true);
		$criteria->compare('kind', $this->kind);
		$criteria->compare('note', $this->note, true);
		$criteria->compare('deprecated', $this->deprecated);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
         
}