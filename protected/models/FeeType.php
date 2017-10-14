<?php

Yii::import('application.models._base.BaseFeeType');

class FeeType extends BaseFeeType
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = parent::rules();
		$rules[] = array('value', 'type', 'type'=>'float');

		return $rules;
	}
	
	

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('summary', $this->summary, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('value', $this->value, true);
		$criteria->compare('active', $this->active);
		$criteria->compare('is_regular', $this->is_regular);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
			'sort'=>array(
		            'defaultOrder'=>'id DESC',
		     ),
		));
	}

}