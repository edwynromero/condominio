<?php

Yii::import('application.models._base.BaseAccountingMoveStatus');


/**
 * Estatus Mivimientos Contables
 * 
 * 
 * @property string $key
 * @property string $label
 *
 * @property AccountingMove[] $accountingMoves
 */
class AccountingMoveStatus extends BaseAccountingMoveStatus
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
     * @param string $before Estatus antes de Cerrar
     * @param string $after Estatus despues Cerrar
     * 
     * @return bool
     */
    public static function canCloseStatusKey($before, $after){
        return  ( $before == self::defaultStatusOpen()->key || $before == self::defaultStatusConciliated()->key )  && $after == self::defaultStatusClosed()->key;
    }
    
    /**
     * 
     * @param string $before Estatus antes de Conciliar
     * @param string $after Estatus despues Conciliar
     * 
     * @return bool
     */
    public static function canConciliateStatusKey($before, $after){
        return  ( $before == self::defaultStatusOpen()->key || $before == self::defaultStatusClosed()->key )  && $after == self::defaultStatusConciliated()->key;
    }
        
    
    /**
     * 
     * @return \CActiveDataProvider
     */
    public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('`key`', $this->key, true);
		$criteria->compare('label', $this->label, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
    
    
    /**
     *  Estatus por Abierto
     */
    public static function defaultStatusOpen(){
        $status         =   new AccountingMoveStatus();
        $status->key    =   "EM01";
        $status->label  =   "Open";    
        return $status;
    }
    
    /**
     *  Estatus Cerrado
     */
    public static function defaultStatusClosed(){
        $status         =   new AccountingMoveStatus();
        $status->key    =   "EM98";
        $status->label  =   "Closed";    
        return $status;
    }
    
    /**
     *  defaultStatusConciliated Conciliado
     */
    public static function defaultStatusConciliated(){
        $status         =   new AccountingMoveStatus();
        $status->key    =   "EM99";
        $status->label  =   "Conciliated"; 
        return $status;
    }
    
    /**
     * 
     * @return [/AccountingMoveStatus]
     */
    public static function getDefaults(){
        $statusCollection = array();
        $statusCollection[] = self::defaultStatusOpen();
        $statusCollection[] = self::defaultStatusClosed();
        $statusCollection[] = self::defaultStatusConciliated();
        return $statusCollection;
    }
    
    
    /**
     * 
     * @return [/AccountingMoveStatus]
     */
    public static function getDefaultsForUpdate(){
        $statusCollection = array();
        $statusCollection[] = self::defaultStatusOpen();
        $statusCollection[] = self::defaultStatusClosed();
        return $statusCollection;
    }


    /**
     * 
     * @return type
     */
    public function rules() {
		return array(
			array('key, label', 'required'),
			array('key', 'length', 'max'=>4),
			array('label', 'length', 'max'=>64),
			array('key, label', 'safe', 'on'=>'search'),
			array('key', 'checkKey', 'on' => 'create'),
			array('label', 'checkLabel', 'on' =>'create'),
			array('key', 'checkKey', 'on' => 'keyRepeat'),
			array('label', 'checkLabel', 'on' =>'labelRepeat'),
		);
	}

    /**
     * 
     * @param type $attribute
     * @param type $params
     */
	public function checkKey($attribute, $params){
   
        $number= AccountingMoveStatus::model()->find('`key`=:key',array(':key'=>$this->key));

        if(count($number)){
         $this->addError($attribute, MipHelper::t('Key')." ".MipHelper::t('is repeat'));
        }
    }

    
    /**
     * 
     * @param type $attribute
     * @param type $params
     */
    public function checkLabel($attribute, $params){

        $number = AccountingMoveStatus::model()->find('label=:label',array(':label'=>$this->label));
        if(count($number)){
         $this->addError($attribute, MipHelper::t('Label')." ".MipHelper::t('is repeat'));
        }

    }



}