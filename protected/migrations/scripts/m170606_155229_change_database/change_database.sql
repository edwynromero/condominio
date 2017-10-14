


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


--
--  Crea la tabla de Resumen de Transacciones  Mensuales
--

DROP TABLE IF EXISTS `mip_bank_account_entry`;

CREATE TABLE IF NOT EXISTS `mip_bank_account_summary` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `month` INT NOT NULL,
  `year` INT NOT NULL,
  `data` TEXT NULL,
  `file_name` TEXT NULL,
  `bank_account_id` INT(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `uk_unique_month_year` (`month` ASC, `year` ASC),
  INDEX `fk_mip_bank_account_summary_mip_bank_account1_idx` (`bank_account_id` ASC),
  CONSTRAINT `fk_mip_bank_account_summary_mip_bank_account1`
    FOREIGN KEY (`bank_account_id`)
    REFERENCES `mip_bank_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



--
--  Crea la tabla de Detalle Transacciones Mensuales
--

DROP TABLE IF EXISTS `mip_bank_account_entry`;

CREATE TABLE IF NOT EXISTS `mip_bank_account_entry` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `begin_date` DATE NOT NULL,
  `end_date` DATE NOT NULL,
  `number` VARCHAR(16) NOT NULL,
  `summary` VARCHAR(255) NOT NULL,
  `value` DECIMAL(10,2) NOT NULL,
  `type` VARCHAR(1) NOT NULL,
  `bank_account_summary_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mip_bank_account_entry_mip_bank_account_summary1_idx` (`bank_account_summary_id` ASC),
  UNIQUE INDEX `number_UNIQUE` (`number` ASC),
  CONSTRAINT `fk_mip_bank_account_entry_mip_bank_account_summary1`
    FOREIGN KEY (`bank_account_summary_id`)
    REFERENCES `mip_bank_account_summary` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
--  Definido el Access Key de la Entidad Bancaria
--
UPDATE `mip_bank` SET `akey`='BFC' WHERE `id`='22';
UPDATE `mip_bank` SET `akey`='CIE' WHERE `id`='1';
UPDATE `mip_bank` SET `akey`='ACT' WHERE `id`='2';
UPDATE `mip_bank` SET `akey`='MER' WHERE `id`='3';
UPDATE `mip_bank` SET `akey`='VEN' WHERE `id`='4';
UPDATE `mip_bank` SET `akey`='BBV' WHERE `id`='5';
UPDATE `mip_bank` SET `akey`='BAN' WHERE `id`='6';
UPDATE `mip_bank` SET `akey`='BCA' WHERE `id`='7';
UPDATE `mip_bank` SET `akey`='BAV' WHERE `id`='8';
UPDATE `mip_bank` SET `akey`='CAR' WHERE `id`='9';
UPDATE `mip_bank` SET `akey`='BES' WHERE `id`='10';
UPDATE `mip_bank` SET `akey`='BTE' WHERE `id`='11';
UPDATE `mip_bank` SET `akey`='EXT' WHERE `id`='12';
UPDATE `mip_bank` SET `akey`='GUY' WHERE `id`='13';
UPDATE `mip_bank` SET `akey`='BID' WHERE `id`='14';
UPDATE `mip_bank` SET `akey`='BNC' WHERE `id`='15';
UPDATE `mip_bank` SET `akey`='BOD' WHERE `id`='16';
UPDATE `mip_bank` SET `akey`='BPL' WHERE `id`='17';
UPDATE `mip_bank` SET `akey`='BSO' WHERE `id`='18';
UPDATE `mip_bank` SET `akey`='BPL' WHERE `id`='19';
UPDATE `mip_bank` SET `akey`='COB' WHERE `id`='20';
UPDATE `mip_bank` SET `akey`='CIT' WHERE `id`='21';
UPDATE `mip_bank` SET `akey`='BSU' WHERE `id`='23';
UPDATE `mip_bank` SET `akey`='BPU' WHERE `id`='25';


--
--  Se crea el ROL de Finanazas
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('finance', '2', 'Rol Finanzas', NULL, 'N;');


--
--  Se crea el Operacion Resumen Cuentas Bancarias
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.bankAccountSummary.*', '0', 'Backend - Resumen Cuentas Bancarias ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.bankAccountSummary.*');

--
--  Se crea el Operacion Resumen Cuentas Bancarias
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.bankAccountSummary.index', '0', 'Backend - Resumen Cuentas Bancarias ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.bankAccountSummary.index');


DELETE FROM `mip_auth_item_child` WHERE `parent` = 'finance' AND `child` = 'backend.bankAccountSummary.index';
DELETE FROM `mip_auth_item` WHERE `name` =  'backend.bankAccountSummary.index';



ALTER TABLE `mip_bank_account_entry` 
ADD COLUMN `position` INT NOT NULL AFTER `type`,
ADD COLUMN `balance` DECIMAL(10,2) NOT NULL AFTER `position`;

ALTER TABLE mip_bank_account_entry DROP INDEX number_UNIQUE;


--
--  Tipo de Cuenta Contable
--

DROP TABLE IF EXISTS `mip_accounting_account_type`;


CREATE TABLE IF NOT EXISTS `mip_accounting_account_type` (
  `key` CHAR(4) NOT NULL,
  `label` VARCHAR(64) NOT NULL,
  `is_debt` TINYINT(1) NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE INDEX `accounting_account_type_label_UNIQUE` (`label` ASC),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC))
ENGINE = InnoDB;


--
--   Estatus de los Periodos y Años Fiscales
--


DROP TABLE IF EXISTS `mip_account_period_status`;


CREATE TABLE IF NOT EXISTS `mip_account_period_status` (
  `key` CHAR(4) NOT NULL,
  `label` VARCHAR(64) NOT NULL,
  `at_year` TINYINT(1) NOT NULL,
  `at_period` TINYINT(1) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  UNIQUE INDEX `account_period_status_label_UNIQUE` (`label` ASC),
  PRIMARY KEY (`key`),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC))
ENGINE = InnoDB;


--
--  Año fiscal
--

DROP TABLE IF EXISTS `mip_fiscal_year`;

CREATE TABLE IF NOT EXISTS `mirador_remoto`.`mip_fiscal_year` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(64) NOT NULL,
  `from` DATE NOT NULL,
  `to` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  `is_closed` TINYINT(1) NOT NULL,
  `status` CHAR(4) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_fiscal_year_maccount_period_status1_idx` (`status` ASC),
  CONSTRAINT `fk_fiscal_year_account_period_status1`
    FOREIGN KEY (`status`)
    REFERENCES `mip_account_period_status` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


--
--  Periodo Fiscal
--


DROP TABLE IF EXISTS `mip_accounting_period`;

CREATE TABLE IF NOT EXISTS `mip_accounting_period` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(64) NOT NULL,
  `from` DATE NOT NULL,
  `to` DATE NOT NULL,
  `fiscal_year_id` INT NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `status` CHAR(4) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_accounting_period_fiscal_year1_idx` (`fiscal_year_id` ASC),
  INDEX `fk_accounting_period_account_period_status1_idx` (`status` ASC),
  UNIQUE INDEX `accounting_period_label_UNIQUE` (`label` ASC),
  CONSTRAINT `fk_accounting_period_fiscal_year1`
    FOREIGN KEY (`fiscal_year_id`)
    REFERENCES `mip_fiscal_year` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accounting_period_account_period_status1`
    FOREIGN KEY (`status`)
    REFERENCES `mip_account_period_status` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


--
--  Estatus Movimientos Contables
--

DROP TABLE IF EXISTS `mip_accounting_move_status`;

CREATE TABLE IF NOT EXISTS `mip_accounting_move_status` (
  `key` CHAR(4) NOT NULL,
  `label` VARCHAR(64) NOT NULL,
  UNIQUE INDEX `accounting_move_status_label_UNIQUE` (`label` ASC),
  PRIMARY KEY (`key`),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC))
