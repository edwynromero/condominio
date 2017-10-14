<?php

Yii::import('application.models._base.BaseAuthAssignment');

class AuthAssignment extends BaseAuthAssignment
{
	
	public function tableName() {
		return 'mip_auth_assignment';
	}
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}