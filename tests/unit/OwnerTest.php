<?php


class OwnerTest extends \Codeception\Test\Unit
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
    public function testOwner()
    {
        $result=FALSE;
        $model= new Owner();
        $model->location_id='1';
        $model->person_id='511';
        $model->begin_date='20110513';
        $model->end_date='20120614';
        $model->initial_debt='abc';


        if($model->validate()){
            $result=TRUE;
        }


        $this->assertTrue($result, "La prueba ha fallado debido a que los valores introducidos no son los correctos");

    }
}