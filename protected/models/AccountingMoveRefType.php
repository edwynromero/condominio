<?php

Yii::import('application.models._base.BaseAccountingMoveRefType');


/**
 * This is the model base class for the table "mip_accounting_move_ref_type".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "AccountingMoveRefType".
 *
 * Columns in table "mip_accounting_move_ref_type" available as properties of the model,
 * followed by relations of table "mip_accounting_move_ref_type" available as properties of the model.
 *
 * @property string $key
 * @property string $title
 * @property string $associated_name
 *
 * @property MipAccountingMove[] $mipAccountingMoves
 */
class AccountingMoveRefType extends BaseAccountingMoveRefType
{
    private static $_defaultManually = null;
    private static $_defaultBySystem= null;
    
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
    
    
    /**
     * Tipo de Referencia de Movimiento Contable
     * 
     * @return \AccountingMoveRefType
     */
    public static function defaultManually(){
       
        if( is_null(self::$_defaultManually) ){
            
            self::$_defaultManually = new AccountingMoveRefType();
            self::$_defaultManually->key = "MAN-001";
            self::$_defaultManually->title = "MANUAL INPUT";
            self::$_defaultManually->associated_name = " -- CAN'T EMPTY -- "; 
        }

        
        return self::$_defaultManually;
        
    }
    
    /**
     * Tipo de Referencia de Movimiento Contable
     * 
     * @return \AccountingMoveRefType
     */
    public static function defaultBySystem(){
       
        if( is_null(self::$_defaultBySystem) ){
            
            self::$_defaultBySystem = new AccountingMoveRefType();
            self::$_defaultBySystem->key = "SYS-001";
            self::$_defaultBySystem->title = "GENERATE BY SYSTEM";
            self::$_defaultBySystem->associated_name = "Automatically Generated by System"; 
        }

        
        return self::$_defaultBySystem;
        
    }
    
    
    /**
     * Obtiene los tipos de Referencia por Defecto del Sistema
     * 
     * @return [/AccountingMoveRefType]
     */
    public static function getDefaults(){
        $defaults = array();
        $defaults[self::defaultBySystem()->key] = self::defaultBySystem();
        $defaults[self::defaultManually()->key] = self::defaultManually();
        return $defaults;
    }
    
    
}