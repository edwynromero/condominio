<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProcessLocationForm
 *
 * @author Koiosoft <Team at www.koiosoft.com>
 * 
 * @property integer $location_id Id de la Propiedad
 * @property integer $person_id Id de la Persona (propietario)
 */
class ProcessLocationForm extends CFormModel {
    
    public $location_id;
    public $person_id;
    public $last_pay_id;
    
    //put your code here
    
    public function rules() {
            return array(
                array('location_id, person_id, last_pay_id', 'safe'),
            );
    }


    public function attributeLabels() {
            return array(
                'location_id' => Yii::t('app', 'Location'),
                'person_id' => Yii::t('app', 'Owner'),
            );
    }
    
}
