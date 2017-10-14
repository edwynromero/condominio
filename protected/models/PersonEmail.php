<?php

Yii::import('application.models._base.BasePersonEmail');

class PersonEmail extends BasePersonEmail
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}