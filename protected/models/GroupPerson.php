<?php

Yii::import('application.models._base.BaseGroupPerson');

class GroupPerson extends BaseGroupPerson
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	public function rules()
	{
		$rules = parent::rules();
		return CMap::mergeArray($rules, array(
			array('id, name, type, active', 'safe', 'on'=>'searchWithType'),
		));
	}
	
	
	public function searchWithType()
	{
		$criteria = new CDbCriteria;
		
		$criteria->compare('id', $this->id);
		$criteria->compare('name', $this->name, true);
		
		$criteria->compare('type', $this->type, true);
		
		$criteria->compare('active', $this->active);
		
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}
}