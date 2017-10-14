<?php


class CreatePayCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }
    public function CreatePayEmptyTest(FunctionalTester $I)
    {   
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/payStep1');
        
        $I->canSee('Crear Pago');
        $data=[
                'person_id'=>'654',
                'value'=>'0',
                'pay_date'=>''
              ];
        $I->selectOption(['name'=>'Pay[person_id]'],$data['person_id']);
        $I->fillField(['name'=>'Pay[value_cash]'], $data['value']); 
        $I->fillField(['name'=>'Pay[pay_date]'],$data['pay_date']);
        $I->canSeeElement('select',['id'=>'Pay_person_id', 'value'=>'']);  
        $I->canSeeElement('input',['id'=>'value_cash_text', 'value'=>'']);
        $I->canSeeElement('input',['id'=>'Pay_pay_date','value'=>'']);
        $I->click(['name'=>'yt1']); 
    }
    
   /* public function CreatePayFailedTest(FunctionalTester $I)
    {   
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/payStep1');
        $I->canSee('Crear Pago');
        $I->canSeeElement('select',['id'=>'Pay_person_id', 'value'=>'mmm']);
        $I->canSee('Propietario no puede ser nulo');
        $I->canSeeElement('input',['id'=>'value_cash_text', 'value'=>'mmmm']); 
        $I->canSee('Efectivo no puede ser nulo.');
        $I->canSeeElement('input',['id'=>'Pay_pay_date','value'=>'mmm']);
        $I->click(['name'=>'yt1']); 
    }*/

    // tests
    public function CreatePayTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/payStep1');
        $I->canSee('Crear Pago');
        $pay = [
                 'Pay' => '16/02/2017',
                 'cash'=>'100',
                 'person_id'=>'541'
                ];
        $I->fillField(['name'=>'Pay[pay_date]'], $pay['Pay']); 
        $I->fillField(['name'=>'Pay[value_cash]'], $pay['cash']);
        $I->selectOption(['name'=>'Pay[person_id]'], $pay['person_id']);
        $I->click(['name'=>'yt1']);
        $Pay=Pay::model()->find('person_id=:person_id', array(':person_id'=>$pay['person_id'])); 
        $I->amOnpage('/index.php/backend/pay/payStep2/pay_id/'.$Pay->id);
        $I->See('Cuotas a enlazar con el Pago');
        $I->click(['name'=>'yt1']);  
        $I->See('Administrar Pago');
      //  PHPUnit_Framework_Assert::assertTrue(false, 'esta prueba es exitosa'); //manera de incluir AssertTrue 
        
    }
    
    public function AdminViewPayTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/admin');
        $I->canSee('Administrar Pago');
        $I->canSee('Ver');
        $Pay=Pay::model()->find();
        $I->amOnPage('/index.php/backend/pay/view/id/'.$Pay->id);
        $I->canSee($Pay->id, 'h1');
       
    }
    
    public  function DeletePayTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/pay/admin');
        $I->canSee('Administrar Pago');
        $I->seeInSource('id','delete');
        
    }
    
    public function RealizeEmptyPayTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Mi Panel');
        
        $I->amOnPage('/index.php/site/reportPayment');
        $I->canSee('Reportar Pago','h3');
        
           $elemen=[
                    'pay-type'=>'',
                    'Info_source_bank_id'=>'',
                    'Info_pay_date'=>'',
                    'pay-number'=>'',
                    'value'=>'',
                    'bank_account_id'=>'BFC Banco Fondo Común - 01510065691000263377 (Corriente)'
                ];
     
        $I->fillField(['name'=>'PayNotCashInfo[type]'], $elemen['pay-type']);
        $I->fillField(['name'=>'PayNotCashInfo[pay_date]'], $elemen['Info_pay_date']);
        $I->fillField(['name'=>'PayNotCashInfo[number]'], $elemen['pay-number']);
        $I->fillField(['name'=>'PayNotCashInfo[value]'], $elemen['value']);
        $I->selectOption(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->canSeeElement('input',['id'=>'pay-type','value'=>$elemen['pay-type']]);   
        $I->canSeeElement('input',['id'=>'PayNotCashInfo_pay_date','value'=>$elemen['Info_pay_date']]);
        $I->canSeeElement('input',['id'=>'pay-number','value'=>$elemen['pay-number']]);
        $I->canSeeElement('input',['id'=>'value','value'=>$elemen['value']]);        
        $I->seeOptionIsSelected(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->click(['name'=>'yt0']); 
     
        $I->canSee('El tipo no puede ser nulo');
        $I->canSee('Debe seleccionar el tipo de pago');
        $I->canSee('El monto es obligatorio');
   
       
    }
    
     public function RealizeFailedPayTest(FunctionalTester $I)
     {    
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Mi Panel');
        $I->amOnPage('/index.php/site/reportPayment');
        $I->canSee('Reportar Pago','h3');
        
        
          $elemen=[
                    'pay-type'=>'zz',
                    'Info_source_bank_id'=>'zz',
                    'Info_pay_date'=>'zz',
                    'pay-number'=>'zzz',
                    'value'=>'zzz',
                    'bank_account_id'=>'BFC Banco Fondo Común - 01510065691000263377 (Corriente)'
                ];
     
        $I->fillField(['name'=>'PayNotCashInfo[type]'], $elemen['pay-type']);
        $I->fillField(['name'=>'PayNotCashInfo[pay_date]'], $elemen['Info_pay_date']);
        $I->fillField(['name'=>'PayNotCashInfo[number]'], $elemen['pay-number']);
        $I->fillField(['name'=>'PayNotCashInfo[value]'], $elemen['value']);
        $I->selectOption(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->canSeeElement('input',['id'=>'pay-type','value'=>$elemen['pay-type']]);   
        $I->canSeeElement('input',['id'=>'PayNotCashInfo_pay_date','value'=>$elemen['Info_pay_date']]);
        $I->canSeeElement('input',['id'=>'pay-number','value'=>$elemen['pay-number']]);
        $I->canSeeElement('input',['id'=>'value','value'=>$elemen['value']]);        
        $I->seeOptionIsSelected(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->click(['name'=>'yt0']); 
        $I->canSee('Reportar Pago');
        
       
    }
    
      public function RealizePayVauchertTest(FunctionalTester $I)
      {   
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Mi Panel');
        $I->amOnPage('/index.php/site/reportPayment');
        $I->canSee('Reportar Pago','h3');
        $I->canSeeElement('input',['id'=>'pay-type','value'=>'']);
        $elemen=[
                    'pay-type'=>'V',
                    'Info_source_bank_id'=>'1',
                    'Info_pay_date'=>'2017-02-17',
                    'pay-number'=>'147852369',
                    'value'=>'111',
                    'bank_account_id'=>'BFC Banco Fondo Común - 01510065691000263377 (Corriente)'
                ];
     
        $I->fillField(['name'=>'PayNotCashInfo[type]'], $elemen['pay-type']);
        $I->fillField(['name'=>'PayNotCashInfo[pay_date]'], $elemen['Info_pay_date']);
        $I->fillField(['name'=>'PayNotCashInfo[number]'], $elemen['pay-number']);
        $I->fillField(['name'=>'PayNotCashInfo[value]'], $elemen['value']);
        $I->selectOption(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->canSeeElement('input',['id'=>'pay-type','value'=>$elemen['pay-type']]);   
        $I->canSeeElement('input',['id'=>'PayNotCashInfo_pay_date','value'=>$elemen['Info_pay_date']]);
        $I->canSeeElement('input',['id'=>'pay-number','value'=>$elemen['pay-number']]);
        $I->canSeeElement('input',['id'=>'value','value'=>$elemen['value']]);        
        $I->seeOptionIsSelected(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->click(['name'=>'yt0']); 
        $PayNotCashInfo=PayNotCashInfo::model()->find('number=:number', array(':number'=>$elemen['pay-number']));
        $Pay=Pay::model()->find('id=:id', array(':id'=>$PayNotCashInfo->pay_id));
        if($Pay!=null){
            $I->see('Operación realizada satisfactoriamente ');
        }
        
        
       
    }
    
    public function RealizePayVauchertFailedTest(FunctionalTester $I)
    {     
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Mi Panel');
        $I->amOnPage('/index.php/site/reportPayment');
        $I->canSee('Reportar Pago','h3');
        $I->canSeeElement('input',['id'=>'pay-type','value'=>'']);
        $elemen=[
                    'pay-type'=>'Vtd',
                    'Info_source_bank_id'=>'d',
                    'Info_pay_date'=>'201d',
                    'pay-number'=>'123d',
                    'value'=>'111d',
                    'bank_account_id'=>'BFC Banco Fondo Común - 01510065691000263377 (Corriente)'
                ];
        $I->fillField(['name'=>'PayNotCashInfo[type]'], $elemen['pay-type']);
        $I->fillField(['name'=>'PayNotCashInfo[pay_date]'], $elemen['Info_pay_date']);
        $I->fillField(['name'=>'PayNotCashInfo[number]'], $elemen['pay-number']);
        $I->fillField(['name'=>'PayNotCashInfo[value]'], $elemen['value']);
        $I->selectOption(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->canSeeElement('input',['id'=>'pay-type','value'=>$elemen['pay-type']]);   
        $I->canSeeElement('input',['id'=>'PayNotCashInfo_pay_date','value'=>$elemen['Info_pay_date']]);
        $I->canSeeElement('input',['id'=>'pay-number','value'=>$elemen['pay-number']]);
        $I->canSeeElement('input',['id'=>'value','value'=>$elemen['value']]);        
        $I->seeOptionIsSelected(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->click(['name'=>'yt0']);
       
    }
    
    
    public function RealizePayTransferenciaTest(FunctionalTester $I)
    {

        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Mi Panel');
        $I->amOnPage('/index.php/site/reportPayment');
        $I->canSee('Reportar Pago','h3');
        $elemen=[
                    'pay-type'=>'T',
                    'pay_date'=>'20/02/2017',
                    'source_bank_id'=>'1',
                    'number'=>'12345',
                    'value'=>'225555',
                    'bank_account_id'=>'1'
                 ];
        $I->fillField(['name'=>'PayNotCashInfo[type]'], $elemen['pay-type']);
        $I->fillField(['name'=>'PayNotCashInfo[pay_date]'], $elemen['pay_date']);
        $I->selectOption(['name'=>'PayNotCashInfo[source_bank_id]'], $elemen['source_bank_id']);
        $I->fillField(['name'=>'PayNotCashInfo[number]'], $elemen['number']);
        $I->fillField(['name'=>'PayNotCashInfo[value]'], $elemen['value']);
        $I->selectOption(['name'=>'PayNotCashInfo[bank_account_id]'], $elemen['bank_account_id']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Si requiere información más detallada puede consultar usando el Botón "Detalle"');
    }

    public function  CurrentDebtTest(FunctionalTester $I)
    {    
        // mideuda actual
            $I->amOnPage('index.php');
            $I->see('Acceso Privado');
            $userdata = ['user' => 'roger.zavala','password'=>'12345678'];
            $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
            $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
            $I->click(['name'=>'yt0']);
            $I->canSee('Mi Panel');
            $I->amOnPage('index.php/site/currentDebt');
            $I->see('Mi deuda actual');
        
    }
    
    
  
    
}
