<?php


class BankAccountSummaryCreateFormModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    // tests
    public function testBankAccountSummaryCreateValidate()
    {   
        //validacion de cada campo del form
        $result=FALSE;
        $model= new BankAccountSummary();
        $model->year="2015";
        $model->month="0";
        $model->bank_account_id="1";
        
        if($model->validate()){
            $result=TRUE;
        }

        //se espera que la prueba falle
        $this->assertTrue($result,"ha fallado la prueba debido a que los valores introducidos no son los correctos");

    }


    public function testBankAccountSummaryCreateSave()
    {  

        //Validacion de entrada de data a la bd
        $result=FALSE;
        $model= new BankAccountSummary();
        $model->year="2017";
        $model->month="0";
        $model->bank_account_id="1";
        
        if($model->save()){
            $result=TRUE;
        }
        //Se espera que la prueba falle
        $this->assertTrue($result,"ha fallado la prueba debido a que los valores introducidos no son los correctos");
        
    }





}