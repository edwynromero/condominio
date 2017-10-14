<?php


class CreateAccountingAliasTest extends \Codeception\Test\Unit
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
    public function testAccountingAliasCreateFailedEmpty()
    {
        $model = new AccountingAlias;
        $model->key     =       '';
        $model->label   =       '';
        $model->alias   =       'TEST';
        $model->access_key ='';
        
        $model->validate();
        $this->assertTrue($model->hasErrors(), "Campos correctos");


         $case=[
            'key'=>'Key no puede ser nulo.',
            'label'=>'Etiqueta no puede ser nulo.',
            
        ];
        
         $fail=true;



        foreach($case as $key=>$value)
        {
            if(strcmp($value, $model->errors[$key][0])!==0)
            {
                $fail=false;
                $this->assertTrue($fail, "Campo ".$key." con valor proporcionado '".$value."' reglas a seguir '".$model->errors[$key][0]."'");
            }
                
                
                
        }


       
    }
    
    
    
    

    public function testAccountingAliasCreateDataSave()
    {
        $model = new AccountingAlias;

        $model->key     =       '0202';
        $model->account_id      =     12;
        $model->label   =       'CODTEST';
        $model->alias   =       'CODTEST';
        $model->access_key ='TEST';
        
        $model->save();

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
   
       
    }
    




    public function testAccountingAliasCreateDataSaveRepeat()
    {
        
       



       $model = new AccountingAlias;
        $model->key     =       '0202';
        $model->account_id   =       12;
        $model->label = 'CODTEST';
        $model->alias   =       'CODTEST';
        $model->access_key ='CODTEST';
        
     


        $fail=true;

         $model->scenario = 'create';
         $model->validate();

         $this->assertTrue($model->hasErrors(), "No tiene errores");

         $case=['key'=>'Key es repetido',
         

         ];



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