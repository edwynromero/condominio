<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of m170606_155229_change_database
 *
 * @author Koiosoft <Team at www.koiosoft.com>
 */
class m170606_155229_change_database extends KMigration {

        
    /**
     * Ejecuta la migración
     * 
     * @return boolean
     */
    public function safeUp()
    {

        if( $this->backupDatabase() )
        {
            $this->executeScript( 'change_database.sql');

            return true;   
        }
        
        return false;

    }


    /**
     * Remueve la Migración y las operaciones
     * 
     * @return boolean
     */
    public function safeDown()
    {

        if( file_exists($this->getScriptPath() . 'backup.sql') )
        {
            $this->executeScript( 'backup.sql' );
        }

        return true ;
    }
    
    
}