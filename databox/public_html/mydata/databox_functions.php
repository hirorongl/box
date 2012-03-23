<?php
// +---------------------------------------------------------------------------+
// | databox_function 共通＆navbarMenu設定                                     |
// +---------------------------------------------------------------------------+
// $Id: databox_function.php
// public_html/databox/mydata/databox_function.php
// 20110120 tsuchitani AT ivywe DOT co DOT jp
// 2011/0905
define ('THIS_PLUGIN', 'databox');

require_once('../../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

require_once ($_CONF['path'] . 'plugins/databox/lib/ppNavbar.php');

$edt_flg=FALSE;

//############################
$pi_name    = 'databox';
//############################

$page_title= $LANG_DATABOX['mydata'];
//ログインチェック
if (COM_isAnonUser()){
    $display .= DATABOX_siteHeader($pi_name,'',$page_title);
    $display .= SEC_loginRequiredForm();
    $display .= DATABOX_siteFooter($pi_name);
    COM_output($display);
    exit;
}


$url=$_CONF['site_url'] ."/".THIS_PLUGIN."/mydata/";
$navbarMenu = array();
$navbarMenu[$LANG_DATABOX_user_menu['2']]= $url.'data.php';


?>