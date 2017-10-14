<?php

Yii::import('application.models._base.BaseAccountingMoveReference');

/**
 * 
 * @property integer $id
 * @property integer $move_line_id
 * @property string $type
 * @property string $label
 * @property string $value
 * @property string $created_at
 * @property string $updated_at
 *
 * @property AccountingMoveLine $id0
 * @property AccountingMoveRefType $type0
 */
class AccountingMoveReference extends BaseAccountingMoveReference
{
    
    
    /**
     * 
     * @param type $className
     * @return type
     */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    

    /**
     * 
     * @return type
     */
	public function rules() {
		return array(
			array('type, label, value, move_id, created_at', 'required'),
			array('move_id', 'numerical', 'integerOnly'=>true),
			array('type', 'length', 'max'=>8),
			array('label', 'length', 'max'=>64),
			array('value', 'length', 'max'=>16),
			array('updated_at, label, value', 'safe'),
			array('updated_at', 'default', 'setOnEmpty' => true, 'value' => null),
			array('id, type, label, value, move_id, created_at, updated_at', 'safe', 'on'=>'search'),
		);
	}
   
    
}