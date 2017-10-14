<?php


class CreateShareCest
{
    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    // tests
    public function CrateFeeTest(FunctionalTester $I)
    {
        $I->amOnPage('index.php');
        $I->see('Acceso Privado');
        $userdata = ['user' => 'admin','password'=>'12345678'];
        $I->fillField(['name'=>'LoginForm[username]'], $userdata['user']);
        $I->fillField(['name'=>'LoginForm[password]'], $userdata['password']);
        $I->click(['name'=>'yt0']);
        $I->canSee('Sistema de Gestión');
        $I->amOnPage('/index.php/backend/fee/admin');
        $I->canSee('Administrar Cuotas');
        $I->amOnPage('/index.php/backend/fee/create');
        $I->canSee('Create Fee');
        $fee=[
                'fee_type_id'=>'2',
                'begin_date'=>'16/02/2017',
                'end_date'=>'16/02/2017',
                'nameFee'=>'pruebass',
                'summary'=>'resume',
                'value'=>'10'
            ];
        
        $form = [
                    'Fee[fee_type_id]'=> $fee['fee_type_id'],
                    'Fee[begin_date]'=>$fee['begin_date'],
                    'Fee[end_date]'=>$fee['end_date'], 
                    'Fee[name]'=>$fee['nameFee'],
                    'Fee[summary]'=>$fee['summary'],
                    'Fee[value]'=>$fee['value']
               ];
        $I->submitForm('#fee-form', $form, 'submitButton');
        
        $Fees=Fee::model()->find('name=:name and  fee_type_id=:fee_type_id and begin_date=:begin_date', 
                            array(':name'=>$fee['nameFee'],':fee_type_id'=>$fee['fee_type_id'],':begin_date'=>$fee['begin_date']));
       $I->see('View Fee #');
     }
     
     
}
