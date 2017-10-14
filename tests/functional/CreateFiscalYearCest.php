<?php


class CreateFiscalYearCest
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
    public function testCreateFiscalYear(FunctionalTester $I)
    {
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/fiscalYear/index');       
        $I->amOnPage('/index.php/backend/fiscalYear/admin');
        $I->amOnPage('/index.php/backend/fiscalYear/create');
        $I->fillField('FiscalYear[from]', '2017-02-01');
        $I->fillField('FiscalYear[to]','2017-02-25');
        $I->fillField('FiscalYear[label]', 'TEST');
        $I->selectOption('FiscalYear[status]', 'TEST2');
        $I->fillField('FiscalYear[is_closed]', '1');
        $I->click('yt0');
        $I->canSee('TEST');
                   
    }
    
    
    
    
    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateFiscalYearEmpty(FunctionalTester $I)
    {
     
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/fiscalYear/index');       
        $I->amOnPage('/index.php/backend/fiscalYear/admin');
        $I->amOnPage('/index.php/backend/fiscalYear/create');
        $I->fillField('FiscalYear[from]', '');
        $I->fillField('FiscalYear[to]','');
        $I->fillField('FiscalYear[label]', '');
        $I->selectOption('FiscalYear[status]', 'TEST2');
        $I->fillField('FiscalYear[is_closed]', '1');
        $I->click('yt0');
        $I->canSee('Etiqueta no puede ser nulo');
        $I->canSee('Desde no puede ser nulo');
        $I->canSee('Hasta no puede ser nulo');
               
    }
    
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateTestFiscalYear(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/fiscalYear/index');       
        $I->amOnPage('/index.php/backend/fiscalYear/admin');
        $fiscalYear = FiscalYear::model()->find('label=:label',array(':label'=>'TEST'));
        $I->amOnpage('/index.php/backend/fiscalYear/update/id/'.$fiscalYear->id);
        $I->fillField('FiscalYear[from]', '2017-02-01');
        $I->fillField('FiscalYear[to]','2017-02-25');
        $I->fillField('FiscalYear[label]', 'TEST');
        $I->selectOption('FiscalYear[status]', 'TEST2');
        $I->fillField('FiscalYear[is_closed]', '1');
        $I->click('yt0');
        $I->canSee('TEST');
       
            
    }
    
    
    
    /**
     * 
     * @param functionalTester $I ELiminar un registro existente en la accion update
     */
    public function testDeleteTestFiscalYear(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión'); 
        $I->amOnPage('/index.php/backend/fiscalYear/index');       
        $I->amOnPage('/index.php/backend/fiscalYear/admin');
        $fiscalYear = FiscalYear::model()->find('label=:label',array(':label'=>'TEST'));
        $I->amOnpage('/index.php/backend/fiscalYear/view/id/'.$fiscalYear->id);
        $I->sendAjaxPostRequest('/index.php/backend/fiscalYear/delete/id/'.$fiscalYear->id);
        $I->seeCurrentUrlEquals('/index.php/backend/fiscalYear/admin/');
        $I->dontSee($fiscalYear->label);
        
    }
    
    
    
    
    
}
