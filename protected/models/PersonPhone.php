<?php

Yii::import('application.models._base.BasePersonPhone');

class PersonPhone extends BasePersonPhone
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = array();		
		$rules[] = array('prefix', 'length', 'max'=>4);
		$rules[] = array('number', 'length', 'max'=>7);
		$rules[] = array('number, prefix', 'numerical', 'integerOnly'=>true);
		return CMap::mergeArray($rules, parent::rules());
	}
	
}