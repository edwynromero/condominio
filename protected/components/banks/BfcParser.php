<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BfcBankProcessor
 *
 * @author Koiosoft
 */
class BfcParser  extends BankParser{

    const ROW_INITIAL_BALANCE = 1;
    const ROW_BEGIN_OPERATIONS = 2;
    const BUFFER_SIZE = 1000;
    const DELIMITER = "|";

    const COL_DATE_BEGIN    = 0;
    const COL_DATE_END      = 1;
    const COL_NUMBER        = 2;
    const COL_SUMMARY       = 3;
    const COL_OUTFLOW       = 4;
    const COL_INCOME        = 5;    
    const COL_BALANCE       = 6;
    
    
    /**
     * Column Delimiter
     * 
     * @return string
     */
    public function getDelimiter(){
       return self::DELIMITER; 
    }
    
    
    
    /**
     * Size from Buffer to Read CSV
     * 
     * @return int
     */
    public function bufferSize(){
        return self::BUFFER_SIZE;
    }
    
        
    /**
     * 
     * @return integer
     */
    public function getRowToBeginOperations(){
        
        return self::ROW_BEGIN_OPERATIONS;
        
    }
    
    
    /**
     * Antes de ejecutar las acciones de negocio con las Operaciones de la Cuenta
     */
    public function beforeBizRule(){

        if( $this->getRow() == self::ROW_INITIAL_BALANCE ){     
            
            $this->initializeAccountEntry();
            $this->getBankAccountEntry()->position = 0;
            
        }

        parent::beforeBizRule();
        
    }
    
    
    /**
     * 
     * @param type $row
     * @param type $col
     * @param type $data
     */
    public function bizRule(){
        
        if( $this->getRow() == self::ROW_INITIAL_BALANCE ){   
            
            $data = $this->getData();
            
            $colValue = $data[ $this->getCol() ];
            
            $this->getBankAccountEntry()->begin_date = parent::getDBBeginDateOfMOnth();
            $this->getBankAccountEntry()->end_date = parent::getDBBeginDateOfMOnth();
            $this->getBankAccountEntry()->number = self::INITIAL_BALANCE_OPERATION_NUMBER;
            $this->getBankAccountEntry()->summary = MipHelper::t("Initial Balance of Month") . " " . self::INITIAL_BALANCE_OPERATION_NUMBER;
            $this->getBankAccountEntry()->type = BankAccountEntry::CONST_TYPE_ENTRY_BALANCE;
            $this->getBankAccountEntry()->value = 0;
            $this->getBankAccountEntry()->balance = MipHelper::formatNumberToDb( $colValue );
            $this->getBankAccountEntry()->bank_account_summary_id = $this->getBankSummary()->id;     
            
        }  
        

        
 
        //
        //  Se ejecutan las operaciones
        //
        if( $this->getRow() >= self::ROW_BEGIN_OPERATIONS ){
            
            $data = $this->getData();
            
            $colValue = $data[ $this->getCol() ];

            //  Se obtiene la Fecha de Inicio
            if( $this->getCol() == self::COL_DATE_BEGIN ){
                $this->getBankAccountEntry()->begin_date = MipHelper::parseDateToDb( $colValue );
            }
            
            //  Se obitnee la Fecha de Ejecucion
            if( $this->getCol() == self::COL_DATE_END ){
                $this->getBankAccountEntry()->end_date = MipHelper::parseDateToDb( $colValue );
            }
            
            //  Se obitnee la Numero Operacion
            if( $this->getCol() == self::COL_NUMBER ){
                $this->getBankAccountEntry()->number = $colValue;
            }
            
            //  Se obtiene el resumen de la operacion
            if( $this->getCol() == self::COL_SUMMARY ){
                $this->getBankAccountEntry()->summary = $colValue;
            }
            
            //  verifica si es una operacion de Ingresos
            if( $this->getCol() == self::COL_INCOME && $colValue != '' ){
                $this->getBankAccountEntry()->type = BankAccountEntry::CONST_TYPE_ENTRY_INCOME;
                $this->getBankAccountEntry()->value = MipHelper::formatNumberToDb( $colValue );
            }
            
            //  verifica si es una operacion de Egresos
            if( $this->getCol() == self::COL_OUTFLOW && $colValue != '' ){
                $this->getBankAccountEntry()->type = BankAccountEntry::CONST_TYPE_ENTRY_OUTFLOW;
                $this->getBankAccountEntry()->value = MipHelper::formatNumberToDb( $colValue );
            }    
    
            //  Se obtiene el resumen de la operacion
            if( $this->getCol() == self::COL_BALANCE ){
                $this->getBankAccountEntry()->balance = MipHelper::formatNumberToDb( $colValue );
            }

        }
        
    }
    
    
    /**
     * Accion para cada entrada de Operaciones despues de Procesar la linea CSV
     */
    public function afterBizRule(){
        
        if( $this->getRow() >= self::ROW_INITIAL_BALANCE ){
            
            if( !$this->getBankAccountEntry()->save() ){
               
                $this->addError( "Fail at Row Balance", $this->getBankAccountEntry()->getErrors() );
                
            }
            
        }
        
        parent::afterBizRule();

    }
    
    
}
