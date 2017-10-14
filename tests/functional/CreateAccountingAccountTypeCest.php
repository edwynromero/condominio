<?php


class CreateAccountingAccountTypeCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * 
     * @param functionalTester $I Mostrar errores campos vacios requeridos en la accion Create 
     */
    public function testCreateAccountingAccountTypeEmpty(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccountType/create");
        $I->canSee("Crear Tipo de cuenta contable");
        $I->click('yt0');
        $I->canSee("Por favor corrija los siguientes errores de ingreso:");
        $I->canSee("Key no puede ser nulo.");
        $I->canSee("Etiqueta no puede ser nulo.");
    }
     
   
  
    
    /**
     * 
     * @param functionalTester $I crear un registro en la accion Create
     */
   public function testCreateAccountingAccountType(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccountType/create");
        $I->canSee("Crear Tipo de cuenta contable");
        $I->fillField('AccountingAccountType[key]', '9876');
        $I->fillField('AccountingAccountType[label]','TESTS');
        $I->fillField('AccountingAccountType[is_debt]','1');
        $I->click('yt0');
    }
    
    /**
     * 
     * @param functionalTester $I crear un registro repetido en la accion Create
     */
    public function testCreateAccountingAccountTypeDataRepeat(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccountType/create");
        $I->canSee("Crear Tipo de cuenta contable");
        $I->fillField('AccountingAccountType[key]', '9876');
        $I->fillField('AccountingAccountType[label]','TESTS');
        $I->fillField('AccountingAccountType[is_debt]','1');
        $I->click('yt0');
        $I->canSee('key es repetido');
        $I->canSee('Etiqueta es repetido');
    }
    
    
    
    
    
    /**
     * 
     * @param functionalTester $I Mostrar vista Admin
     */
    public function testAdminAccountingAccountType(FunctionalTester $I){
            
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click("yt0");
        $I->amOnPage("/index.php/backend/accountingAccountType/admin");
        $I->canSee('Administrar Tipos de Cuentas Contables');
        $I->selectOption("AccountingAccountType[is_debt]", 'No');
        $I->canSee("1111");
        $I->canSee("ACTIVO");
        $I->canSee('Yes');
        $I->canSee('TEST');               
    }
  
  
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountingAccountType(FunctionalTester $I){    
            
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click("yt0");
        $I->amOnPage("/index.php/backend/accountingAccountType/admin");
        $I->canSee('Administrar Tipos de Cuentas Contables');
        
        $accountingAccountType=  AccountingAccountType::model()->find('`key`=:key',array(':key'=>'4444'));
        $I->amOnPage("/index.php/backend/accountingAccountType/update/id/".$accountingAccountType->key);
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAccountType/update/id/".$accountingAccountType->key);
        $I->fillField('AccountingAccountType[label]', 'TEST');
        $I->click("yt0");
        
    }
    
    
    /**
     * 
     * @param functionalTester $I Eliminar un registro existente en la accion Delete
     */
    public function testDeleteAccountingAccountType(FunctionalTester $I){
        $I->amOnPage('index.php');
        $I->canSee('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click("yt0");
        $I->amOnPage("/index.php/backend/accountingAccountType/admin");
        $I->canSee('Administrar Tipos de Cuentas Contables');
        $accountingAccountType=  AccountingAccountType::model()->find('`key`=:key',array(':key'=>'9876'));
        $I->amOnPage("/index.php/backend/accountingAccountType/view/id/".$accountingAccountType->key);
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAccountType/view/id/".$accountingAccountType->key);
        $I->canSee("Tipo de cuenta contable ".$accountingAccountType->label);
        $I->click("#yt0");
        $I->sendAjaxPostRequest('/index.php/backend/accountingAccountType/delete/id/9876', array('id'=>$accountingAccountType->key));
        $I->amOnPage("/index.php/backend/accountingAccountType/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAccountType/admin");
        $I->dontSee($accountingAccountType->key);
    }
    
    
    
   
    
    
    

    
    
    
    
    
    
 

    

    
}
