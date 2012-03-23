<?php
// 20101110 tsuchitani AT ivywe DOT co DOT jp
// Last Update 20120117

//ADDTION DATA
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_addition']} (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `field_id` int(11) NOT NULL,
  `value` mediumtext NOT NULL,
  PRIMARY KEY (`seq`),
  KEY `id` (`id`),
  KEY `field_id` (`field_id`),
  KEY `value` (`value`(16))
) ENGINE=MyISAM  ;
";

//BASE DATA
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_base']} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `page_title` varchar(128) DEFAULT NULL,
  `description` mediumtext,
  `defaulttemplatesdirectory` varchar(40) NOT NULL DEFAULT '',
  `hits` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comments` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `comment_expire` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `commentcode` tinyint(4) NOT NULL DEFAULT '0',
  `meta_description` text,
  `meta_keywords` text,
  `language_id` char(2) DEFAULT NULL,
  `owner_id` mediumint(8) NOT NULL DEFAULT '1',
  `group_id` mediumint(8) NOT NULL DEFAULT '2',
  `perm_owner` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `perm_group` tinyint(1) unsigned NOT NULL DEFAULT '3',
  `perm_members` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `perm_anon` tinyint(1) unsigned NOT NULL DEFAULT '2',
  `modified` datetime NOT NULL,
  `created` datetime NOT NULL,
  `released` datetime NOT NULL,

  `expired` datetime NOT NULL DEFAULT '0000-00-00 00:00:00',
  `orderno` int(2) NOT NULL DEFAULT '0',

  `draft_flag` tinyint(3) NOT NULL DEFAULT '0',
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `uuid` mediumint(8) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `hits` (`hits`),
  KEY `modified` (`modified`),
  KEY `created` (`created`),
  KEY `released` (`released`),
  KEY `expired` (`expired`)
) ENGINE=MyISAM  ;
";

//カテゴリ
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_category']} (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  PRIMARY KEY (`seq`),
  KEY `id` (`id`)
) ENGINE=MyISAM
";

//カテゴリ 定義
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_def_category']} (
  `category_id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(40) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` mediumtext,
  `defaulttemplatesdirectory` varchar(40) DEFAULT NULL,
  `orderno` int(2) DEFAULT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `categorygroup_id` int(11) NOT NULL DEFAULT '0',
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` mediumint(8) NOT NULL DEFAULT 0,
  PRIMARY KEY (`category_id`)
) ENGINE=MyISAM
";

//項目定義
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_def_field']} (
  `field_id` int(11) NOT NULL,
  `name` varchar(64) NOT NULL,
  `templatesetvar` varchar(64) NOT NULL,
  `description` mediumtext,
  `type` int(2) NOT NULL DEFAULT '0',
  `selection` mediumtext,
  `selectlist` int(11) DEFAULT NULL,
  `checkrequried` binary(1) DEFAULT NULL,
  `size` int(11) DEFAULT NULL,
  `maxlength` int(11) DEFAULT NULL,
  `rows` int(11) DEFAULT NULL,
  `br` binary(1) DEFAULT NULL,
  `fieldgroup_id` int(11) DEFAULT NULL,
   `orderno` int(2) DEFAULT NULL,
  `allow_display` binary(1) DEFAULT 0,
  `allow_edit` binary(1) DEFAULT 0,
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` mediumint(8) NOT NULL,
  PRIMARY KEY (`field_id`)
) ENGINE=MyISAM
";

//グループ 定義
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_def_group']} (
  `group_id` int(11) NOT NULL,
  `code` varchar(40) DEFAULT NULL,
  `name` varchar(64) NOT NULL,
  `description` mediumtext,
  `orderno` int(2) DEFAULT NULL,
  `parent_flg` binary(1) NOT NULL DEFAULT '0',
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` mediumint(8) NOT NULL,
  PRIMARY KEY (`group_id`)
) ENGINE=MyISAM
";

$_SQL[] = "
INSERT INTO {$_TABLES['USERBOX_def_group']} (
`group_id` 
)
VALUES (
'0'
)
";
//XML 定義
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_def_xml']} (
  `seq` int(11) NOT NULL AUTO_INCREMENT,
  `tag` varchar(64) NOT NULL,
  `value` varchar(64) DEFAULT NULL,
  `field` varchar(50) NOT NULL,
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `uuid` mediumint(8) NOT NULL,
  PRIMARY KEY (`seq`)
) ENGINE=MyISAM
";

//マスタ
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_mst']} (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kind` varchar(16) NOT NULL,
  `no` int(2) NOT NULL,
  `value` varchar(64) NOT NULL,
  `value2` varchar(64) DEFAULT NULL,
  `disp` varchar(64) DEFAULT NULL,
  `orderno` int(2) DEFAULT NULL,
  `relno` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `kind` (`kind`,`no`),
  KEY `kind_2` (`kind`,`orderno`)
) ENGINE=MyISAM
";

//アクセス数テーブル
$_SQL[] = "
CREATE TABLE {$_TABLES['USERBOX_stats']} (
  `id` int(11) NOT NULL,
  `hits` int(11) NOT NULL DEFAULT '0',
  `udatetime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM
";
?>