<?php


class CreateAccountingAccountCest
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
    public function testCreateAccountingAccountEmpty(functionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccount/create");
        $I->selectOption('AccountingAccount[type]', 'ACTIVO');
        $I->fillField('AccountingAccount[code]', '12345679');
        $I->fillField('AccountingAccount[label]', 'TEST2');
        $I->fillField('AccountingAccount[debt]', '');
        $I->fillField('AccountingAccount[credt]','');
        $I->fillField('AccountingAccount[balance]', '');
        $I->selectOption('AccountingAccount[parent_account_id]', 'ACTIVOS');
        $I->fillField('AccountingAccount[access_key]', '123457');
        $I->click('yt0');
        $I->canSee('Debe no puede ser nulo');
        $I->canSee('Haber no puede ser nulo');
        $I->canSee('Balance no puede ser nulo');
    }
    
         
    
    /**
     * 
     * @param functionalTester $I Crear un registro en la accion Create
     */
    public function testCreateAccountingAccount(functionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccount/create");
        $I->selectOption('AccountingAccount[type]', 'ACTIVO');
        $I->fillField('AccountingAccount[code]', '12345678');
        $I->fillField('AccountingAccount[label]', 'TEST');
        $I->fillField('AccountingAccount[debt]', '5000');
        $I->fillField('AccountingAccount[credt]','5000');
        $I->fillField('AccountingAccount[balance]', '5000');
        $I->selectOption('AccountingAccount[parent_account_id]', 'ACTIVOS');
        $I->fillField('AccountingAccount[access_key]', '123456');
        $I->click('yt0');
        $I->canSee("Cuenta Contable #TEST");
    }
    
    
    
    /**
     * 
     * @param functionalTester Mostrar error al crear un registro repetido en la accion Create
     */
    public function testAccountingAccountDataRepeat(functionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccount/create");
        $I->selectOption('AccountingAccount[type]', 'ACTIVO');
        $I->fillField('AccountingAccount[code]', '12345678');
        $I->fillField('AccountingAccount[label]', 'TEST');
        $I->fillField('AccountingAccount[debt]', '5000');
        $I->fillField('AccountingAccount[credt]','5000');
        $I->fillField('AccountingAccount[balance]', '5000');
        $I->selectOption('AccountingAccount[parent_account_id]', 'ACTIVOS');
        $I->fillField('AccountingAccount[access_key]', '123456');
        $I->click('yt0');
        $I->canSee("Código es repetido");
        $I->canSee("Etiqueta es repetido");
    }
    
        
    
    /**
     * 
     * @param functionalTester $I Mostrar un registro existente en la accion view
     */
    public function testViewAccountingAccount(FunctionalTester $I)
    {
              
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountingAccount/index.php");
        $I->canSee('finanzas');
        $I->canSee('BANCOS');
        $I->canSee('Cuentas Bancarias');
        $accountingAccount=  AccountingAccount::model()->find('id=:id', array(':id'=>13));  
        $I->amOnPage('/index.php/backend/accountingAccount/view/id/'.$accountingAccount->id);
        $I->canSee('Cuenta Contable #'.$accountingAccount->label);
                
    }
    
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountingAccount(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');  
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingAccount/index');
        $I->canSee('ACTIVOS');          
        $accountingAccount=  AccountingAccount::model()->find('id=:id', array(':id'=>13));         
        $I->amOnPage('/index.php/backend/accountingAccount/update/id/'.$accountingAccount->id);
        $I->canSee('Update Cuenta Contable ACTIVOS CIRCULANTES');                           
        $data=['type'=>$accountingAccount->type,'code'=>$accountingAccount->code,'label'=>$accountingAccount->label,'debt'=>$accountingAccount->debt,'credt'=>$accountingAccount->credt,'balance'=>$accountingAccount->balance,'parent_account_id'=>$accountingAccount->parentAccount,'access_key'=>$accountingAccount->access_key];        
        $I->selectOption('AccountingAccount[type]', $data['type']);
        $I->fillField('AccountingAccount[code]',$data['code']);
        $I->fillField('AccountingAccount[label]',$data['label']);
        $I->fillField('AccountingAccount[debt]',$data['debt']);
        $I->fillField('AccountingAccount[credt]',$data['credt']);
        $I->fillField('AccountingAccount[balance]',$data['balance']);
        $I->selectOption('AccountingAccount[parent_account_id]',$data['parent_account_id']);
        $I->fillField('AccountingAccount[access_key]',$data['access_key']);
        $I->canSee("Update Cuenta Contable ACTIVOS CIRCULANTES");
        $I->canSee("finanzas");
        $I->click('yt0');
        $I->amOnPage('/index.php/backend/accountingAccount/view/id/13');
    }
    
       
    
    /**
     * 
     * @param functionalTester $I Eliminar un registro existente en la accion delete
     */
    public function testDeleteAccountingAccount(FunctionalTester $I)
    {
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingAccount/index');
        $I->canSee('ACTIVOS');
        $accountingAccount=  AccountingAccount::model()->find('code=:code', array(':code'=>'12345678')); 
        
        $I->amOnPage("/index.php/backend/accountingAccount/view/id/".$accountingAccount->id);
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAccount/view/id/".$accountingAccount->id);
        $I->canSee("Cuenta Contable #".$accountingAccount->label);
        $I->click("#yt0");
        $I->sendAjaxPostRequest('/index.php/backend/accountingAccount/delete/id/'.$accountingAccount->id, array('id'=>$accountingAccount->id));
        $I->amOnPage("/index.php/backend/accountingAccount/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountingAccount/admin");
        $I->dontSee($accountingAccount->code);
       
        
    }
}
