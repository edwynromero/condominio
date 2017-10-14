SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `mip_accounting_alias`;
CREATE TABLE `mip_accounting_alias` (
  `key` char(6) COLLATE utf8_bin NOT NULL,
  `account_id` int(11) NOT NULL,
  `label` varchar(64) COLLATE utf8_bin NOT NULL,
  `alias` varchar(64) COLLATE utf8_bin DEFAULT NULL,
  PRIMARY KEY (`key`),
  UNIQUE KEY `key_UNIQUE` (`key`),
  KEY `fk_accounting_alias_accounting_account1_idx` (`account_id`),
  CONSTRAINT `fk_accounting_alias_accounting_account1` FOREIGN KEY (`account_id`) REFERENCES `mip_accounting_account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;


DROP TABLE IF EXISTS `mip_accounting_move_ref_type`;
CREATE TABLE IF NOT EXISTS `mip_accounting_move_ref_type` (
  `key` CHAR(8) NOT NULL,
  `title` CHAR(64) NOT NULL,
  PRIMARY KEY (`key`),
  UNIQUE INDEX `key_UNIQUE` (`key` ASC))
ENGINE = InnoDB;

ALTER TABLE `mip_accounting_move` 
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL DEFAULT NULL ;


ALTER TABLE `mip_accounting_move` 
ADD COLUMN `ref_type` CHAR(8) NOT NULL AFTER `status`;

ALTER TABLE `mip_accounting_move` 
CHANGE COLUMN `ref_type` `ref_type` CHAR(8) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL AFTER `date_at`;


ALTER TABLE `mip_accounting_move` 
ADD INDEX `fk_mip_accounting_move_accounting_move_ref_type1_idx` (`ref_type` ASC);
ALTER TABLE `mip_accounting_move` 
ADD CONSTRAINT `fk_mip_accounting_move_accounting_move_ref_type1`
  FOREIGN KEY (`ref_type`)
  REFERENCES `mip_accounting_move_ref_type` (`key`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mip_accounting_move` 
CHANGE COLUMN `ref_name` `ref_name` VARCHAR(64) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ,
CHANGE COLUMN `ref_value` `ref_value` VARCHAR(16) CHARACTER SET 'utf8' COLLATE 'utf8_bin' NOT NULL ;


ALTER TABLE `mip_accounting_move_ref_type` 
ADD COLUMN `associated_name` VARCHAR(64) NOT NULL AFTER `title`;


CREATE TABLE IF NOT EXISTS `mip_accounting_move_reference` (
  `id` INT NOT NULL,
  `type` CHAR(8) NOT NULL,
  `move_id` INT NOT NULL,
  `label` VARCHAR(64) NULL,
  `value` VARCHAR(16) NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mip_accounting_move_reference_mip_accounting_move_ref_ty_idx` (`type` ASC),
  INDEX `fk_mip_accounting_move_reference_mip_accounting_move1_idx` (`move_id` ASC),
  CONSTRAINT `fk_mip_accounting_move_reference_mip_accounting_move_ref_type1`
    FOREIGN KEY (`type`)
    REFERENCES `mip_accounting_move_ref_type` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mip_accounting_move_reference_mip_accounting_move1`
    FOREIGN KEY (`move_id`)
    REFERENCES `mip_accounting_move` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


ALTER TABLE `mip_accounting_move` 
DROP FOREIGN KEY `fk_mip_accounting_move_accounting_move_ref_type1`;


DROP TABLE IF EXISTS `mip_accounting_move`;
CREATE TABLE `mip_accounting_move` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `label` varchar(128) COLLATE utf8_bin NOT NULL,
  `date_at` date NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL,
  `status` char(4) COLLATE utf8_bin NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_accounting_move_accounting_move_status1_idx` (`status`),
  CONSTRAINT `fk_accounting_move_accounting_move_status1` FOREIGN KEY (`status`) REFERENCES `mip_accounting_move_status` (`key`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

ALTER TABLE `mip_account_period_status` 
RENAME TO  `mip_accounting_period_status` ;

ALTER TABLE `mip_fiscal_year` 
DROP FOREIGN KEY `fk_fiscal_year_account_period_status1`;
ALTER TABLE `mip_fiscal_year` 
ADD INDEX `fk_fiscal_year_account_period_status1_idx` (`status` ASC),
DROP INDEX `fk_fiscal_year_maccount_period_status1_idx` ;
ALTER TABLE `mip_fiscal_year` 
ADD CONSTRAINT `fk_fiscal_year_account_period_status1`
  FOREIGN KEY (`status`)
  REFERENCES `mip_accounting_period_status` (`key`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;



ALTER TABLE `mip_accounting_period` 
CHANGE COLUMN `updated_at` `updated_at` TIMESTAMP NULL ;


ALTER TABLE `mip_accounting_period` 
DROP FOREIGN KEY `fk_accounting_period_account_period_status1`;
ALTER TABLE `mip_accounting_period` 
ADD INDEX `fk_accounting_period_account_period_status1_idx` (`status` ASC),
DROP INDEX `fk_accounting_period_account_period_status1_idx` ;
ALTER TABLE `mip_accounting_period` 
ADD CONSTRAINT `fk_accounting_period_account_period_status1`
  FOREIGN KEY (`status`)
  REFERENCES `mip_accounting_period_status` (`key`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


ALTER TABLE `mip_accounting_move_line` 
DROP COLUMN `balance`;


ALTER TABLE `mip_accounting_move_line` 
DROP COLUMN `position`;

ALTER TABLE `mip_accounting_move_reference` 
CHANGE COLUMN `id` `id` INT(11) NOT NULL AUTO_INCREMENT ;

ALTER TABLE `mip_accounting_move_reference` 
CHANGE COLUMN `label` `label` VARCHAR(64) CHARACTER SET 'utf8' NOT NULL ,
CHANGE COLUMN `value` `value` VARCHAR(16) CHARACTER SET 'utf8' NOT NULL ;


CREATE TABLE IF NOT EXISTS `mip_accounting_account_kind` (
  `key` CHAR(4) NOT NULL,
  `title` VARCHAR(32) NOT NULL,
  `created_at` TIMESTAMP NOT NULL,
  `updated_at` TIMESTAMP NOT NULL,
  `deprecated` TINYINT(1) NOT NULL,
  PRIMARY KEY (`key`))
ENGINE = InnoDB;

ALTER TABLE `mip_accounting_account` 
DROP COLUMN `balance`,
DROP COLUMN `credt`,
DROP COLUMN `debt`;

ALTER TABLE `mip_accounting_account` 
ADD COLUMN `kind` CHAR(4) NULL AFTER `access_key`,
ADD COLUMN `note` TEXT NULL AFTER `kind`;

UPDATE mip_accounting_account SET kind = '0000' WHERE id > 0;

CREATE TABLE IF NOT EXISTS `mip_accounting_account_kind` (
  `key` CHAR(4) NOT NULL,
  `title` VARCHAR(32) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deprecated` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`key`))
