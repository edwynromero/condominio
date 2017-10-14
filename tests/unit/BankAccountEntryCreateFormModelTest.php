<?php


class BankAccountEntryCreateFormModelTest extends \Codeception\Test\Unit
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
    public function testCreateBankAccountEntryModel()
    {
        $result                             = FALSE;
        $model                              = new BankAccountEntry();     
        $model->begin_date                  = '20161018';
        $model->end_date                    = '20161018';
        $model->number                      = 'prueba';
        $model->summary                     = "";
        $model->value                       = "1003.2";
        $model->type                        = "O";
        $model->bank_account_summary_id     =   '52';
    
        //validate data in model BankAccountEntry     
        if($model->save()){
            $result     = TRUE;
        }

            $this->assertTrue($result, 'Ha fallado la prueba debido a que algun campo no cumple con lo establecido en la base de datos');
    }
}