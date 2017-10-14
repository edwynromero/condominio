<?php


class FeeCreateFormTest extends \Codeception\Test\Unit
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
    public function testFeeCreateValidateTest()
    {
        $result=FALSE;
        $model= new Fee();
        $model->fee_type_id="198";
        $model->begin_date="2010-02-01";
        $model->end_date="2010-02-28";
        $model->name="Cuota Regular 02-2010";
        $model->summary="c_300_2010";
        $model->value="50a0";


        if($model->validate()){

            $result=TRUE;

        }


        $this->assertTrue($result, "ha fallado la prueba debido a que los valores introducidos no son los correctos");

    }
}