<?php


class CreateAccountingAliasCest
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
    public function testCreateAccountingAlias(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAlias/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/admin");
        $I->amOnPage('/index.php/backend/accountingAlias/create');
        $I->canSee('Crear Alias Contable');
        $I->canSee('Los campos con * son requeridos.');
        $I->fillField('AccountingAlias[key]', '1234');
        $I->selectOption('AccountingAlias[account_id]', 'ACTIVOS');
        $I->fillField('AccountingAlias[label]', 'TEST');
        $I->fillField('AccountingAlias[alias]', 'TEST');
        $I->fillField('AccountingAlias[access_key]', '1234');
        $I->click("yt0");
                  
    }
    
    
    
    /**
     * 
     * @param functionalTester $I crear un registro repetido en la accion Create
     */
    public function testCreateAccountingAliasDataRepeat(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAlias/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/admin");
        $I->amOnPage('/index.php/backend/accountingAlias/create');
        $I->canSee('Crear Alias Contable');
        $I->canSee('Los campos con * son requeridos.');
        $I->fillField('AccountingAlias[key]', '1234');
        $I->selectOption('AccountingAlias[account_id]', 'ACTIVOS');
        $I->fillField('AccountingAlias[label]', 'TEST');
        $I->fillField('AccountingAlias[alias]', 'TEST');
        $I->fillField('AccountingAlias[access_key]', '1234');
        $I->click("yt0");
        $I->canSee("key es repetido");
        $I->canSee("Access Key es repetido");
                  
    }
    
    
    
    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateAccountingAliasEmpty(FunctionalTester $I)
    {            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAlias/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/admin");
        $I->amOnPage('/index.php/backend/accountingAlias/create');
        $I->canSee('Crear Alias Contable');
        $I->canSee('Los campos con * son requeridos.');
        $I->fillField('AccountingAlias[key]', '');
        $I->selectOption('AccountingAlias[account_id]', 'ACTIVOS');
        $I->fillField('AccountingAlias[label]', '');
        $I->fillField('AccountingAlias[alias]', '');
        $I->fillField('AccountingAlias[access_key]', '');
        $I->click("yt0");
        $I->canSee('Key no puede ser nulo');
        $I->canSee('Etiqueta no puede ser nulo');
        $I->canSee('Access Key no puede ser nulo');
                         
   } 
   
   
   /**
     * 
     * @param functionalTester $I Mostrar un registro existente en la accion view
     */
   public function testViewAccountingAlias(FunctionalTester $I){
           
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0'); 
        $accountingAlias= AccountingAlias::model()->find("`key`=:key",array(':key'=>'1234')); 
        $I->amOnPage("/index.php/backend/accountingAlias/view/id/".$accountingAlias->key);
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/view/id/".$accountingAlias->key);        
        $I->canSee('View Alias Contable '.$accountingAlias->label);
   }
   
   
   
   
   /**
     * 
     * @param functionalTester $I Mostrar vista Admin
     */
  public function testAdminAccountingAlias(FunctionalTester $I){
  
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0'); 
        $I->amOnPage("/index.php/backend/accountingAlias/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/admin");        
        $I->canSee('Administrar Alias Contables');
   }
   
   
   /**
     * 
     * @param functionalTester $I Eliminar un registro existente en la accion Delete
     */
  public function testDeleteAccountingAlias(FunctionalTester $I){
          
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0'); 
        $accountingAlias= AccountingAlias::model()->find("`key`=:key",array(':key'=>'1234')); 
        $I->amOnPage("/index.php/backend/accountingAlias/view/id/".$accountingAlias->key);
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/view/id/".$accountingAlias->key);        
        $I->canSee('View Alias Contable '.$accountingAlias->label);
        $I->click('#yt0'); 
        $I->sendAjaxPostRequest('/index.php/backend/accountingAlias/delete/id/'.$accountingAlias->key);
        $I->amOnPage("/index.php/backend/accountingAlias/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAlias/admin");
        $I->dontSee($accountingAlias->key);
  } 
   
   
    
    
}
