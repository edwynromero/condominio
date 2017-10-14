<?php


class CreateFiscalYearTest extends \Codeception\Test\Unit
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
    /**
     * 
     * @param   Metodo con informacion erronea dedicado a fallar con campos vacios
     */
    public function testFiscalYearfailedEmpy()
    {
            $model = new FiscalYear();
            
            
            $model->label = '';
            $model->from ='';
            $model->to ='';
          
           
            $model->status ='';

            $model->updated_at=MipHelper::getCurrentTimeStampDateDb();
            $model->is_closed =0;
            
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                
                'label'=>'Etiqueta no puede ser nulo.', 
                'from'=>'Desde no puede ser nulo.',
                'to' => "Hasta no puede ser nulo.",
                
                'status'=> 'Estatus no puede ser nulo.' 
                                             
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

    public function testFiscalYearCreateDataSave()
    {
       

            $model = new FiscalYear();
            
            
            $model->label = 'CODECEPT';
            $model->from = MipHelper::parseDateToDb('28/07/2017');
            $model->to = MipHelper::parseDateToDb('28/07/2017');;
            $model->is_closed =0;
           
            $model->status ='111';

            $model->updated_at=MipHelper::getCurrentTimeStampDateDb();

            $model->save();


        

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
   
       
    }
    






}