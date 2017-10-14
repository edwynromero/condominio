<?php


class CreateAccountingMoveTest extends \Codeception\Test\Unit
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
    public function testAccountingMovefailedEmpy()
    {
            $model = new AccountingMove();
            
            $model->date_at = '';
            $model->label = '';
            $model->ref_name = '';
            $model->ref_value = '';
            $model->status = '';

            
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                
                'date_at'=>'Fecha no puede ser nulo.', 
                'label'=>'Etiqueta no puede ser nulo.',
                'ref_name'=>'Ref Nombre no puede ser nulo.',
                'ref_value' =>'Ref Valor no puede ser nulo.',
                'status' => 'Estatus no puede ser nulo.',
                
                                             
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





    // tests
   
    
    
    
    /**
     * 
     * @param   Metodo dedicado a crear un registro nuevo inexistente 
     */

    public function testAccountingMoveCreateDataSave()
    {
       


            $model = new AccountingMove();
            
            $model->date_at = MipHelper::getCurrentDateDb();
            $model->label = 'CDCEPT';
            $model->ref_name = 'PAGO MANUAL';
            $model->ref_value = '0';
            $model->status = '6666';

           

        $model->save();


        

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
       
    }
    











    
}