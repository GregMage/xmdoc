CREATE TABLE `xmdoc_category` (
  `category_id`             smallint(5) unsigned    NOT NULL AUTO_INCREMENT,
  `category_name`           varchar(255)            NOT NULL DEFAULT '',
  `category_description`    text,
  `category_logo`           varchar(50)             NOT NULL DEFAULT '',
  `category_color`          varchar(7)              NOT NULL DEFAULT '#ffffff',
  `category_size`           varchar(15)             NOT NULL DEFAULT '500 K',
  `category_extensions`     text,
  `category_folder`         varchar(50)             NOT NULL DEFAULT '',
  `category_rename`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  `category_limitdownload`  smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_limititem`      smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_weight`         smallint(5) unsigned    NOT NULL DEFAULT '0',
  `category_status`         tinyint(1)  unsigned    NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM;

CREATE TABLE `xmdoc_document` (
  `document_id`             mediumint(8)  unsigned  NOT NULL AUTO_INCREMENT,
  `document_category`       smallint(5)   unsigned  NOT NULL DEFAULT '0',
  `document_name`           varchar(255)            NOT NULL DEFAULT '',
  `document_description`    text,
  `document_logo`           varchar(50)             NOT NULL DEFAULT '',
  `document_document`       varchar(255)            NOT NULL DEFAULT '',
  `document_size`           varchar(15)             NOT NULL DEFAULT '',
  `document_userid`         smallint(5)   unsigned  NOT NULL default '0',
  `document_date`           int(10)       unsigned  NOT NULL DEFAULT '0',
  `document_mdate`          int(10)       unsigned  NOT NULL DEFAULT '0',
  `document_rating`         double(6,4)             NOT NULL default '0.0000',
  `document_votes`          smallint(5)   unsigned  NOT NULL default '0',
  `document_counter`        smallint(5)   unsigned  NOT NULL DEFAULT '0',
  `document_showinfo`       tinyint(1)    unsigned  NOT NULL DEFAULT '1',
  `document_weight`         smallint(5)   unsigned  NOT NULL DEFAULT '0',
  `document_status`         tinyint(1)    unsigned  NOT NULL DEFAULT '1',
  
  PRIMARY KEY (`document_id`),
  KEY `document_category` (`document_category`),
  KEY `document_userid` (`document_userid`)
) ENGINE=MyISAM;

CREATE TABLE `xmdoc_docdata` (
  `docdata_id`             mediumint(8) unsigned    NOT NULL AUTO_INCREMENT,
  `docdata_docid`          mediumint(8) unsigned    NOT NULL DEFAULT '0',
  `docdata_modid`          smallint(5)  unsigned    NOT NULL DEFAULT '0',
  `docdata_itemid`         mediumint(8) unsigned    NOT NULL DEFAULT '0',
  
  PRIMARY KEY (`docdata_id`),
  KEY `docdata_docid` (`docdata_docid`),
  KEY `docdata_modid` (`docdata_modid`),
  KEY `docdata_itemid` (`docdata_itemid`)
) ENGINE=MyISAM;

CREATE TABLE `xmdoc_downlimit` (
  `downlimit_id`           mediumint(8)  unsigned   NOT NULL AUTO_INCREMENT,
  `downlimit_docid`        mediumint(8)  unsigned   NOT NULL DEFAULT '0',
  `downlimit_catid`        smallint(5)   unsigned   NOT NULL DEFAULT '0',
  `downlimit_uid`          smallint(5)   unsigned   NOT NULL DEFAULT '0',
  `downlimit_hostname`     varchar(50)              NOT NULL DEFAULT '',
  `downlimit_date`         int(10)       unsigned   NOT NULL DEFAULT '0',
  
  PRIMARY KEY (`downlimit_id`),
  KEY `downlimit_docid` (`downlimit_docid`),
  KEY `downlimit_catid` (`downlimit_catid`)
) ENGINE=MyISAM;