<?php

Yii::import('application.models._base.BaseFiscalYear');

class FiscalYear extends BaseFiscalYear
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
        
        
        
        public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'label' => Yii::t('app', 'Label'),
			'from' => Yii::t('app', 'From'),
			'to' => Yii::t('app', 'To'),
			'created_at' => Yii::t('app', 'Created At'),
			'updated_at' => Yii::t('app', 'Updated At'),
			'is_closed' => Yii::t('app', 'Is Closed'),
			'status' => Yii::t('app', 'Status'),
			'accountingPeriods' => null,
			'status0' => null,
		);
	}
        
        
        
        
        public function rules() {
		return array(
			array('label, from, to, is_closed, status', 'required'),
			array('is_closed', 'numerical', 'integerOnly'=>true),
			array('label', 'length', 'max'=>64),
			array('status', 'length', 'max'=>4),
			array('updated_at', 'safe'),
			array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, label, from, to, created_at, updated_at, is_closed, status', 'safe', 'on'=>'search'),
			array('to', 'compare','compareAttribute'=>'from','operator'=>'>='),  
		);
	}
}