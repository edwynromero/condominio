<?php

Yii::import('application.models._base.BaseOwner');



/**
 * 
 * @property integer id Description
 * @property Location $location Description
 * @property integer $location_id Description
 */
class Owner extends BaseOwner
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules()
	{
		$rules = parent::rules();
		return CMap::mergeArray($rules, array(
			array('id, location_id, person_id, begin_date, end_date', 'safe', 'on'=>'searchPersonLocation'),
			array('id', 'safe', 'on'=>'insert'),
		));
		
	}
	
	public function searchPersonLocation() {
		$criteria = new CDbCriteria;
		$criteria->join = "";
		$criteria->params = array();

		if( !empty($this->location_id) )
		{
			$criteria->join .= " INNER JOIN " . Location::model()->tableName() . " l";
			$criteria->join .= " ON ( l.id = t.location_id )";			
			$criteria->addCondition(" UPPER(l.code) = UPPER( :location_code ) " );
			$criteria->params[":location_code"] =  $this->location_id;
		}
		
		if( !empty($this->person_id) )
		{
			if( is_numeric( $this->person_id ))
			{
				$criteria->compare('person_id', $this->person_id);
			}
			else
			{
				$criteria->join .= " INNER JOIN " . Person::model()->tableName() . " p";
				$criteria->join .= " ON ( p.id = t.person_id )";
				$criteria->addCondition(" UPPER( p.first_name ) LIKE :person_name OR UPPER( p.last_name ) LIKE :person_name OR UPPER( p.full_name ) LIKE :person_name " );
				$criteria->params[":person_name"] =  strtoupper( $this->person_id );
			}
		}				
	
		$criteria->compare('id', $this->id);
		$criteria->compare('begin_date', $this->begin_date, true);
		$criteria->compare('end_date', $this->end_date, true);
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}
}