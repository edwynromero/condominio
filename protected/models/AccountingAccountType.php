<?php

Yii::import('application.models._base.BaseAccountingAccountType');

class AccountingAccountType extends BaseAccountingAccountType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('`key`', $this->key, true);
		$criteria->compare('label', $this->label, true);
		$criteria->compare('is_debt', $this->is_debt);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
        
        
        
        public function rules() {
		return array(
			array('key, label, is_debt', 'required'),
			array('is_debt', 'numerical', 'integerOnly'=>true),
			array('key', 'length', 'max'=>4),
			array('label', 'length', 'max'=>64),
			array('key, label, is_debt', 'safe', 'on'=>'search'),
                        array('key','checkKey', 'on'=>'create'),
                        array('label','checkLabel', 'on'=>'create'),
                        array('key','checkKey', 'on'=>'keyRepeat'),
                        array('label','checkLabel', 'on'=>'labelRepeat'),
		);
	}
        
        
        public function checkLabel($attribute, $params){
               
                
                $number= AccountingAccountType::model()->find('label=:label',array(':label'=>$this->label));
                
                
                if(count($number)){
                 $this->addError($attribute, MipHelper::t('Label')." ".MipHelper::t('is repeat'));
                }
        }
        
        
        
        public function checkKey($attribute, $params){
               
                
                $number= AccountingAccountType::model()->find('`key`=:key',array(':key'=>$this->key));
                
                
                if(count($number)){
                 $this->addError($attribute, MipHelper::t('key')." ".MipHelper::t('is repeat'));
                }
        }
        
        
        
        
        
}