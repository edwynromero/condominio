<?php


class CreateAccountingAccountTypeTest extends \Codeception\Test\Unit
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
    public function testAccountingAccountTypefailedEmpy()
    {
            $model = new AccountingAccountType();
            $model->key = '';
            $model->label ='';
            $model->is_debt='';
            
            
            $model->validate();
            
            $this->assertTrue($model->hasErrors(), 'Valores correctos');


            $msg=[
                'label'=>'Etiqueta no puede ser nulo.',
                'key'=>'Key no puede ser nulo.',                               
            ];

            

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

    public function testAccountingAccountTypeCreateDataSave()
    {
        $model = new AccountingAccountType;

        $model->key     =       '0202';
       
        $model->label   =       'CODTEST';
        $model->is_debt = 1;
        
        $model->save();

        $this->assertTrue($model->save(), 'Error no se almacenó en la base de datos');
        
   
       
    }
    



    /**
     * 
     * @param   Metodo dedicado a crear un registro repetido
     */

    public function testAccountingAccountTypeCreateDataSaveRepeat()
    {
        
       


    $model = new AccountingAccountType;
        $model->key     =       '0202';
        $model->label   =       'CODTEST';
        $model->is_debt = 1;
        
        
        


         $case=[
            'key'=>'key es repetido',
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