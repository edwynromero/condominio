<?php


class CreateAccountPeriodStatusCest
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
    public function testCreateAccountPeriodStatus(FunctionalTester $I)
    {
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountPeriodStatus/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountPeriodStatus/admin");
        $I->amOnPage('/index.php/backend/accountPeriodStatus/create');
        $I->fillField('AccountPeriodStatus[key]', '1234');
        $I->fillField('AccountPeriodStatus[label]', 'TEST');
        $I->fillField('AccountPeriodStatus[at_period]', '1');
        $I->fillField('AccountPeriodStatus[at_year]', '1');
        $I->click('yt0');
        $I->canSee('View AccountPeriodStatus #1234');
    }
    
    
    
    
    /**
     * 
     * @param functionalTester Mostrar error al crear un registro repetido en la accion Create
     */
    public function testCreateAccountPeriodStatusDataRepeat(FunctionalTester $I){
            
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->amOnPage("/index.php/backend/accountPeriodStatus/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountPeriodStatus/admin");
        $I->amOnPage('/index.php/backend/accountPeriodStatus/create');
        $I->fillField('AccountPeriodStatus[key]', '1234');
        $I->fillField('AccountPeriodStatus[label]', 'TEST');
        $I->fillField('AccountPeriodStatus[at_period]', '1');
        $I->fillField('AccountPeriodStatus[at_year]', '1');
        $I->click('yt0');
        $I->canSee('key es repetido');
        $I->canSee('Etiqueta es repetido');          
    }
    
    
    
    
    /**
     * 
     * @param functionalTester $I Actualizar un registro existente en la accion update
     */
    public function testUpdateAccountPeriodStatus(FunctionalTester $I){
         $I->amOnPage("index.php");
        $I->see('Acceso Privado');  
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountPeriodStatus/index');
                 
        $accountPeriodStatus= AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>'1234'));         
        $I->amOnPage('/index.php/backend/accountPeriodStatus/update/id/'.$accountPeriodStatus->key);
        $I->canSee('Update AccountPeriodStatus '.$accountPeriodStatus->key);                                   
        $I->fillField('AccountPeriodStatus[key]','1235');
        $I->fillField('AccountPeriodStatus[label]','TEST2');
        $I->click('yt0');
        $accountPeriodStatus= AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>'1235')); 
        $I->canSeeCurrentUrlEquals('/index.php/backend/accountPeriodStatus/view/id/'.$accountPeriodStatus->key);          
    }
    
    
    /**
     * 
     * @param functionalTester $I Eliminar un registro existente en la accion delete
     */
    public function testDeleteAccountPeriodStatus(FunctionalTester $I){
        $I->amOnPage("index.php");
        $I->see('Acceso Privado');
        $data=['admin'=>'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $data['admin']);
        $I->fillField(['name'=>'LoginForm[password]'], $data['password']);
        $I->click('yt0');
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/accountingAccount/index');
  
        $accountPeriodStatus= AccountingPeriodStatus::model()->find('`key`=:key', array(':key'=>'1235')); 
        
        $I->amOnPage("/index.php/backend/accountPeriodStatus/view/id/".$accountPeriodStatus->key);
        $I->seeCurrentUrlEquals("/index.php/backend/accountPeriodStatus/view/id/".$accountPeriodStatus->key);
        $I->canSee("View AccountPeriodStatus #".$accountPeriodStatus->key);
        $I->click("#yt0");
        $I->sendAjaxPostRequest('/index.php/backend/accountPeriodStatus/delete/id/'.$accountPeriodStatus->key, array('key'=>$accountPeriodStatus->key));
        $I->amOnPage("/index.php/backend/accountPeriodStatus/admin");
        $I->seeCurrentUrlEquals("/index.php/backend/accountPeriodStatus/admin");
        $I->dontSee($accountPeriodStatus->label);        
    }
    
    
    
    
}
