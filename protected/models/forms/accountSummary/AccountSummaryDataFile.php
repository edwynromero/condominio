<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AccountSummaryDataFile
 *
 * @author rogerz
 */
class AccountSummaryDataFile extends CFormModel {
    //put your code here
    
    public $file;
    
    
    
    public function rules() {
            return array(
                array('file', 'safe'),
            );
    }


    public function attributeLabels() {
            return array(
                'file' => Yii::t('app', 'File'),
            );
    }
    
}