ENGINE = InnoDB;

ALTER TABLE `mip_accounting_account` 
CHANGE COLUMN `kind` `kind` CHAR(4) NOT NULL DEFAULT '0000' ;

ALTER TABLE `mip_accounting_account_kind` 
ADD UNIQUE INDEX `key_UNIQUE` (`key` ASC);

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("0000",
    "Others");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("1000","View");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("2000","Payable");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("3000","Receivable");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("4000","Expense");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("5000","Revenue");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("6000","Bank");

INSERT INTO `mip_accounting_account_kind`
(`key`,
`title`)
VALUES
("7000","Cash");


ALTER TABLE `mip_accounting_account` 
CHANGE COLUMN `kind` `kind` CHAR(4) NOT NULL ,
ADD INDEX `fk_accounting_account_accounting_account_kind1_idx` (`kind` ASC);

ALTER TABLE `mip_accounting_account` 
CHANGE COLUMN `kind` `kind` CHAR(4) NOT NULL DEFAULT '0000' ;


ALTER TABLE `mip_accounting_account` 
ADD CONSTRAINT `fk_accounting_account_accounting_account_kind1`
  FOREIGN KEY (`kind`)
  REFERENCES `mip_accounting_account_kind` (`key`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mip_accounting_account` 
ADD COLUMN `deprecated` TINYINT NOT NULL DEFAULT 0 AFTER `note`;

UPDATE mip_accounting_account SET kind = '1000' WHERE id > 0;

UPDATE mip_accounting_account a  INNER JOIN mip_accounting_move_line ml ON ( a.id = ml.accounting_account_id ) 
SET a.kind = '0000' ;

ALTER TABLE `mip_accounting_account_kind` 
ADD COLUMN `position` INT NOT NULL DEFAULT 0 AFTER `deprecated`;

UPDATE `mip_accounting_account_kind` SET `position` = 999 WHERE `key` = '0000';
UPDATE `mip_accounting_account_kind` SET `position` = 0 WHERE `key` = '1000';
UPDATE `mip_accounting_account_kind` SET `position` = 1 WHERE `key` = '2000';
UPDATE `mip_accounting_account_kind` SET `position` = 2 WHERE `key` = '3000';
UPDATE `mip_accounting_account_kind` SET `position` = 3 WHERE `key` = '4000';
UPDATE `mip_accounting_account_kind` SET `position` = 4 WHERE `key` = '5000';
UPDATE `mip_accounting_account_kind` SET `position` = 5 WHERE `key` = '6000';
UPDATE `mip_accounting_account_kind` SET `position` = 6 WHERE `key` = '7000';

ALTER TABLE `mip_accounting_move_reference` 
DROP FOREIGN KEY `fk_mip_accounting_move_reference_mip_accounting_move1`;
ALTER TABLE `mip_accounting_move_reference` 
DROP COLUMN `move_id`,
DROP INDEX `fk_mip_accounting_move_reference_mip_accounting_move1_idx` ;

ALTER TABLE `mip_accounting_move_reference` 
ADD COLUMN `move_line_id` INT(11) NOT NULL AFTER `id`;

ALTER TABLE `mip_accounting_move_reference` 
ADD INDEX `fk_mip_accounting_move_reference_accounting_move_line_ref_idx` (`move_line_id` ASC);

ALTER TABLE `mip_accounting_move_reference` 
ADD CONSTRAINT `fk_accounting_move_reference_accounting_move_line_ref_type1`
  FOREIGN KEY (`id`)
  REFERENCES `mip_accounting_move_line` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
DROP COLUMN `move_line_id`,
DROP INDEX `fk_mip_accounting_move_reference_accounting_move_line_ref_idx` ;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
ADD COLUMN `move_id` INT NOT NULL AFTER `updated_at`;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
CHANGE COLUMN `move_id` `move_id` INT(11) NOT NULL AFTER `value`;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
DROP FOREIGN KEY `fk_accounting_move_reference_accounting_move_line_ref_type1`;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
DROP INDEX `fk_accounting_move_reference_accounting_move_ref_type1_idx` ;

ALTER TABLE `mirador_remoto`.`mip_accounting_move_reference` 
ADD CONSTRAINT `fk_mip_accounting_move_reference_mip_accounting_move_1`
  FOREIGN KEY (`move_id`)
  REFERENCES `mirador_remoto`.`mip_accounting_move` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;


SET FOREIGN_KEY_CHECKS=1;

