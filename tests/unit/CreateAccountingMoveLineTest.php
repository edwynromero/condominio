<?php


class CreateAccountingMoveLineTest extends \Codeception\Test\Unit
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

    

    /**
     * 
     * @param   Metodo con informacion erronea dedicado a fallar con campos vacios
     */
    public function testAccountingMoveLinefailedEmpy()
    {
            $model = new AccountingMoveLine();
            
            $model->date_at = '';
            $model->accounting_period_id = '';
            $model->debt = '';
            $model->credt = '';
            $model->balance = '';
            $model->amount= '';
            $model->accounting_account_id='';
            
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                
                'date_at'=>'Fecha no puede ser nulo.', 
                'accounting_period_id'=>'Periodo Contable no puede ser nulo.',
                'debt'=>'Debe no puede ser nulo.',
                'credt'=>'Haber no puede ser nulo.',

                'amount' => 'Monto no puede ser nulo.',
                'accounting_account_id'=>'Cuenta Contable no puede ser nulo.',
                
                                             
            ];

            

            $fail=true;
            foreach($msg as $key=>$value)
            {
                    if(strcmp($value,$model->errors[$key][0])!==0){
                         $fail=false;
                         $this->assertTrue($fail, "campo ".$key." con valor proporcionado '".$value."' reglas a seguir '".$model->errors[$key][0]."'");    
                    }
            }



    }


   

}