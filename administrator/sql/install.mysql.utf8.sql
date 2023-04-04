CREATE TABLE IF NOT EXISTS `#__marker_marker` (
`id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,

`ordering` INT(11)  NOT NULL ,
`state` TINYINT(1)  NOT NULL ,
`checked_out` INT(11)  NOT NULL ,
`checked_out_time` DATETIME NOT NULL DEFAULT '0000-00-00 00:00:00',
`created_by` INT(11)  NOT NULL ,
`title` VARCHAR(255)  NOT NULL ,
`latitude` FLOAT NOT NULL ,
`longtitude` FLOAT NOT NULL ,
`altitude` FLOAT NOT NULL ,
`category` VARCHAR(255)  NOT NULL ,
`location` VARCHAR(255)  NOT NULL ,
`description` VARCHAR(255)  NOT NULL ,
`images` VARCHAR(255)  NOT NULL ,
PRIMARY KEY (`id`)
) DEFAULT COLLATE=utf8_general_ci;

