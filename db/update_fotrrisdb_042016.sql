ALTER TABLE `project` ADD `sn_abstract` VARCHAR(1) NULL DEFAULT 'S' COMMENT 'Abstract Project' ;
ALTER TABLE `project` ADD `sn_repository` VARCHAR(1) NULL DEFAULT 'S' COMMENT 'Repository Project' ;
ALTER TABLE `group_pad` ADD `type` VARCHAR(3) NULL DEFAULT 'CON' COMMENT 'Type for PAD COM,ABS,REP' ;