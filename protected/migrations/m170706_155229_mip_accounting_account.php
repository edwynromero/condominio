<?php


/**
 * Se crean el Plan de Cuentas Contables inicial.
 * 
 */
class m170706_155229_mip_accounting_account extends KMigration
{
    
        /**
         * Ejecuta la migración
         * 
         * @return boolean
         */
	public function safeUp()
	{
            
            $this->executeScript( 'migracion_tipo_de_cuentas.sql' );
            $this->executeScript( 'migracion_plan_de_cuentas.sql' );
            
            return true;
	}
        
        
        /**
         * Remueve la Migración y las operaciones
         * 
         * @return boolean
         */
	public function safeDown()
	{

            $this->execute("SET FOREIGN_KEY_CHECKS=0");
            $this->execute("TRUNCATE mip_accounting_account;");
            $this->execute("TRUNCATE mip_accounting_account_type;");
            $this->execute("TRUNCATE mip_accounting_move;");
            $this->execute("TRUNCATE mip_accounting_move_line;");
            $this->execute("SET FOREIGN_KEY_CHECKS=1");
            
            return true;
	}

}