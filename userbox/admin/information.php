<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | information.php
// +---------------------------------------------------------------------------+
// $Id: information.php
// public_html/admin/plugins/userbox/information.php
// 20100910 tsuchitani AT ivywe DOT co DOT jp

// @@@@@追加予定：information.thtml の編集

define ('THIS_SCRIPT', 'information.php');

include_once('userbox_functions.php');

// +---------------------------------------------------------------------------+
// | 機能  表示                                                                |
// | 書式 fncDisplay()                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:表示                                                           |
// +---------------------------------------------------------------------------+
//20101110
function fncDisplay()
{

    $pi_name="userbox";

    global $_CONF;
    global $LANG_USERBOX_ADMIN;
    global $LANG_USERBOX_INFORMATION_HELP;
	global $_USERBOX_CONF;
	

    $retval="";
	
	$pi_name="userbox";

    $tmplfld=DATABOX_templatePath('admin','default',$pi_name);
	$T = new Template($tmplfld);
	
	$lang = COM_getLanguageName();
	$path = 'admin/plugins/userbox/docs/';
	//$path = 'docs/';
	if (!file_exists($_CONF['path_html'] . $path . $lang . '/')) {
		$lang = 'japanese';//'english';
	}
	$document_url = $_CONF['site_url'] . '/' . $path . $lang . '/';

    $T->set_file ('admin','information.thtml');
	$T->set_var ('pi_name',$pi_name);
	$T->set_var('version',$_USERBOX_CONF['version']);

	$T->set_var('piname', $LANG_USERBOX_ADMIN['piname']);
    $T->set_var('about_thispage', $LANG_USERBOX_ADMIN['about_admin_information']);

	$T->set_var('lang_document', $LANG_USERBOX_ADMIN['document']);
	$T->set_var('document_url',$document_url);
	
	$T->set_var('online', $LANG_USER_ADMIN['online']);
	$T->set_var('lang_configuration', $LANG_USERBOX_ADMIN['configuration']);
	$T->set_var('lang_autotags', $LANG_USERBOX_ADMIN['autotags']);
	
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
$pi_name    = 'userbox';
//############################



if ($mode=="" OR $mode=="importform" OR $mode=="deleteform") {
}else{
    if (!SEC_checkToken()){
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
}
$menuno=1;
$display = '';

//
$page_title=$LANG_USERBOX_ADMIN['piname'];
$display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);

if (isset ($_REQUEST['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                  true), $pi_name);
}

$display .=ppNavbarjp($navbarMenu,$LANG_USERBOX_admin_menu[$menuno]);

$display.=fncDisplay();

$display .= DATABOX_siteFooter($pi_name,'_admin');

echo $display;

?>
