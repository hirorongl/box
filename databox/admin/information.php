<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | information.php 
// +---------------------------------------------------------------------------+
// $Id: information.php
// public_html/admin/plugins/databox/information.php
// 20100910 tsuchitani AT ivywe DOT co DOT jp
// 20120720

define ('THIS_SCRIPT', 'information.php');

include_once('databox_functions.php');

function fncDisplay()
// +---------------------------------------------------------------------------+
// | 機能  表示                                                                |
// | 書式 fncDisplay()                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:表示                                                           |
// +---------------------------------------------------------------------------+
{
	global $_CONF;
	global $LANG_DATABOX_ADMIN;
	global $LANG_DATABOX_INFORMATION_HELP;
	global $_DATABOX_CONF;
	
	$retval="";
	
	$pi_name="databox";
    $tmplfld=DATABOX_templatePath('admin','default',$pi_name);
    $T = new Template($tmplfld);
	
	$lang = COM_getLanguageName();
	$path = 'admin/plugins/databox/docs/';
	if (!file_exists($_CONF['path_html'] . $path . $lang . '/')) {
		$lang = 'japanese';//'english';
	}
	$document_url = $_CONF['site_url'] . '/' . $path . $lang . '/';

	$T->set_file ('admin','information.thtml');
	$T->set_var ('pi_name',$pi_name);
	$T->set_var('version',$_DATABOX_CONF['version']);

	$T->set_var('piname', $LANG_DATABOX_ADMIN['piname']);
	$T->set_var('about_thispage', $LANG_DATABOX_ADMIN['about_admin_information']);
	
	$T->set_var('lang_document', $LANG_DATABOX_ADMIN['document']);
	$T->set_var('document_url',$document_url);
	
	$T->set_var('online', $LANG_DATABOX_ADMIN['online']);
	$T->set_var('lang_configuration', $LANG_DATABOX_ADMIN['configuration']);
	$T->set_var('lang_autotags', $LANG_DATABOX_ADMIN['autotags']);
	
    $T->set_var('site_url', $_CONF['site_url']);
    $T->set_var('site_admin_url', $_CONF['site_admin_url']);
	
    $T->parse('output', 'admin');
    $retval.= $T->finish($T->get_var('output'));

    return $retval;
}


// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
// 引数
//############################
$pi_name="databox";
//############################

$menuno=1;
$display = '';
$information = array();

$information['pagetitle']=$LANG_DATABOX_ADMIN['piname'];
$display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
$display.=fncDisplay();

$display=DATABOX_displaypage($pi_name,'_admin',$display,$information);
COM_output($display);

?>
