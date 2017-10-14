<?php

class m170803_201148_change_database extends KMigration
{
    
    
	public function safeUp()
	{
            
            if( $this->backupDatabase() )
            {
                $this->executeScript( 'change_database.sql');
                
                AccountingMoveRefType::model()->deleteAll();
                $defaults = AccountingMoveRefType::getDefaults();
                foreach($defaults as $default){
                    if( is_null(AccountingMoveRefType::model()->findByPk( $default->key ) ) ){
                        if( !$default->save() ){
                            echo CVarDumper::dumpAsString( $default->errors );
                            return false;
                        }
                    } 
                }
                
                AccountingMoveStatus::model()->deleteAll();
                $defaults = AccountingMoveStatus::getDefaults();
                foreach($defaults as $default){
                    if( is_null(AccountingMoveStatus::model()->findByPk( $default->key ) ) ){
                        if( !$default->save() ){
                            echo CVarDumper::dumpAsString( $default->errors );
                            return false;
                        }
                    } 
                }
                

                AccountingPeriodStatus::model()->deleteAll();
                $defaults = AccountingPeriodStatus::getDefaults();
                foreach($defaults as $default){
                    if( is_null(AccountingPeriodStatus::model()->findByPk( $default->key ) ) ){
                        if( !$default->save() ){
                            echo CVarDumper::dumpAsString( $default->errors );
                            return false;
                        }
                    } 
                } 
                 
                echo "paso por aca final";

                return true;   
            }
            
            echo "FAIL --- m170803_201148_change_database UP --- FAIL .\n";

            return false;
            
	}
        
        

	public function safeDown()
	{

            if( file_exists($this->getScriptPath() . 'backup.sql') )
            {
                $this->executeScript( 'backup.sql' );
                
                return true;
            }
            
            echo "FAIL --- m170803_201148_change_database does not support migration DOWN  --- FAIL .\n";

            return false;
	}


        
}