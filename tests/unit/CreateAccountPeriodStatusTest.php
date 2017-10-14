<?php


class CreateAccountPeriodStatusTest extends \Codeception\Test\Unit
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
    public function testAccountPeriodStatusfailedEmpy()
    {
            $model = new AccountingPeriodStatus();
            
            $model->key = '';
            $model->label = '';
            $model->at_year='';
            $model->at_period='';
            $model->updated_at=MipHelper::getCurrentTimeStampDateDb();

            
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                
                'key'=>'Key no puede ser nulo.', 
                'label'=>'Etiqueta no puede ser nulo.',
                'at_period' => 'En Periodo no puede ser nulo.',
                'at_year' => ' En Año no puede ser nulo.',
                                             
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

    public function testAccountPeriodStatusCreateDataSave()
    {
       


            $model = new AccountingPeriodStatus();
            $model->key = '6666';
            $model->label = 'CDCEPT';
            $model->at_year = 1;
            $model->at_period = 0;
            $model->updated_at=MipHelper::getCurrentTimeStampDateDb();

        $model->save();


        

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
   
       
    }
    










    /**
     * 
     * @param   Metodo dedicado a crear un registro repetido
     */

    public function testAccountPeriodStatusTypeCreateDataSaveRepeat()
    {
        
       

            
            $model = new AccountingPeriodStatus();
            $model->key = '6666';
            $model->label = 'CDCEPT';
            $model->at_year = 1;
            $model->at_period = 0;
            $model->updated_at=MipHelper::getCurrentTimeStampDateDb();
        


         $case=[
            'key'=>'Key es repetido',
            'label'=>'Etiqueta es repetido',
            
        ];
        


         $fail=true;

         $model->scenario = 'create';
         $model->validate();

         $this->assertTrue($model->hasErrors(), "No tiene errores");



        foreach($case as $key=>$value)
        {
            if(strcmp($value, $model->errors[$key][0])!==0)
            {
                $fail=false;
                $this->assertTrue($fail, "Campo ".$key." con valor proporcionado '".$value."' reglas a seguir '".$model->errors[$key][0]."'");
            }
                
                
                
        }


    }


    
}