ENGINE = InnoDB;

DROP TABLE IF EXISTS `mip_accounting_move`;


--
--   Movimientos Contables
--

CREATE TABLE IF NOT EXISTS `mip_accounting_move` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `label` VARCHAR(128) NOT NULL,
  `date_at` DATE NOT NULL,
  `ref_name` VARCHAR(64) NOT NULL,
  `ref_value` VARCHAR(64) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `status` CHAR(4) NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_accounting_move_accounting_move_status1_idx` (`status` ASC),
  CONSTRAINT `fk_accounting_move_accounting_move_status1`
    FOREIGN KEY (`status`)
    REFERENCES `mip_accounting_move_status` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



--
--   Cuentas Contables
--

DROP TABLE IF EXISTS `mip_accounting_account`;

CREATE TABLE IF NOT EXISTS `mip_accounting_account` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `parent_account_id` INT,
  `type` CHAR(4) NOT NULL,
  `code` INT NULL,
  `label` VARCHAR(45) NULL,
  `debt` DECIMAL(10,2) NOT NULL,
  `credt` DECIMAL(10,2) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL,
  `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `access_key` CHAR(6) NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `fk_maccounting_account_code_UNIQUE` (`code` ASC),
  UNIQUE INDEX `fk_maccounting_account_label_UNIQUE` (`label` ASC),
  INDEX `fk_accounting_account_accounting_account1_idx` (`parent_account_id` ASC),
  INDEX `fk_accounting_account_accounting_account_type1_idx` (`type` ASC),
  CONSTRAINT `fk_accounting_account_accounting_account1`
    FOREIGN KEY (`parent_account_id`)
    REFERENCES `mip_accounting_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accounting_account_accounting_account_type1`
    FOREIGN KEY (`type`)
    REFERENCES `mip_accounting_account_type` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

--
--   Detalle de Movimientos Contables
--

DROP TABLE IF EXISTS `mip_accounting_move_line`;


