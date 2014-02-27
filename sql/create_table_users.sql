CREATE  TABLE `photo-gallery`.`users` (
  `user_id` INT NOT NULL ,
  `login` VARCHAR(45) NOT NULL ,
  `password` VARCHAR(45) NOT NULL ,
  PRIMARY KEY (`user_id`) ,
  UNIQUE INDEX `login_UNIQUE` (`login` ASC) ,
  UNIQUE INDEX `user_id_UNIQUE` (`user_id` ASC) );
