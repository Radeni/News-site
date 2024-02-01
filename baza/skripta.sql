-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema news
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema news
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `news` DEFAULT CHARACTER SET utf8 ;
USE `news` ;

-- -----------------------------------------------------
-- Table `news`.`Rubrika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`Rubrika` (
  `idRubrika` INT NOT NULL AUTO_INCREMENT,
  `Ime` VARCHAR(100) NOT NULL,
  PRIMARY KEY (`idRubrika`),
  UNIQUE INDEX `idRubrika_UNIQUE` (`idRubrika` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news`.`Vest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`Vest` (
  `idVest` INT NOT NULL AUTO_INCREMENT,
  `Naslov` VARCHAR(100) NOT NULL,
  `Tekst` VARCHAR(3000) NOT NULL,
  `Tagovi` VARCHAR(100) NOT NULL,
  `Datum` DATE NOT NULL,
  `Lajkovi` INT NOT NULL,
  `Dislajkovi` INT NOT NULL,
  `Status` ENUM('draft', 'odobrena') NOT NULL DEFAULT 'draft',
  `idRubrika` INT NOT NULL,
  PRIMARY KEY (`idVest`, `idRubrika`),
  UNIQUE INDEX `idVest_UNIQUE` (`idVest` ASC) VISIBLE,
  INDEX `fk_Vest_Rubrika1_idx` (`idRubrika` ASC) VISIBLE,
  CONSTRAINT `fk_Vest_Rubrika1`
    FOREIGN KEY (`idRubrika`)
    REFERENCES `news`.`Rubrika` (`idRubrika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news`.`Komentar`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`Komentar` (
  `idKomentar` INT NOT NULL AUTO_INCREMENT,
  `Ime` VARCHAR(45) NOT NULL,
  `Tekst` VARCHAR(300) NOT NULL,
  `Lajkovi` INT NOT NULL,
  `Dislajkovi` INT NOT NULL,
  `idVest` INT NOT NULL,
  PRIMARY KEY (`idKomentar`, `idVest`),
  UNIQUE INDEX `idKomentar_UNIQUE` (`idKomentar` ASC) VISIBLE,
  INDEX `fk_Komentar_Vest_idx` (`idVest` ASC) VISIBLE,
  CONSTRAINT `fk_Komentar_Vest`
    FOREIGN KEY (`idVest`)
    REFERENCES `news`.`Vest` (`idVest`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`User` (
  `idKorisnik` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(80) NOT NULL,
  `Password` VARCHAR(100) NOT NULL,
  `Tip` ENUM("novinar", "urednik", "glavni_urednik") NOT NULL,
  PRIMARY KEY (`idKorisnik`),
  UNIQUE INDEX `idKorisnik_UNIQUE` (`idKorisnik` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news`.`UserRubrika`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`UserRubrika` (
  `idKorisnik` INT NOT NULL,
  `idRubrika` INT NOT NULL,
  PRIMARY KEY (`idKorisnik`, `idRubrika`),
  INDEX `fk_User_has_Rubrika_Rubrika1_idx` (`idRubrika` ASC) VISIBLE,
  INDEX `fk_User_has_Rubrika_User1_idx` (`idKorisnik` ASC) VISIBLE,
  CONSTRAINT `fk_User_has_Rubrika_User1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `news`.`User` (`idKorisnik`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_User_has_Rubrika_Rubrika1`
    FOREIGN KEY (`idRubrika`)
    REFERENCES `news`.`Rubrika` (`idRubrika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

-- -----------------------------------------------------
-- Data for table `news`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `news`;
INSERT INTO `news`.`User` (`idKorisnik`, `Username`, `Password`, `Tip`) VALUES (1, 'admin', '$2a$12$imNXkN62wcomZpbkRV66jug.XHWvwVqQnTvOdawdNdvtQIrlyoP8O', 'glavni_urednik');

COMMIT;

