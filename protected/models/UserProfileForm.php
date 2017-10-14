<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class UserProfileForm extends CFormModel
{
    const PASSWORD_TMP_VALID    = 'Password123.,';
    const EMAIL_TMP_VALID       = 'test@gmail.com';
    
    public $user_name;
    
    public $email;
    public $email_confirm;
    
    public $phone_number;
    public $phone_prefix;
    public $phone_type;
    
    public $first_name;
    public $last_name;
    public $full_name;
    
    public $identity;
    public $is_not_company;
    
    
    public $password;
    public $password_new;
    public $password_confirm;
    
    public $locations;
    
   public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(

            array('phone_prefix, phone_number, phone_type', 'required', 'message' => MipHelperFront::t( "The field is are required") ),
            array('phone_prefix, phone_number', 'numerical', 'integerOnly'=>true, 'message' => MipHelperFront::t( "The field only numbers" )),
            array('phone_prefix', 'length', 'max'=>4, 'tooLong' => MipHelperFront::t( "The field accept maxime four (4) characters" )),
            array('phone_number', 'length', 'max'=>7, 'tooLong' => MipHelperFront::t( "The field accept maxime four (7) characters" )),

            array('password', 'required',  'message' => MipHelperFront::t( 'The password not can be null')),
            
            array('password_new, password_confirm', 'required', 'on'=>'update_password, update_password_email' ),
            array('password_new, password_confirm', 'compare', 'compareAttribute'=>'password_confirm', 'message' => MipHelperFront::t( 'The new password and the confirmation must be same'), 'on'=>'update_password, update_password_email' ),
            array('password_new, password_confirm', 'length', 'min'=>6, 'max'=>16, 'tooShort'=> MipHelperFront::t('The new password entre 6 y 16 characters'), 'tooLong'=> MipHelperFront::t('The new password entre 6 y 16 characters')  ),
            array('password_new', 'match', 'pattern'=>'/\d/', 'message'=> MipHelper::t('Password must contain at least one numeric digit') , 'on'=>'update_password, update_password_email' ),
            array('password_new', 'match', 'pattern'=>'((?=.*[a-z]))', 'message'=>MipHelper::t('Password must contain at least one lower case character') , 'on'=>'update_password, update_password_email' ),
            array('password_new', 'match', 'pattern'=>'((?=.*[A-Z]))', 'message'=>MipHelper::t('Password must contain at least one upper case character') , 'on'=>'update_password, update_password_email' ),
            
            array('email, email_confirm', 'required', 'on'=>'update_email, update_password_email' ),
            array('email, email_confirm', 'compare', 'compareAttribute'=>'email_confirm', 'on'=>'update_email, update_password_email' ),
            array('email, email_confirm','email', 'message' => MipHelperFront::t( 'The email is not valid'), 'on'=>'update_email, update_password_email' ),
            array('email,email_confirm,phone_number,phone_prefix,phone_type,password,password_new,password_confirm', 'safe'),
            
        );
    }
    
    
}
