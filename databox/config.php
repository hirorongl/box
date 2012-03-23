<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// |                                                                           |
// +---------------------------------------------------------------------------+
// $Id: plugins/databox/config.php
//20100818 tsuchitani AT ivywe DOT co DOT  jp http://www.ivywe.co.jp/
//20111201

$_DATABOX_CONF = array();

$databox_config = config::get_instance();
$_DATABOX_CONF = $databox_config->get_config('databox');

include_once 'version.php';

// データベーステーブル名 - 原則変更禁止
$_TABLES['DATABOX_base']    		= $_DB_table_prefix . 'databox_base';
$_TABLES['DATABOX_category']    	= $_DB_table_prefix . 'databox_category';
$_TABLES['DATABOX_addition']    	= $_DB_table_prefix . 'databox_addition';
//
$_TABLES['DATABOX_def_category']    = $_DB_table_prefix . 'databox_def_category';
$_TABLES['DATABOX_def_field']    	= $_DB_table_prefix . 'databox_def_field';
$_TABLES['DATABOX_def_group']    	= $_DB_table_prefix . 'databox_def_group';
$_TABLES['DATABOX_stats']    		= $_DB_table_prefix . 'databox_stats';
//
$_TABLES['DATABOX_mst']    = $_DB_table_prefix . 'databox_mst';

//
$_TABLES['DATABOX_def_xml']    = $_DB_table_prefix . 'databox_def_xml';

//
$_TABLES['DATABOX_def_category_name']    = $_DB_table_prefix . 'databox_def_category_name';
$_TABLES['DATABOX_def_field_name']    = $_DB_table_prefix . 'databox_def_field_name';
$_TABLES['DATABOX_def_group_name']    = $_DB_table_prefix . 'databox_def_group_name';


?>