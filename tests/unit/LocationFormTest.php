<?php


class LocationFormTest extends \Codeception\Test\Unit
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
    public function testLocationCreateValidate()
    {


        $result=FALSE;
        $model= new Location();
        $model->code='555';
        $model->status='S';
        $model->initial_debt='500.23';
        $model->comments="PRUEBA";
        $model->is_built="1";


        if($model->validate()){
            $result=TRUE;
        }


        $this->assertTrue($result, "la prueba ha fallado debido a que los valores introducidos no son correctos");

    }
}