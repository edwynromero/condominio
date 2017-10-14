<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BankParser
 *
 * @author Koiosoft
 */
abstract class BankParser {
     
    const ROW_BEGIN_OPERATIONS = 0;
    const BUFFER_SIZE = 100;
    const DELIMITER = ";";
    const INITIAL_BALANCE_OPERATION_NUMBER = "0000000000000000";
    const FLOAT_EPSILON = 0.00001;
    
    
    /**
     *
     * @var BankAccountSummary 
     */
    private $bankSummary = null;
    private $data;
    private $row;
    private $col; 
    private $file;
    private $result;
    private $errors = array();
    private $entriesExecuted = array();
    private $lastPosition = 0;

    /**
     *
     * @var BankAccountEntry 
     */
    private $bankAccountEntry;
    
    
    /**
     * Return errors to Execute  Parser CVS File
     * 
     * @return array
     */
    public function getErrors(){
        return $this->errors;
    }
    
    
    /**
     * 
     * @param type $message
     * @param type $data
     */
    public function addError($message, $data){
        $this->errors[] = [ $message => $data ]; 
    }
    
    
    /**
     * Column Delimiter
     * 
     * @return string
     */
    public function getDelimiter(){
       return "|"; 
    }
    
    
    
    /**
     * Size from Buffer to Read CSV
     * 
     * @return int
     */
    public function bufferSize(){
        return 1000;
    }
    
    
    
    /**
     * 
     * @param type $bankSummary
     * @param type $file
     */
    public function __construct( $bankSummary, &$file ) {
        
        $this->bankSummary = $bankSummary;
        $this->file = $file;
    }
    
    
    /**
     * Acciones antes de ejecutar el procesamiento del CVS Bancario
     */
    protected function beforeExecute(){
        $this->errors = array();
        $this->entriesExecuted = array();
        $this->clear();
        
    }
    
    
    /**
     * Acciones luego de ejecutar el procesamiento del CVS Bancario
     */
    protected function afterExecute(){
        
        if( count($this->errors) > 0 ){
            $this->clear();
        }
        
    }
    
    
    /**
     * 
     */
    public function getRow(){
        return $this->row;
    }
    
    
    
    /**
     * 
     */
    public function getCol(){
        return $this->col;
    }
    
    
    /**
     * 
     * @return type
     */
    public function getData(){
        return $this->data;
    }
    
    
    /**
     * 
     * @return BankAccountEntry
     */
    public function getBankAccountEntry(){
        return $this->bankAccountEntry;
    }
    
    
    /**
     * 
     * @param date $date
     * @param int $month
     * @param int $day
     * @return boolean
     */
    protected function hasErrorDateEntry( $date ){
        return $date["month"] != $this->bankSummary->month ||  $date["year"] != $this->bankSummary->year;
    }
    
    
    /**
     * 
     * @return boolean
     */
    protected function validaExecute(){
        
        
        if( (count($this->entriesExecuted) - 1) <> ( $this->lastPosition  ) ){
            $this->addError( "Fail to proccess all Entries ", " Entries proccesed: " . count($this->entriesExecuted) . " from " . $this->lastPosition  ) ;
        }
        else if( !$this->hasErrors() ){
            
            $balance = 0;

            /* @var $entry BankAccountEntry */
            foreach(  $this->entriesExecuted as $entry ){

                switch( $entry->type ){
                    
                    case BankAccountEntry::CONST_TYPE_ENTRY_BALANCE:
                        $balance =  $entry->balance ;
                        break;
                    case BankAccountEntry::CONST_TYPE_ENTRY_INCOME:
                        $balance = $balance + $entry->value;        
                        break;
                    case BankAccountEntry::CONST_TYPE_ENTRY_OUTFLOW:         
                        $balance = $balance - $entry->value;             
                        break;       
                }


                if(   abs($balance - $entry->balance) > self::FLOAT_EPSILON ){
                    $this->addError( "Fail to process the Entry ",  array("balance" => $balance, "entry" =>  $entry   ) ) ;
                    break;
                }
                
                $beginDate = date_parse_from_format("Y-m-d", $entry->begin_date);
                $endDate = date_parse_from_format("Y-m-d", $entry->end_date );
                
                if(   $this->hasErrorDateEntry( $beginDate ) ||  $this->hasErrorDateEntry( $endDate ) ){
                    $this->addError( "Fail to process Date from Entry ",  array( "beginDate" => $beginDate, "entry" =>  $entry   ) ) ;
                }

            }
            
        }
        
        return !$this->hasErrors();
    }
    
    
    /**
     * 
     * @return integer
     */
    public function hasErrors(){
        return count($this->errors) > 0;
    }





    /**
     * 
     * @return bool
     */
    public function execute(){
        $this->beforeExecute();
        $this->result = false;                 
        if (($handle = fopen( $this->file, 'r')) !== false) {

            $this->data = null;
            $this->row = 0;
            while (( $this->data = fgetcsv($handle, $this->bufferSize(), $this->getDelimiter() )) !== false) {
                $this->beforeBizRule();    
                $colSize = count($this->data);
                for ($this->col=0; $this->col < $colSize; $this->col++) {           
                   $this->bizRule(); 
                }
                $this->afterBizRule();
                $this->row++;
            }
            fclose($handle);
            
        }   
        $this->afterExecute();
        
        return $this->validaExecute();
    }
    
    
    
    /**
     * 
     */
    public function clear(){
        
        if( !is_null( $this->bankSummary ) ){
            
            BankAccountEntry::model()->deleteAll(" bank_account_summary_id = :bank_account_summary_id ", array(":bank_account_summary_id" => $this->bankSummary->id )); 
        }
        
    }
    
    
    /**
     * 
     */
    public function initializeAccountEntry(){
        $this->bankAccountEntry = new BankAccountEntry();
    }
    
    
    /**
     * 
     */
    public function beforeBizRule(){
        
        if( $this->row >= $this->getRowToBeginOperations() ){     
            $this->initializeAccountEntry();
            $this->lastPosition = 0;
            $this->bankAccountEntry->bank_account_summary_id = $this->bankSummary->id;
            $this->bankAccountEntry->position = $this->row - $this->getRowToBeginOperations() + 1;
        }
        
    }
    
    
    /**
     * 
     */
    public function bizRule(){

    }
    
    
    /**
     * 
     */
    public function afterBizRule(){
        
        if( !empty($this->bankAccountEntry)){
            $this->entriesExecuted[] = $this->bankAccountEntry;
            
        }
       
        
        if( $this->row >= $this->getRowToBeginOperations() ){
            
            if( !$this->bankAccountEntry->save() ){
               
                $this->addError( "Fail at ROW: " . $this->row ,  $this->bankAccountEntry->getErrors() );
                
            }
            
        }
        
        $this->lastPosition = $this->row - $this->getRowToBeginOperations() + 1;

    }
    
    
    /**
     * 
     * @return integer
     */
    public function getRowToBeginOperations(){
        
        return 0;
        
    }
    
    
    /**
     * 
     * @return BankAccountSummary
     */
    public function getBankSummary(){
        return $this->bankSummary;
    }
    
    
    /**
     * Get DB First Day from Month
     * 
     * return string
     */
    public function getDBBeginDateOfMOnth(){
        return $this->bankSummary->year . "-" . $this->bankSummary->month . "-1";
    }
    
    
}