CREATE TABLE IF NOT EXISTS `mip_accounting_move_line` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `accounting_move_id` INT NOT NULL,
  `accounting_account_id` INT NOT NULL,
  `accounting_period_id` INT NOT NULL,
  `debt` DECIMAL(10,2) NOT NULL,
  `credt` DECIMAL(10,2) NOT NULL,
  `balance` DECIMAL(10,2) NOT NULL,
  `date_at` DATE NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NULL,
  `reconciled` TINYINT(1) NOT NULL,
  `position` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_accounting_move_line_accounting_move1_idx` (`accounting_move_id` ASC),
  INDEX `fk_accounting_move_line_accounting_account1_idx` (`accounting_account_id` ASC),
  INDEX `fk_accounting_move_line_accounting_period1_idx` (`accounting_period_id` ASC),
  CONSTRAINT `fk_accounting_move_line_accounting_move1`
    FOREIGN KEY (`accounting_move_id`)
    REFERENCES `mirador_remoto`.`mip_accounting_move` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accounting_move_line_accounting_account1`
    FOREIGN KEY (`accounting_account_id`)
    REFERENCES `mirador_remoto`.`mip_accounting_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_accounting_move_line_accounting_period1`
    FOREIGN KEY (`accounting_period_id`)
    REFERENCES `mirador_remoto`.`mip_accounting_period` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;



--
--  Alias Operativas Cuentas Contables
--

DROP TABLE IF EXISTS `mip_accounting_alias`;


CREATE TABLE IF NOT EXISTS `mip_accounting_alias` (
  `key` CHAR(6) NOT NULL,
  `account_id` INT NOT NULL,
  `label` VARCHAR(64) NOT NULL,
  `alias` VARCHAR(64) NULL,
  `access_key` VARCHAR(6) NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC),
  INDEX `fk_accounting_alias_accounting_account1_idx` (`account_id` ASC),
  UNIQUE INDEX `access_key_UNIQUE` (`access_key` ASC),
  CONSTRAINT `fk_accounting_alias_accounting_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `mip_accounting_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


--
--   Update AT
--
ALTER TABLE `mirador_remoto`.`mip_accounting_account` 
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL ;


--
--   Correccion Foreign Key de las Cuenta Padres
--
ALTER TABLE `mirador_remoto`.`mip_accounting_account` 
DROP FOREIGN KEY `fk_accounting_account_accounting_account1`;
ALTER TABLE `mirador_remoto`.`mip_accounting_account` 
CHANGE COLUMN `parent_account_id` `parent_account_id` INT(11) NULL ;
ALTER TABLE `mirador_remoto`.`mip_accounting_account` 
ADD CONSTRAINT `fk_accounting_account_accounting_account1`
  FOREIGN KEY (`parent_account_id`)
  REFERENCES `mirador_remoto`.`mip_accounting_account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;




/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;


DROP TABLE IF EXISTS `mip_accounting_alias`;

CREATE TABLE IF NOT EXISTS `mirador_remoto`.`mip_accounting_alias` (
  `key` CHAR(6) NOT NULL,
  `account_id` INT NOT NULL,
  `label` VARCHAR(64) NOT NULL,
  `alias` VARCHAR(64) NULL,
  `access_key` CHAR(6) NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC),
  INDEX `fk_accounting_alias_accounting_account1_idx` (`account_id` ASC),
  UNIQUE INDEX `access_key_UNIQUE` (`access_key` ASC),
  CONSTRAINT `fk_accounting_alias_accounting_account1`
    FOREIGN KEY (`account_id`)
    REFERENCES `mirador_remoto`.`mip_accounting_account` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Estatus Periodos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountPeriodStatus.*', '0', 'Backend - Estatus de Períodos Financieros ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountPeriodStatus.*');




--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Estatus Periodos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.fiscalYear.*', '0', 'Backend - Años Fiscales ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.fiscalYear.*');



--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Alias Cuentas Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingAlias.*', '0', 'Backend - Alias Cuentas Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingAlias.*');



--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Cuentas Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingAccount.*', '0', 'Backend - Cuentas Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingAccount.*');




--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Cuentas Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingAccountType.*', '0', 'Backend - Tipos Cuentas Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingAccountType.*');





--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Periodos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingPeriod.*', '0', 'Backend - Periodos Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingPeriod.*');




--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Estatus Movimientos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingMoveStatus.*', '0', 'Backend - Estatus Movimientos Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingMoveStatus.*');





--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Movimientos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingMove.*', '0', 'Backend - Movimientos Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingMove.*');




--
--   Se definen los permisos para el Rol de Finanzas
--
--
--  Se crea el Operacion Lineas Movimientos Contables
--
INSERT INTO `mip_auth_item`
(`name`,
`type`,
`description`,
`bizrule`,
`data`)
VALUES
('backend.accountingMoveLineController.*', '0', 'Backend - Lineas Movimientos Contables ', NULL, 'N;');


--
--  Se crea asignan las operaciones al rol de finanzas
--
INSERT INTO `mip_auth_item_child`
(`parent`,
`child`)
VALUES
('finance',
'backend.accountingMoveLineController.*');

