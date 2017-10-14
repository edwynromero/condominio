<?php


class BankAccountEntryCreateFormModelTest extends \Codeception\Test\Unit
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

    // tests to validate data 
     public function testBankAccountEntryCreateFailed()
    {   
        /**
        *
        *  Validan los campos Nulos del Modelo
        *
        **/
        $case = [
            "begin_date" => "",
            "end_date" => "",
            "number" => "",
            "summary" => "",
            "value" => "",
            "type" => "",
            "bank_account_summary_id" => "",
        ];

        $model                             = new BankAccountEntry();  
        $model->begin_date                 = $case['begin_date'];
        $model->end_date                   = $case['end_date'];
        $model->number                     = $case['number'];
        $model->summary                    = $case['summary'];
        $model->value                      = $case['value'];
        $model->type                       = $case['type'];
        $model->bank_account_summary_id    = $case['bank_account_summary_id']; 

        $model->validate();

        $this->assertTrue( $model->hasErrors(), "Los valores introducidos no son nulos");   
        

        //
        //   Validar los errores en los Campos definidos como nulos
        //   
        $findme = strtoupper("nulo");
        $fail = false;
        $field = "";


        foreach( $case as $key => $value ){

            $field = $key;

            if( isset($model->errors[$key]) )
            {
                $errors = $model->errors[$key];
                $fail = true;
                foreach($errors as $messageError ){

                    if( strpos(strtoupper($messageError), $findme) > -1 ){
                        $fail = false;
                        break;
                    }
                }
            }
            else{
                $fail = true;
                break;
            }

        }

        //
        //  Validar que el Mensaje de Error es correcto
        //
        $this->assertFalse( $fail, " Existe al menos un campo con el mensaje NULO incorrecto.  Campo: $key");    
        
        //Validar que la fecha de inicio es menor o igual que la fecha final 

        $case = [
            "begin_date" => "2017-06-05",
            "end_date" => "2017-05-05",
            "number" => "015655530",
            "summary" => "PRUEBA",
            "value" => "5000.05",
            "type" => "I",
            "bank_account_summary_id" => "54",
        ];  

        $model                             = new BankAccountEntry();  
        $model->begin_date                 = $case['begin_date'];
        $model->end_date                   = $case['end_date'];
        $model->number                     = $case['number'];
        $model->summary                    = $case['summary'];
        $model->value                      = $case['value'];
        $model->type                       = $case['type'];
        $model->bank_account_summary_id    = $case['bank_account_summary_id']; 

        $model->validate();

        $this->assertTrue( $model->hasErrors(), "Fecha de inicio menor o igual a fecha final");  
     
        //Validar que type acepte solo los valores 'I', 'O' or 'B'  

        $case = [
            "begin_date" => "2017-05-05",
            "end_date" => "2017-05-05",
            "number" => "015655530",
            "summary" => "PRUEBA",
            "value" => "5000.05",
            "type" => "B",
            "bank_account_summary_id" => "54",
            
        ];  

        $model                             = new BankAccountEntry();  
        $model->begin_date                 = $case['begin_date'];
        $model->end_date                   = $case['end_date'];
        $model->number                     = $case['number'];
        $model->summary                    = $case['summary'];
        $model->value                      = $case['value'];
        $model->type                       = $case['type'];
        $model->bank_account_summary_id    = $case['bank_account_summary_id']; 

        $model->validate();

        
        $this->assertTrue( $model->hasErrors(), "Valor type correcto");  
           
    }
}