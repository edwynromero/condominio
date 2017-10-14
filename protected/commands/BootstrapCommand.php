<?php
class BootstrapCommand  extends KCommand {
    //put your code here
    
    const STATUS_FAIL = 0;
    const STATUS_SUCESS = 1;
    public $defaultAction   = "Mirador";

    /**
     * 
     * @param \FiscalYear $fiscalYear
     */
    private function fillYearsPeriods($fiscalYear){
        
        $d = date_parse_from_format("Y-m-d", $fiscalYear->to);
        $year =  $d["year"];
        for( $month = 1; $month <=12; $month++ ){
            
            $query_date = $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT)  . '-01' ;
            $date = new DateTime($query_date);
            
            //First day of month
            $date->modify('first day of this month');
            $firstday= $date->format('Y-m-d');
            
            //Last day of month
            $date->modify('last day of this month');
            $lastday= $date->format('Y-m-d');
            
            $label  = str_pad($month, 2, "0", STR_PAD_LEFT);
            
            if( $fiscalYear->status == AccountingPeriodStatus::defaultStatusOpen()->key ) { 
                
                $curren_month = date('m');
                $status = $curren_month <= $month ? AccountingPeriodStatus::defaultStatusOpen()->key :AccountingPeriodStatus::defaultStatusClosed()->key ;

            }
            else{
                $status = $fiscalYear->status;
            }
            
            $label  = $year . '-' . str_pad($month, 2, "0", STR_PAD_LEFT);
            
            $period = AccountingPeriod::create( $label, $firstday, $lastday, $status, $fiscalYear);
            
            if( !$period->save() )
            {
                throw new Exception( "Falla guardando el Año Fiscal $label detalle: " . CVarDumper::dumpAsString( $period->getErrors() ) );
            }
    
        }
        
        
    }
    
    
    
    /**
     * 
     * @param type $label
     * @param type $from
     * @param type $to
     * @param type $status
     */
   
    private function createAccountingJournal($code, $title, $note, $credt_accounting_id, $debt_accounting_id, $journal_type)
    {
        $accountingJournal = AccountingJournal::model()->find("code = :code" , array(":code"=>$code));

        if(is_null($accountingJournal)){
            $accountingJournal = new AccountingJournal();
            $accountingJournal->code = $code;
            $accountingJournal->title = $title;
            $accountingJournal->note = $note;
            $accountingJournal->credt_account_id = $credt_accounting_id;
            $accountingJournal->debt_account_id = $debt_accounting_id;
            $accountingJournal->journal_type = $journal_type;
            $accountingJournal->created_at = MipHelper::getCurrentTimeStampDateDb();
            $accountingJournal->updated_at = MipHelper::getCurrentTimeStampDateDb();  
          
        
            if($accountingJournal->save() )
            {
                return $accountingJournal;
                
            }
        throw new Exception("Falla guardando los libros diarios $title detalle" . CVarDumper::dumpAsString($accountingJournal->getErrors() ) );
            
         }
        return $accountingJournal;        
    }
    
    private function fillJournal()
    {
        $accountingJournals = [];
        
        $accountingJournals[] = $this->createAccountingJournal("IC202","Diario Ingresos por Condominio","Factura de Condominio",163,219,"J011");
        $accountingJournals[] = $this->createAccountingJournal("S202", "Diario Salarios","Pago sueldo empleados",98, 20, "J021");
        $accountingJournals[] = $this->createAccountingJournal("CC202", "Diario Caja Chica", "caja chica", 217, 16, "J021");
        $accountingJournals[] = $this->createAccountingJournal("L202", "Liquidacion", "Pago de liquidacion ", 218, 20, "J021");
        $accountingJournals[] = $this->createAccountingJournal("U202", "Utilidades", "Pago de utilidades", 103, 20, "J021");
        $accountingJournals[] = $this->createAccountingJournal("BV202", "Bono Vacacional", "Pago de bono vacacional", 102, 20, "J021");
        $accountingJournals[] = $this->createAccountingJournal("JB001", "Diario Compras", "Pago de compras", 217, 20, "J020");
    
        foreach ($accountingJournals as $accountingJournal){
        }
    }
    
    private function createFiscalYear($label, $from, $to, $status ){
        
        
        $fiscalYear = FiscalYear::model()->find("`from` = :from OR `to` = :to", array(":from"=>$from, ":to"=>$to, ));
                
        if( is_null( $fiscalYear ) ){
            
            $fiscalYear             = new FiscalYear();
            $fiscalYear->label      = $label;
            $fiscalYear->from       = $from;
            $fiscalYear->to         = $to;
            $fiscalYear->status     = $status;
            $fiscalYear->is_closed  = $status == AccountingPeriodStatus::defaultStatusOpen()->key ? 0 : 1;
            $fiscalYear->created_at = MipHelper::getCurrentTimeStampDateDb();
            $fiscalYear->updated_at = MipHelper::getCurrentTimeStampDateDb();
   
            if( $fiscalYear->save() )
            {
                return $fiscalYear; 
            }

            throw new Exception( "Falla guardando el Año Fiscal $label detalle: " . CVarDumper::dumpAsString( $fiscal->getErrors() ) );
        }
        
        return $fiscalYear; 
        
    }

    /**
     * 
     */
    private function fillYearsFrom2014To2017(){
        
        $fiscalYears = [];
                
        $fiscalYears[] = $this->createFiscalYear("2014", "2014-01-01", "2014-12-31", AccountingPeriodStatus::defaultStatusClosed()->key);
        $fiscalYears[] = $this->createFiscalYear("2015", "2015-01-01", "2015-12-31", AccountingPeriodStatus::defaultStatusClosed()->key);
        $fiscalYears[] = $this->createFiscalYear("2016", "2016-01-01", "2016-12-31", AccountingPeriodStatus::defaultStatusClosed()->key);
        $fiscalYears[] = $this->createFiscalYear("2017", "2017-01-01", "2017-12-31", AccountingPeriodStatus::defaultStatusOpen()->key);

        foreach($fiscalYears as $fiscalYear){
            $this->fillYearsPeriods($fiscalYear);
        }
        
    }
    
    
   
    
   
    private function createUploadTmp($cod_libros, $concepto, $fecha){    
       
        /*$tmpAccounting = TmpUploadDataAccounting::model()->find("`cod_libros` = :cod_libros OR `concepto` = :concepto OR `fecha` = :fecha", array(":cod_libros"=>$cod_libros, ":concepto"=>$concepto, ":fecha"=>$fecha));
       
        if( is_null( $tmpAccounting ) ){
            
            $tmpAccounting = new AccountingMove();
            $tmpAccounting->cod_libros = $cod_libros;
            $tmpAccounting->concepto = $concepto;
            $tmpAccounting->fecha = $fecha;
         
    
            
        }*/
        $tmpAccounting = TmpUploadDataAccounting::model()->findAll();
        if (is_null($tmpAccounting)){
            
            foreach ($tmpAccounting as $key=>$object){
                
                $accountingMove = new AccountingMove();
                $accountingMove->cod_libros = $object->cod_libros;
                $accountingMove->concepto = $object->concepto;
                $accountingMove->fecha = $object->fecha;
                
                if (!$accountingMove->save()){
                    echo $accountingMove->cod_libros;
                }
            }
            
        }
   
      }
      
    
    
    
    
        
        
    
    
    
    /**
     * 
     * Ejecuta la acción para iniciar a Mirador
     * 
     * @param integer $production 1|0 Corre en modo producción o desarrollo
     */
    public function actionMirador($production=0){
        
        if(!$production){
            
            $transaction = $this->getDbConnection()->beginTransaction();

            try
            {
               
            
                
                $this->fillYearsFrom2014To2017();
                //$this->executeScript("/mirador/scripts/plan_de_cuentas.sql");
                //$this->fillJournal();
                //$this->createUploadTmp();
                $transaction->commit();
            
            } catch (Exception $ex) {

                $transaction->rollback();
                
                $this->writeLine( "ROLLBACK " . $ex->getMessage() );
                
                return self::STATUS_SUCESS;
            }

        }
        
        return self::STATUS_SUCESS;
                
    }
    
    
}