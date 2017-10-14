<?php

Yii::import('application.models._base.BaseAccountingAlias');


/**
 * Alias de las Cuentas Contables
 */
class AccountingAlias extends BaseAccountingAlias
{
        
    var $update;    
        
        
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        
    public function search() {
        
		$criteria = new CDbCriteria;

        $criteria->compare('`key`', $this->key, true);
		$criteria->compare('account_id', $this->account_id);
		$criteria->compare('label', $this->label, true);
		$criteria->compare('alias', $this->alias, true);
                
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
        
        
        
        
    public function rules() {
        return array(
          array('key, account_id, label', 'required'),
          array('account_id', 'numerical', 'integerOnly'=>true),
          array('key', 'length', 'max'=>6),
          array('label, alias', 'length', 'max'=>64),
          array('alias', 'default', 'setOnEmpty' => true, 'value' => null),
          array('key, account_id, label, alias', 'safe', 'on'=>'search'),
          array('key','checkKey','on'=>'create'),
          array('alias','required'),                         

        );   
	}
        
        
        
    public function checkKey($attribute, $params){


        $number= AccountingAlias::model()->find('`key`=:key',array(':key'=>$this->key));


        if(count($number)){
         $this->addError($attribute, MipHelper::t('Key')." ".MipHelper::t('is repeat'));
        }
    }


}