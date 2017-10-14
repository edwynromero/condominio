SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `mip_accounting_journal_type`;

CREATE TABLE IF NOT EXISTS `mip_accounting_journal_type` (
  `key` CHAR(4) NOT NULL,
  `title` VARCHAR(64) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  `deprecated` TINYINT(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`key`),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC))
ENGINE = InnoDB;


DROP TABLE IF EXISTS `mip_accounting_journal`;

CREATE TABLE IF NOT EXISTS `mip_accounting_journal` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `code` INT UNSIGNED NULL,
  `title` VARCHAR(64) NOT NULL,
  `note` TEXT NULL,
  `journal_type` CHAR(4) NOT NULL,
  `deprecated` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL,
  `access_key` CHAR(6) NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mip_accounting_journal_mip_accounting_journal_type1_idx` (`journal_type` ASC),
  UNIQUE INDEX `access_key_UNIQUE` (`access_key` ASC),
  UNIQUE INDEX `code_UNIQUE` (`code` ASC),
  UNIQUE INDEX `title_UNIQUE` (`title` ASC),
  CONSTRAINT `fk_mip_accounting_journal_mip_accounting_journal_type1`
    FOREIGN KEY (`journal_type`)
    REFERENCES `mip_accounting_journal_type` (`key`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

ALTER TABLE `mip_accounting_move` 
ADD COLUMN `journal_id` INT NOT NULL AFTER `id`;

ALTER TABLE `mip_accounting_move` 
ADD CONSTRAINT `fk_accounting_move_accounting_journal1`
  FOREIGN KEY (`journal_id`)
  REFERENCES `mip_accounting_journal` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mirador_remoto`.`mip_accounting_journal` 
DROP COLUMN `access_key`,
CHANGE COLUMN `code` `code` VARCHAR(5) NOT NULL ,
DROP INDEX `access_key_UNIQUE` ;


ALTER TABLE `mip_accounting_move_line` 
ADD COLUMN `label` VARCHAR(128) NULL AFTER `id`;


ALTER TABLE `mip_accounting_journal` ADD COLUMN `debt_account_id` INT NOT NULL AFTER `note`;

ALTER TABLE `mip_accounting_journal` 
ADD CONSTRAINT `fk_mip_accounting_journal_accounting_account_debt1`
  FOREIGN KEY (`debt_account_id`)
  REFERENCES `mip_accounting_account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mip_accounting_journal` ADD COLUMN `credt_account_id` INT NOT NULL AFTER `debt_account_id`;

ALTER TABLE `mip_accounting_journal` 
ADD CONSTRAINT `fk_mip_accounting_journal_accounting_account_credt1`
  FOREIGN KEY (`credt_account_id`)
  REFERENCES `mip_accounting_account` (`id`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

ALTER TABLE `mip_accounting_move` 
ADD COLUMN `debt` DECIMAL(10,2) NOT NULL DEFAULT 0.0 AFTER `label`,
ADD COLUMN `credt` DECIMAL(10,2) NOT NULL DEFAULT 0.0 AFTER `debt`;




SET FOREIGN_KEY_CHECKS=1;

