CREATE TABLE IF NOT EXISTS `cymcass`.`b9_stu_ranking` (
  `uid` VARCHAR(80) NOT NULL,
  `term` VARCHAR(8) NOT NULL,
  `gid` MEDIUMINT NOT NULL,
  `mark` INT NOT NULL DEFAULT 0,
  `last_updated` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `last_updated_by` VARCHAR(80) NULL,
  PRIMARY KEY (`term`, `uid`, `gid`))
ENGINE = InnoDB
