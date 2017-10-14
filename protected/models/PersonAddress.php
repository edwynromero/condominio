<?php

Yii::import('application.models._base.BasePersonAddress');

class PersonAddress extends BasePersonAddress
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}