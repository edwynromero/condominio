<?php


class CreateAccountingPeriodCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * 
     * @param functionalTester $I crear un registro en la accion Create 
     */
    public function testCreateAccountingPeriod(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingAccount/index');       
        $I->amOnPage('/index.php/backend/accountingPeriod/create');
        $I->fillField('AccountingPeriod[from]', '2017-07-12');
        $I->fillField('AccountingPeriod[to]', '2017-07-20');
        $I->selectOption('AccountingPeriod[fiscal_year_id]', 'TEST');
        $I->fillField('AccountingPeriod[label]', 'TEST');
        $I->selectOption('AccountingPeriod[status]', 'TEST2');
        $I->click('yt0');        
    }
    
    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateAccountingPeriodEmpty(FunctionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingAccount/index');      
        $I->amOnPage('/index.php/backend/accountingPeriod/create');
        $I->fillField('AccountingPeriod[from]', '');
        $I->fillField('AccountingPeriod[to]', '');
        $I->selectOption('AccountingPeriod[fiscal_year_id]', 'TEST');
        $I->fillField('AccountingPeriod[label]', '');
        $I->selectOption('AccountingPeriod[status]', 'TEST2');
        $I->click('yt0');
        $I->canSee('Etiqueta no puede ser nulo');
        $I->canSee('Desde no puede ser nulo');
        $I->canSee('Hasta no puede ser nulo');
        $I->seeCurrentUrlEquals('/index.php/backend/accountingPeriod/create');
    }


    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountingPeriod(FunctionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingPeriod/index');
        
        $accountingPeriod = AccountingPeriod::model()->find('label=:label',array('label'=>'TEST'));
        $I->amOnPage('/index.php/backend/accountingPeriod/update/id/'.$accountingPeriod->id);
        $I->fillField('AccountingPeriod[from]', '2017-07-12');
        $I->fillField('AccountingPeriod[to]', '2017-07-20');
        $I->selectOption('AccountingPeriod[fiscal_year_id]', 'TEST');
        $I->fillField('AccountingPeriod[label]', 'TEST');
        $I->selectOption('AccountingPeriod[status]', 'TEST2');
        $I->click('yt0');
        $I->seeCurrentUrlEquals('/index.php/backend/accountingPeriod/view/id/'.$accountingPeriod->id);
        
    }
    
    
    /**
     * 
     * @param functionalTester $I ELiminar un registro existente en la accion update
     */
    public function testDeleteAccountingPeriod(FunctionalTester $I){
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingPeriod/index');  
        $accountingPeriod = AccountingPeriod::model()->find('label=:label',array('label'=>'TEST'));
        $I->amOnPage('/index.php/backend/accountingPeriod/view/id/'.$accountingPeriod->id);
        $I->click('#yt0');
        $I->sendAjaxPostRequest('/index.php/backend/accountingPeriod/delete/id/'.$accountingPeriod->id);
        $I->amOnPage('/index.php/backend/accountingPeriod/admin');
        $I->dontSee($accountingPeriod->label);           
    }
    
}
