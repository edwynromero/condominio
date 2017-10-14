<?php


class GroundCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    
    public function createLocationEmptyTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->see('Mirador Panamericano - Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/location/create');
        $I->canSee('Crear Parcela');
        $I->submitForm(
             '#location-form',
             [
                 'Location' => [
                    
                               ]
             ],
             'submitButton'
         );
       $I->See('Número no puede ser nulo.');
       
    
    }
    public function createLocationTest(FunctionalTester $I)
    {
            $I->amOnPage('index.php');
            $I->see('Acceso Privado');
            $userdata = ['user' => 'admin','password'=>'12345678'];
            $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
            $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
            $I->click(['name'=>'yt0']);
            $I->see('Mirador Panamericano - Sistema de Gestión'); 
            $I->amOnPage('/index.php/backend/location/create');
            $I->canSee('Crear Parcela');
            $elemen=[   
                       'Location_code'=>'1234567891',
                       'Location_status'=>'Activo',
                       'initial_debt'=>'0.00',
                       'Location_comments'=>'1',
                       'Location_is_built'=>TRUE
                   ];

             $I->fillField(['name'=>'Location[code]'], $elemen['Location_code']);
             $I->selectOption(['name'=>'Location[status]'], $elemen['Location_status']);
             $I->fillField(['name'=>'Location[initial_debt]'], $elemen['initial_debt']);
             $I->fillField(['name'=>'Location[comments]'], $elemen['Location_comments']);
             $I->fillField(['name'=>'Location[is_built]'], $elemen['Location_is_built']);
             $I->canSeeElement('input',['id'=>'Location_code','value'=>$elemen['Location_code']]);
             $I->seeOptionIsSelected(['name'=>'Location[status]'], $elemen['Location_status']);
             $I->canSeeElement('input',['id'=>'initial_debt','value'=>$elemen['initial_debt']]);
             $I->canSeeElement('textarea',['id'=>'Location_comments','value'=>$elemen['Location_comments']]);
             $I->canSeeElement('input',['id'=>'Location_is_built','value'=>$elemen['Location_is_built']]);
             $I->click(['name'=>'yt0']);
             $Location=Location::model()->find('code=:code',array(':code'=>$elemen['Location_code']));
             if($Location){
             $I->See('Vista Parcela');
             }
   
        
    }
    

    
    
}
