<?php


class CreateFeeTypeCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function FeeTypeTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/feeType/create');
        $I->canSee('Create FeeType');
        
        $I->submitForm(
          '#fee-type-form',
          [
             
          ],
          'submitButton'
      );
        $I->canSee('Título no puede ser nulo.');
        $I->canSee('Resumen no puede ser nulo.');
        
        
        $I->submitForm(
             '#fee-type-form',
             [
                 'FeeType' => [
                    'title'=>'mee',
                    'summary'=>'dd',
                    'description'=>'dddd',
                    'value'=>'ddd',
                    'active'=>TRUE,
                    'is_regular'=>TRUE
                 ]
             ],
             'submitButton'
         );
        
    }
    
    
    
    public function FeeQuotaTest(FunctionalTester $I){
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/feeType/create');
        $I->submitForm(
                        '#fee-type-form',
                        [

                        ],
                        'submitButton'
                        );
        $I->canSee('Título no puede ser nulo.');
        $I->canSee('Resumen no puede ser nulo.');
        
        
        $I->submitForm(
             '#fee-type-form',
             [
                 'FeeType' => [
                    'title'=>'mee',
                    'summary'=>'dd',
                    'description'=>'dddd',
                    'value'=>'ddd',
                    'active'=>TRUE,
                    'is_regular'=>TRUE
                 ]
             ],
             'submitButton'
         );
        
    }
}
