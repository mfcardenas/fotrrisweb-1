use fotrrisdb;

ALTER TABLE `user` ADD `location` VARCHAR(70) NULL COMMENT 'Location for User' ;

ALTER TABLE `user` ADD `institution` VARCHAR(70) NULL COMMENT 'Institution or Organization for User' ;
