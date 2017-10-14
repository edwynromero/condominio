<?php


class CreateAccountingAccountTest extends \Codeception\Test\Unit
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
    public function testAccountingAccountfailedEmpy()
    {
            $model = new AccountingAccount();
            $model->parent_account_id = '';
            $model->type = '1111';

            $model->code = "";
            $model->label = "";

            $model->debt = "";
            $model->credt = "";
            $model->balance = "";
            $model->updated_at =  MipHelper::getCurrentTimeStampDateDb();
            $model->access_key  = '1234';
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                
                'code'=>'Código no puede ser nulo.', 
                'label'=>'Etiqueta no puede ser nulo.',
                'debt' =>'Debe no puede ser nulo.',
                'credt'=>'Haber no puede ser nulo.',
                'balance'=>'Balance no puede ser nulo.'                              
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

    public function testAccountingAccountCreateDataSave()
    {
       


           $model = new AccountingAccount();
            $model->parent_account_id = '';
            $model->type = '1111';

            $model->code=12345;
            $model->label='ACTIVO CODECEPT';

            $model->debt='0.00';
            $model->credt='0.00';
            $model->balance='0.00';
            $model->updated_at = MipHelper::getCurrentTimeStampDateDb();
            $model->access_key='1234';

        $model->save();

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
   
       
    }
    



    /**
     * 
     * @param   Metodo dedicado a crear un registro repetido
     */

    public function testAccountingAccountTypeCreateDataSaveRepeat()
    {
        
       

           $model = new AccountingAccount();
            $model->parent_account_id = '';
            $model->type = '1111';

            $model->code=12345;
            $model->label='ACTIVO CODECEPT';

            $model->debt='0.00';
            $model->credt='0.00';
            $model->balance='0.00';
            $model->updated_at = MipHelper::getCurrentTimeStampDateDb();
            $model->access_key='1234';

        
        
        


         $case=[
            'code'=>'Código es repetido',
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