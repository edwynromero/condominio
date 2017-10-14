<?php


class CreateAccountingMoveCest
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
    public function testCreateAccountingMove(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMove/index');       
        $I->amOnPage('/index.php/backend/accountingMove/admin');
        $I->amOnPage('/index.php/backend/accountingMove/create');
        $I->fillField('AccountingMove[date_at]', '2017-02-02');
        $I->fillField('AccountingMove[label]', 'TEST');
        $I->selectOption('AccountingMove[ref_name]', 'TEST');
        $I->fillField('AccountingMove[ref_value]', '1000');
        $I->selectOption('AccountingMove[status]', 'TEST2');
        $I->click('yt0');
    }
    
    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateAccountingMoveEmpty(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMove/index');       
        $I->amOnPage('/index.php/backend/accountingMove/admin');
        $I->amOnPage('/index.php/backend/accountingMove/create');
        $I->fillField('AccountingMove[date_at]', '');
        $I->fillField('AccountingMove[label]', '');
        $I->selectOption('AccountingMove[ref_name]', 'TEST');
        $I->fillField('AccountingMove[ref_value]', '');
        $I->selectOption('AccountingMove[status]', 'TEST2');
        $I->click('yt0');
        $I->canSee('Etiqueta no puede ser nulo');
        $I->canSee('Fecha no puede ser nulo');
        $I->canSee('Ref Valor no puede ser nulo');
        
    }
    
    
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountingMove(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMove/index');       
        $I->amOnPage('/index.php/backend/accountingMove/admin');
        
        $accountingMove = AccountingMove::model()->find('label=:label',array(':label'=>'TEST'));
        $I->amOnPage('/index.php/backend/accountingMove/update/id/'.$accountingMove->id);
        $I->fillField('AccountingMove[date_at]', '2017-02-02');
        $I->fillField('AccountingMove[label]', 'TEST');
        $I->selectOption('AccountingMove[ref_name]', 'TEST');
        $I->fillField('AccountingMove[ref_value]', '1000');
        $I->selectOption('AccountingMove[status]', 'TEST2');
        $I->click('yt0');
        $I->canSee('View AccountingMove');
          
    }
    
    
    
    public function testDeleteAccountingMove(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data = ['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingMove/index');       
        $I->amOnPage('/index.php/backend/accountingMove/admin');
        
        $accountingMove = AccountingMove::model()->find('label=:label',array(':label'=>'TEST'));
        $I->sendAjaxPostRequest('/index.php/backend/accountingMove/delete/id/'.$accountingMove->id);
        $I->seeCurrentUrlEquals('/index.php/backend/accountingMove/admin');
        $I->dontSee($accountingMove->label);   
    }
    
    
}
