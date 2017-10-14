<?php

Yii::import('application.models._base.BaseBank');

class Bank extends BaseBank
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}