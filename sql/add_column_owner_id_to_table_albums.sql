ALTER TABLE `photo-gallery`.`albums` ADD COLUMN `owner_id` INT NOT NULL  AFTER `modification_date` ,
  ADD CONSTRAINT `fk1`
  FOREIGN KEY (`owner_id` )
  REFERENCES `photo-gallery`.`users` (`user_id` )
  ON DELETE NO ACTION
  ON UPDATE NO ACTION
, ADD INDEX `fk1_idx` (`owner_id` ASC) ;
