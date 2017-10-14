<?php

Yii::import('application.models._base.BaseLocationGeometry');

class LocationGeometry extends BaseLocationGeometry
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}