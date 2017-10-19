<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of KMigration
 *
 * @author Koiosoft <Team at www.koiosoft.com>
 */
class KCommand  extends CConsoleCommand {
    //put your code here
    
    private $path_migrations = null;
    private $_command = null;
    
    
    /**
     * Script Path from Migrations
     * 
     * @param object $migration
     * @return string
     */
    protected function getScriptPath(){
        
        if(is_null($this->path_migrations)){
            $this->path_migrations = Yii::getPathOfAlias('application').DIRECTORY_SEPARATOR."data".DIRECTORY_SEPARATOR.$this->getName().DIRECTORY_SEPARATOR;
        }
        return $this->path_migrations;
    }
    
    
    /**
     * Relative to Script Folder Migration
     * 
     * @param string $scriptName
     */
    protected function executeScript($scriptPath){
        
        $script_content = file_get_contents( $this->getScriptPath() . $scriptPath);
        if(empty($script_content)){
            return false;
        }
        
        try {
            $this->writeLine( "Antes del SCRIPT:  " . $scriptPath);
            $this->execute(file_get_contents( $this->getScriptPath() . $scriptPath));
            $this->writeLine( "Despues del SCRIPT");
        } catch (Exception $ex) {
            throw  $ex;
        }
        
    }
    
    
    /**
     * 
     * @return CDbCommand
     */
    protected  function getCommand(){
        if(is_null($this->_command)){
            $this->_command = $this->getDbConnection()->createCommand();
        }
        return $this->_command;
    }
    
    /**
     * 
     * @param type $params
     */
    protected function execute($sql, $params=array()){
        
        $command = $this->getCommand();
        $command->text = $sql;
        $command->execute( $params);

    }


    /**
     * Realiza un Backup de la Base de Datos
     * 
     * @param string $backupName Nombre del Archivo
     * @return boolean
     */
    protected function backupDatabase($backupName = "backup.sql" ){
        
        
        $continue = true;
        $backupFile =  $this->getScriptPath() . $backupName;
        
        if( file_exists($backupFile) ){
            $continue = unlink($backupFile);     
        }
        
        if( $continue ){
            
            $databaseName =  $this->getDbConnection()->createCommand("SELECT DATABASE()")->queryScalar();
            exec('mysqldump -u ' . DB_USER . ' -p' . DB_PASS . ' ' . $databaseName . ' > ' . $this->getScriptPath() . $backupName );
            
            return true;
        }
        
        return false;
        
    }
    
    
    /**
     * 
     * @param string $message
     */
    protected function writeLine($message){
        echo $message . " \n";
    }
    
    
    /**
     * 
     * @return CDbConnection
     */
    public function getDbConnection(){
        return Yii::app()->getDb();
    }
    
    
}