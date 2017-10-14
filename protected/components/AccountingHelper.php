<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountingHelper
 *
 * @author Koiosoft <Team at www.koiosoft.com>
 */
class AccountingHelper {
    //put your code here
    
    
    /**
     * 
     * @return [FiscalYear]
     */
    public static function getAllFiscalYears(){
        return FiscalYear::model()->findAll();
    }
    
    
    /**
     * 
     * @return [AccountPeriodStatus]
     */
    public static function getAllAccountPeriodStatus(){
        return AccountingPeriodStatus::model()->findAll();
    }
    
        
    /**
     * 
     * @return type
     */
     public static function refNameAccountingMove(){
            
        return array(
            "mip_pay"=>'PAGO PROPIETARIO -SISTEMA',
            "PAGO MANUAL"=>'REGISTRO MANUAL'
            );

    }
    
 
    /**
     * 
     * @param string $message
     * @param type $parameters
     * @param string $category
     * @return string
     */
	public static function t( $message, $parameters = array(), $category = "accounting")
	{
		return Yii::t($category, $message, $parameters);
	}
	
    
    /**
     * 
     * @param boolean $atCreate
     * @return [/AccountingMoveStatus]
     */
    public static function getAccountingMoveStatus($atCreate=false, $attributes=array('`key`','label')){
        
        if( $atCreate == true ){
            return array(AccountingMoveStatus::defaultStatusOpen());
        }
        
        return AccountingMoveStatus::getDefaultsForUpdate();
        
    }
    
    
    public static function getTitleProcessMessage($key){
        switch($key){
            case "error":
                return self::t("Operation Failed");
                break;
            case "success":
                return self::t("Operation Successfully");
                break;
        }
    }
    
    /**
     * Obtiene la lista de Periodos Contables disponbiles
     * 
     * @param string $date Fecha de la forma esperada en Base de Datos yyyy-mm-dd
     * @param [] $attributes
     * @return [AccountingPeriod]
     */
    public static function getPeriodList($date, $attributes=array('id','label')){
        return AccountingPeriod::model()->findAllAttributes($attributes, false," `from` <= :date AND `to` >= :date ", array(":date"=>$date) );
        
    }
        
    
    /**
     * 
     * @param integer $id
     * @return real
     */
    public static function getBalanceFromAccountingMove($id){
        
        $sumdebt = 0;
        $sumCredt = 0;
        $seats = AccountingMoveLine::model()->findAll( "accounting_move_id = :move_id", array( ":move_id" => $id ) );
        
        foreach($seats as $seat ){
            $sumdebt    += $seat->debt;
            $sumCredt   += $seat->credt;
        }
        
        
        return $sumCredt - $sumdebt;
    }
    
    
    /**
     * 
     * @param type $key
     * @return string
     */
    public static function getTitleFromMoveRefType($key){
    
        return AccountingMoveRefType::getDefaults()[$key]->title;
    }
    
    
    
    /**
     * 
     * @param array $post
     * @param AccountingAccount $model
     * @return boolean
     */
    public static function processAccountSave(&$post, &$model){
        
        
		if (isset($post['AccountingAccount'])) {
            
			$model->setAttributes($post['AccountingAccount']);
            
            $model->updated_at = MipHelper::getCurrentTimeStampDateDb(); 

			return $model->save();
		}      
        
        return false;
    }
    
    
    /**
     * 
     * @param AccountingAccount $model
     * @throws CHttpException
     */
    public static function processAccountDelete(&$model){
        
        
		$accountingAccount      = AccountingAccount::model()->find('parent_account_id=:parent_account_id', array(':parent_account_id'=>$model->id));
		$accountingAlias        = AccountingAlias::model()->find('account_id=:account_id', array(':account_id'=>$model->id));
		$accountingMoveLine     = AccountingMoveLine::model()->find('accounting_account_id=:accounting_account_id', array(':accounting_account_id'=>$model->id));

		if( (count($accountingAccount)) ||  (count($accountingAlias))  ||  (count($accountingMoveLine))  ){
			if(count($accountingAccount)){
				throw new CHttpException(500,  MipHelper::t('This accounting account is father of other accountingaccount'));
			}else if((count($accountingAlias))) {
				throw new CHttpException(500, MipHelper::t('This accounting account is used in a accounting alias'));
			}else{
				throw new CHttpException(500, MipHelper::t('This accounting account is used in a accountingMoveLine'));
			}
		}else{

            if (Yii::app()->getRequest()->getIsPostRequest()) {
                
                $model->delete();

                return true;
                
            } else
                throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));

		} 
        
        return false;
    }
    
}
