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
    public function testCreateBankAccountSummaryModel()
    {   
        
        $result=FALSE;
        $model= new BankAccountSummary();
        $model->year="2017";
        $model->month="0";
        $model->bank_account_id="1";
        
        if($model->save()){
            $result=TRUE;
        }
        
        
       $this->assertTrue($result,"ha fallado la prueba debido a que los valores introducidos no son los correctos");
        
    }
}