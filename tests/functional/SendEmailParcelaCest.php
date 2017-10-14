<?php
//Yii::import("PHPUnit_Framework_Assert", true);

class SendEmailParcelaCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function trySendMail(FunctionalTester $I)
    {
        $I->amOnPage('/index.php');
        $I->canSee('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/location/sendLocationDebtToEmail/location_id/42');
        $I->click(['name'=>'send']);
        $I->amOnPage('/index.php/backend/location/sendDebtReportToEmail/location_id/42/person_mail_id/133');
        $I -> sendAjaxPostRequest ( '/index.php/backend/location/sendDebtReportToEmail/location_id/42/person_mail_id/133' , array ( 'process' => true ));
        $I->see('"process":true');
      
    
       
      
        //PHPUnit_Framework_Assert::assertTrue(false, 'esta prueba es exitosa'); //manera de incluir AssertTrue 
        
        
       
        
    }
}
