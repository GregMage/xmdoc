CREATE TABLE `xmdoc_category` (
  `category_id`             int(11) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)        NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)         NOT NULL DEFAULT '',
  `category_weight`         int(11)             NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)          NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`)
) ENGINE=MyISAM;