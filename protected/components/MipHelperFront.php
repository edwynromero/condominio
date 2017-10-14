<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class MipHelperFront
{
    
    /**
     * Traduccion de textos para el frontend
     * @param string $message
     */
    public static function t( $message )
    {
        return MipHelper::t($message, "front");
    }

    /**
     *
     * @return Ambigous <multitype:CActiveRecord , mixed, CActiveRecord, NULL, multitype:unknown Ambigous <CActiveRecord, NULL> , multitype:, multitype:unknown >
     */
    public static function getDataBankAccount()
    {
    	$criteria = new CDbCriteria();
    	$criteria->order = "number DESC";
    	$criteria->condition = " account_type <> :account_type ";
    	$criteria->params = array(":account_type" => BankAccount::ACCOUNT_TYPE_ONLY_MIP );
    	
    	return GxHtml::listData(BankAccount::model()->findAll($criteria ), "id","FullReference");
    }
    
}
