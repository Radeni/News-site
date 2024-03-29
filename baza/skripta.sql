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
-- Table `news`.`User`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`User` (
  `idKorisnik` INT NOT NULL AUTO_INCREMENT,
  `Username` VARCHAR(80) NOT NULL,
  `Password` VARCHAR(100) NOT NULL,
  `Ime` VARCHAR(45) NOT NULL,
  `Prezime` VARCHAR(45) NOT NULL,
  `Telefon` VARCHAR(20) NOT NULL,
  `Tip` ENUM("novinar", "urednik", "glavni_urednik") NOT NULL,
  PRIMARY KEY (`idKorisnik`),
  UNIQUE INDEX `idKorisnik_UNIQUE` (`idKorisnik` ASC) VISIBLE,
  UNIQUE INDEX `Username_UNIQUE` (`Username` ASC) VISIBLE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `news`.`Vest`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `news`.`Vest` (
  `idVest` INT NOT NULL AUTO_INCREMENT,
  `Naslov` VARCHAR(100) NOT NULL,
  `Tekst` VARCHAR(10000) NOT NULL,
  `Tagovi` VARCHAR(100) NOT NULL,
  `Datum` DATE NOT NULL,
  `Lajkovi` INT NOT NULL,
  `Dislajkovi` INT NOT NULL,
  `Status` ENUM('DRAFT', 'ODOBRENA', 'DRAFT_PENDING_APPROVAL', 'DRAFT_PENDING_CHANGE', 'PENDING_DELETION') NOT NULL DEFAULT 'DRAFT',
  `idRubrika` INT NOT NULL,
  `idKorisnik` INT NOT NULL,
  PRIMARY KEY (`idVest`, `idRubrika`, `idKorisnik`),
  UNIQUE INDEX `idVest_UNIQUE` (`idVest` ASC, `Tagovi` ASC, `Datum` ASC, `Naslov` ASC) VISIBLE,
  INDEX `fk_Vest_Rubrika1_idx` (`idRubrika` ASC) VISIBLE,
  INDEX `fk_Vest_User1_idx` (`idKorisnik` ASC) VISIBLE,
  CONSTRAINT `fk_Vest_Rubrika1`
    FOREIGN KEY (`idRubrika`)
    REFERENCES `news`.`Rubrika` (`idRubrika`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_Vest_User1`
    FOREIGN KEY (`idKorisnik`)
    REFERENCES `news`.`User` (`idKorisnik`)
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
-- Data for table `news`.`Rubrika`
-- -----------------------------------------------------
START TRANSACTION;
USE `news`;
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (1, 'Politika');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (2, 'Svet');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (3, 'Drustvo');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (4, 'Sport');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (5, 'Ukrajina');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (6, 'Izrael');
INSERT INTO `news`.`Rubrika` (`idRubrika`, `Ime`) VALUES (7, 'Humor');

COMMIT;


-- -----------------------------------------------------
-- Data for table `news`.`User`
-- -----------------------------------------------------
START TRANSACTION;
USE `news`;
INSERT INTO `news`.`User` (`idKorisnik`, `Username`, `Password`, `Ime`, `Prezime`, `Telefon`, `Tip`) VALUES (1, 'admin', '$2a$12$imNXkN62wcomZpbkRV66jug.XHWvwVqQnTvOdawdNdvtQIrlyoP8O', 'Mihajlo', 'Radosevic', '064/123-45-67', 'glavni_urednik');
INSERT INTO `news`.`User` (`idKorisnik`, `Username`, `Password`, `Ime`, `Prezime`, `Telefon`, `Tip`) VALUES (2, 'johndoetest1', '$2a$12$imNXkN62wcomZpbkRV66jug.XHWvwVqQnTvOdawdNdvtQIrlyoP8O', 'John', 'Doe', '123/456-78-9', 'novinar');
INSERT INTO `news`.`User` (`idKorisnik`, `Username`, `Password`, `Ime`, `Prezime`, `Telefon`, `Tip`) VALUES (3, 'janedoetest2', '$2a$12$imNXkN62wcomZpbkRV66jug.XHWvwVqQnTvOdawdNdvtQIrlyoP8O', 'Jane', 'Doe', '123/456-78-9', 'urednik');

COMMIT;


-- -----------------------------------------------------
-- Data for table `news`.`Vest`
-- -----------------------------------------------------
START TRANSACTION;
USE `news`;
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (1, 'Placeholder Title for Serbian Politics', '<h2>This is a placeholder article for Serbian Politics rubric.</h2><p><strong>This is a placeholder article for Serbian Politics rubric.</strong></p><p><i>This is a placeholder article for Serbian Politics rubric.</i></p><h4><i><strong>This is a placeholder article for Serbian Politics rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for Serbian Politics rubric.</strong></i></li><li>This is a placeholder article for Serbian Politics rubric.</li><li>Edit test</li></ul>', 'Serbia, Politics', '2024-02-14', 2, 0, 'ODOBRENA', 1, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (2, 'Placeholder Article for World', '<h2>This is a placeholder article for World rubric.</h2><p><strong>This is a placeholder article for World rubric.</strong></p><p><i>This is a placeholder article for World rubric.</i></p><h4><i><strong>This is a placeholder article for World rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for World rubric.</strong></i></li><li>This is a placeholder article for <i><strong>World </strong></i> rubric.</li><li><img src=\"https://upload.wikimedia.org/wikipedia/commons/thumb/8/8f/Whole_world_-_land_and_oceans_12000.jpg/800px-Whole_world_-_land_and_oceans_12000.jpg\" alt=\"800px-Whole_world_-_land_and_oceans_12000.jpg\" width=\"800\" height=\"400\"></li></ul>', 'World, Something', '2024-02-14', 5, 1, 'ODOBRENA', 2, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (3, 'Placeholder Article for Community', '<h2>This is a placeholder article for Community rubric.</h2><p><strong>This is a placeholder article for World rubric.</strong></p><p><i>This is a placeholder article for World rubric.</i></p><h4><i><strong>This is a placeholder article for Community rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for Community rubric.</strong></i></li></ul><p>This is a placeholder article for <i><strong>Community </strong></i>rubric.</p>', 'Community, Kragujevac, V365', '2024-02-13', 15, 6, 'ODOBRENA', 3, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (4, 'Placeholder for Sport', '<h2>This is a placeholder article for Sport rubric.</h2><p><strong>This is a placeholder article for Sport rubric.</strong></p><p><i>This is a placeholder article for Sport rubric.</i></p><h4><i><strong>This is a placeholder article for Sport rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for Sport rubric.</strong></i></li><li>This is a placeholder article for <i>sport<strong> </strong></i> rubric.</li></ul>', 'Sport, Football', '2024-02-12', 163, 25, 'ODOBRENA', 4, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (5, 'Placeholder for Ukraine', '<h2>This is a placeholder article for Ukraine rubric.</h2><p><strong>This is a placeholder article for Ukraine rubric.</strong></p><p><i>This is a placeholder article for Ukraine rubric.</i></p><h4><i><strong>This is a placeholder article for Ukraine rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for Ukraine rubric.</strong></i></li><li>This is a placeholder article for <i>Ukraine </i>rubric.</li></ul>', 'Ukraine, War, Russia, Putin', '2024-02-11', 1678, 347, 'ODOBRENA', 5, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (6, 'Placeholder for Israel', '<h2>This is a placeholder article for Israel rubric.</h2><p><strong>This is a placeholder article for Israel</strong> <strong>rubric.</strong></p><p><i>This is a placeholder article for Israel rubric.</i></p><h4><i><strong>This is a placeholder article for Israel rubric.</strong></i></h4><ul><li><i><strong>This is a placeholder article for Israel rubric.</strong></i></li><li>This is a placeholder article for <i><strong>Israel </strong></i>rubric.</li></ul>', 'Israel, Palestine, Gaza, Hamas', '2024-02-8', 653, 104, 'ODOBRENA', 6, 1);
INSERT INTO `news`.`Vest` (`idVest`, `Naslov`, `Tekst`, `Tagovi`, `Datum`, `Lajkovi`, `Dislajkovi`, `Status`, `idRubrika`, `idKorisnik`) VALUES (7, 'Funny Placeholder', '<p>Funny text for funny placeholders</p><figure><div data-oembed-url=\"https://www.youtube.com/watch?v=oPQjB3EDcjw\"><div style=\"padding-bottom:56.2493%;height:0;\"><iframe src=\"https://www.youtube.com/embed/oPQjB3EDcjw\" style=\"position: absolute; width: 100%; height: 100%; top: 0; left: 0;\" frameborder=\"0\" allow=\"autoplay; encrypted-media\" allowfullscreen></div></div></figure>', 'Fun, Humor, comedy', '2024-02-1', 3535, 13, 'ODOBRENA', 7, 1);

COMMIT;

