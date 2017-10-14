<?php

Yii::import('application.models._base.BasePerson');


/**
 * This is the model class for the table "mip_person".
 *
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $full_name
 * @property string $identity_code
 * @property string $identity_type
 * @property integer $active
 * @property string $inactive_description
 * @property integer $group_person_id
 *
 * @property GroupPerson $groupPerson
 */
class Person extends BasePerson
{
	const IDENTITY_TYPE_COMPANY = "J";
	const IDENTITY_TYPE_GOVERN 	= "G";
	const IDENTITY_TYPE_FIRM 	= "F";
	const IDENTITY_TYPE_FOREIGN	= "E";
	const IDENTITY_TYPE_NATIVE	= "V";
	const NAME_NOT_DEFINED 		= "S/N";
        
        		
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 * @param unknown_type $identity_status
	 */
	public static function checkIsNotCompany($identity_status)
	{
		return ($identity_status == Person::IDENTITY_TYPE_NATIVE || $identity_status == Person::IDENTITY_TYPE_FOREIGN ||$identity_status == Person::IDENTITY_TYPE_FIRM);
	}
	
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function getIsNotCompany()
	{
		return self::checkIsNotCompany($this->identity_type);
	}
	
	
	
	/**
	 * Informacion en las Listas
	 * @return string
	 */
	public function getFullNameList()
	{
		if( self::checkIsNotCompany($this->identity_type) )
		{
			return $this->first_name . ", " . $this->last_name;
		}		
		return $this->full_name;
	}
        
        	
	/**
	 * Informacion en las Listas
	 * @return string
	 */
	public function getFullNameListDNI()
	{
		if( self::checkIsNotCompany($this->identity_type) )
		{
			return $this->first_name . ", " . $this->last_name;
		}		
		return $this->full_name;
	}
	
	/**
	 * Informacion en las Listas
	 * @return string
	 */
	public function getFullNameEmail()
	{
		if( self::checkIsNotCompany($this->identity_type) )
		{
			return $this->first_name . " " . $this->last_name;
		}
		return $this->full_name;
	}
	
	
	public function attributeLabels() {
		return array(
				'id' => Yii::t('app', 'ID'),
				'first_name' => Yii::t('app', 'First Name'),
				'last_name' => Yii::t('app', 'Last Name'),
				'full_name' => Yii::t('app', 'Full Name'),
				'identity_code' => Yii::t('app', 'Identity Code'),
				'identity_type' => Yii::t('app', 'Identity Type'),
				'active' => Yii::t('app', 'Active'),
				'inactive_description' => Yii::t('app', 'Inactive Description'),
				'group_person_id' =>  Yii::t('app', 'Family/Company'),
				'groupPerson' => Yii::t('app', 'Family/Company'),
		);
	}	
	
	
	/**
	 * Informacion del Documento de Identidad
	 * @return string
	 */
	public function getFullIdentity()
	{
		return $this->identity_type . "-" . $this->identity_code;
	}
	
	
	public function searchToAdmin() {
		
		
		$criteria = new CDbCriteria;
		$criteria->params = array();
		
		$criteria->join = "";
				
		$criteria->compare('id', $this->id);
		
		/**
		 *  Se incorpora la búsqueda combinando nombres, apellidos y nombres de empresas 
		 */
		if( !empty($this->first_name))
		{
			$criteria->addCondition('LOWER( first_name ) LIKE :full_name_list OR LOWER( last_name ) LIKE :full_name_list OR LOWER( full_name ) LIKE :full_name_list');
			$criteria->params[':full_name_list'] = '%' . strtolower($this->first_name) . '%';
		}
		
		/**
		 *   Se incorpora la busqueda combinando el tipo de identidad y el codigo
		 */
		if( !empty($this->identity_code))
		{
			$criteria->addCondition(" CONCAT( LOWER(identity_type),'-', LOWER(identity_code)) LIKE :identity_list  ");
			$criteria->params[':identity_list'] = '%' . strtolower($this->identity_code) . '%';
		}
		
		if( !empty($this->group_person_id) )
		{
			$criteria->join = 'INNER JOIN ' . GroupPerson::model()->tableName() . ' g ON ( t.group_person_id = g.id AND LOWER( g.name )  LIKE  :group_name )';
			$criteria->params[':group_name'] = '%' . strtolower( $this->group_person_id ) . '%';
		}
		
		if( !empty($this->active) )
		{
			$criteria->addCondition(" t.active = :active ");
			$criteria->params[':active'] =  $this->active;
		}
	
	
		return new CActiveDataProvider($this, array(
				'criteria' => $criteria,
		));
	}

	
}