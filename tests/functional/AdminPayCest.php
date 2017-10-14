<?php


class AdminPayCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function AdminPayViewTest (FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/admin'); 
        $Pay=Pay::model()->find();       
        $I->canSee('Administrar Pago');
        $I->amOnPage('/index.php/backend/pay/view/id/'.$Pay->id);
        $I->canSee('Ver Pago #'.$Pay->id);
        
        
    }
    
     public function AdminUpdatePayTest (FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/admin'); 
        $Pay=Pay::model()->find();
        $I->canSee('Administrar Pago');
        $I->amOnpage('/index.php/backend/pay/update/id/'.$Pay->id);
        $I->canSee('Actualizar Pago');
        $I->click(['name'=>'yt2']);
        $I->amOnPage('/index.php/backend/pay/payStep2/pay_id/'.$Pay->id);
        $I->see('Seleccione las Cuotas');
        $debt=ViewLocationFeePay::model()->find('pay_id=:pay_id', array(':pay_id'=>$Pay->id));
        if($debt){
           $I->checkOption('#toggle-fee-1_101');
        }  
    }
    
    public function AdminPayDeleteTest (FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/admin'); 
        $Pay=Pay::model()->find();     
        $I->canSee('Administrar Pago');
        $I->amOnPage('/index.php/backend/pay/delete/id/'.$Pay->id);
        
    }
}
