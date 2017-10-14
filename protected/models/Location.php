<?php

Yii::import('application.models._base.BaseLocation');

class Location extends BaseLocation
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	
	public function search() {
		$criteria = new CDbCriteria;
	
		$criteria->compare('id', $this->id);
		$criteria->compare('UPPER(code)', strtoupper($this->code) , true);
		$criteria->compare('status', $this->status, true);
		$criteria->compare('initial_debt', $this->initial_debt, true);
		$criteria->compare('is_built', $this->is_built);
		$criteria->compare('comments', $this->comments, true);
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}	
	
	
	
	/**
	 * Obtiene la deuda actual de la Parcela
	 * @return number
	 */
	public function getCurrentDebt()
	{
		
		$criteria = new CDbCriteria();
		
		
		
		
		return 1000.65;
	}




	public function rules(){

		$rules=  parent::rules();
		$rules[]=array('initial_debt','numerical');
		$rules[]=array('is_built','is_builtValidate');
		return $rules;

	}


	public function is_builtValidate($attribute, $params){

		if(($this->is_built<0)||($this->is_built>1)){

			$this->addError($attribute,"campo 'es construido' invalido");
		}


	}
	
}