<?php


class CheckPayCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function CheckPayTest(FunctionalTester $I)
    {   // confirmacion de pago 
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/payNotCashInfo/review');
        $I->canSee('Confirmar Pagos Directo a Banco');
        $PayNotCashInfo=PayNotCashInfo::model()->find('checked=0');
        $I->amOnPage('/index.php/backend/payNotCashInfo/update/id/'.$PayNotCashInfo->id);
        $I->canSee('Actualizar Pago Directo Banco');
        $I->checkOption('#PayNotCashInfo_checked');
        $I->click(['name'=>'yt1']);
        
  
  
        
    }
    
    public function PayTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/site/showPay/7129');
  
     
    }
}
