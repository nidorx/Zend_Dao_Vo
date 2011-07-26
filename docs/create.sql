SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL';

DROP SCHEMA IF EXISTS `teste` ;
CREATE SCHEMA IF NOT EXISTS `teste` DEFAULT CHARACTER SET latin1 ;
USE `teste` ;

-- -----------------------------------------------------
-- Table `teste`.`tb_user`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teste`.`tb_user` ;

CREATE  TABLE IF NOT EXISTS `teste`.`tb_user` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `username` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  `name` VARCHAR(200) NOT NULL ,
  `email` VARCHAR(100) NOT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `idx_username` (`username` ASC) )
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `teste`.`tb_user_profile`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `teste`.`tb_user_profile` ;

CREATE  TABLE IF NOT EXISTS `teste`.`tb_user_profile` (
  `id` INT NOT NULL AUTO_INCREMENT ,
  `about_me` TEXT NULL ,
  `gender` CHAR NULL ,
  `user_id` INT NULL ,
  `birthday_year` INT NULL ,
  `birthday_month` INT NULL ,
  `birthday_day` INT NULL ,
  PRIMARY KEY (`id`) ,
  INDEX `idx_user_id` (`user_id` ASC) ,
  CONSTRAINT `fk_tb_user_profile_xref_user`
    FOREIGN KEY (`user_id` )
    REFERENCES `teste`.`tb_user` (`id` )
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;



SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

