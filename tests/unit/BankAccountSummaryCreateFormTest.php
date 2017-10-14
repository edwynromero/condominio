<?php


class bankAccountSummaryTest extends \Codeception\Test\Unit
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
    public function testCreateBankAccountSummaryForm()
    {   
        
   
        $model= new BankAccountSummary();
        $model->year=2015;
        $model->month=12;
        $model->bank_account_id=5;
        $model->file_name="prueba";
        $model->validate();
        
       $this->assertTrue(TRUE,"");
    }
}