<?php


class PayCreateFormTest extends \Codeception\Test\Unit
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
    public function testPayCreateValidate()
    {   

        $result             =FALSE;
        $model              =new Pay();
        $model->pay_date    =MipHelper::parseDateToDb('23-06-2017');
        $model->value_cash  ='5000a';
        $model->person_id   ='1000';

        if($model->validate()){
            $result         =TRUE;
        }

        $this->assertTrue($result, 'Ha fallado la prueba debido a que algun campo no cumple con lo establecido en el metodo rules de la clase Pay');

    }
}