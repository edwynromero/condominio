<?php

class m170822_220748_change_database extends KMigration
{
    
    
	public function safeUp()
	{
            
            if( $this->backupDatabase() )
            {
                $this->executeScript( 'change_database.sql');
                
                AccountingJournalType::model()->deleteAll();
                $defaults = AccountingJournalType::getDefaults();
                foreach($defaults as $default){
                    if( is_null(AccountingJournalType::model()->findByPk( $default->key ) ) ){
                        
                        $default->created_at = MipHelper::getCurrentTimeStampDateDb();
                        
                        if( !$default->save() ){
                            echo CVarDumper::dumpAsString( $default->errors );
                            return false;
                        }
                    } 
                }
                 
                $this->writeLine("SUCESS UP;");

                return true;   
            }
            
            $this->writeLine("FAIL --- m170803_201148_change_database UP --- FAIL;");

            return false;
            
	}
        
        

	public function safeDown()
	{

            if( file_exists($this->getScriptPath() . 'backup.sql') )
            {
                $this->executeScript( 'backup.sql' );
                
                return true;
            }
                        
            $this->writeLine("FAIL --- " . get_class($this) . " UP --- FAIL;");

            return false;
	}


        
}