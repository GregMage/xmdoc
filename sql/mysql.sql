CREATE TABLE `xmdoc_category` (
  `category_id`             int(11) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)        NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)         NOT NULL DEFAULT '',
  `category_size`           int(11)             NOT NULL DEFAULT '500',
  `category_extensions`     text,
  `category_weight`         int(11)             NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)          NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`),
  KEY `category_name` (`category_name`)
) ENGINE=MyISAM;

CREATE TABLE `xmdoc_document` (
  `document_id`             int(11) unsigned        NOT NULL AUTO_INCREMENT,
  `document_category`       int(11)                 NOT NULL DEFAULT '0',
  `document_name`           varchar(255)            NOT NULL DEFAULT '',
  `document_description`    text,
  `document_logo`           varchar(50)             NOT NULL DEFAULT '',
  `document_document`       varchar(255)            NOT NULL DEFAULT '',
  `document_userid`         mediumint(8) unsigned   NOT NULL default '0',
  `document_date`           int(10) unsigned        NOT NULL DEFAULT '0',
  `document_mdate`          int(10) unsigned        NOT NULL DEFAULT '0',
  `document_rating`         double(6,4)             NOT NULL default '0.0000',
  `document_votes`          int(11) unsigned        NOT NULL default '0',
  `document_counter`        int(8) unsigned         NOT NULL DEFAULT '0',
  `document_showinfo`       tinyint(1)              NOT NULL DEFAULT '1',
  `document_weight`         int(11)                 NOT NULL DEFAULT '0',
  `document_status`         tinyint(1)              NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`document_id`),
  KEY `document_name` (`document_name`)
) ENGINE=MyISAM;

CREATE TABLE `xmdoc_docdata` (
  `docdata_id`             int(11) unsigned    NOT NULL AUTO_INCREMENT,
  `docdata_docid`          int(11)             NOT NULL DEFAULT '0',
  `docdata_modid`          int(11)             NOT NULL DEFAULT '0',
  `docdata_itemid`         int(11)             NOT NULL DEFAULT '0',
  
  PRIMARY KEY (`docdata_id`),
  KEY `docdata_docid` (`docdata_docid`)
) ENGINE=MyISAM;