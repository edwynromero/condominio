<?php


class CreateAccountingMoveStatusCest
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
    public function testCreateAccountingMoveStatus(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/index');       
        $I->amOnPage('/index.php/backend/accountingMoveStatus/admin');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/create');
        $I->canSee('Crear Estado movimiento Contable');
        $I->fillField('AccountingMoveStatus[key]', '1111');
        $I->fillField(('AccountingMoveStatus[label]'), 'TEST');
        $I->click('yt0');
        
    }
    
    
    
    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateAccountingMoveStatusEmpty(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/index');       
        $I->amOnPage('/index.php/backend/accountingMoveStatus/admin');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/create');
        $I->canSee('Crear Estado movimiento Contable');
        $I->fillField('AccountingMoveStatus[key]', '');
        $I->fillField(('AccountingMoveStatus[label]'), '');
        $I->click('yt0');
        $I->canSee('Key no puede ser nulo');
        $I->canSee('Etiqueta no puede ser nulo');
        
    }
    
    
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountingMoveStatus(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/index');       
        $I->amOnPage('/index.php/backend/accountingMoveStatus/admin');
        
        $accountingMoveStatus = AccountingMoveStatus::model()->find('`key`=:key',array(':key'=>'1111'));
        $I->amOnPage('/index.php/backend/accountingMoveStatus/update/id/'.$accountingMoveStatus->key);
        $I->fillField('AccountingMoveStatus[key]', '1111');
        $I->fillField(('AccountingMoveStatus[label]'), 'TEST');
        $I->click('yt0');
        $I->canSee('View AccountingMoveStatus');
        
    }
    
    
    
    /**
     * 
     * @param functionalTester $I ELiminar un registro existente en la accion update
     */
    public function testDeleteAccountingMoveStatus(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMoveStatus/index');       
        $I->amOnPage('/index.php/backend/accountingMoveStatus/admin');
        
        $accountingMoveStatus = AccountingMoveStatus::model()->find('`key`=:key',array(':key'=>'1111'));
        $I->sendAjaxPostRequest('/index.php/backend/accountingMoveStatus/delete/id/'.$accountingMoveStatus->key);
        $I->seeCurrentUrlEquals('/index.php/backend/accountingMoveStatus/admin');
        $I->dontSee($accountingMoveStatus->label);
    }
    
    
}
