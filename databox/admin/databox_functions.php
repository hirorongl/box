<?php
// +---------------------------------------------------------------------------+
// | databox_function 共通＆navbarMenu設定                                     |
// +---------------------------------------------------------------------------+
// $Id: databox_function.php
// public_html/admin/plugins/databox/databox_function.php
// 20100924 tsuchitani AT ivywe DOT co DOT jp
// 20120509 fieldset add

define ('THIS_PLUGIN', 'databox');

require_once('../../../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

require_once ($_CONF['path'] . 'plugins/databox/lib/ppNavbar.php');

$edt_flg=FALSE;

// 権限チェック
if (SEC_hasRights('databox.admin')) {
}else{
    $display="";
    $display .= COM_siteHeader('menu', $MESSAGE[30]);
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[35];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();

    // Log attempt to error.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the databox administration screen.");

    echo $display;

    exit;
}

$adminurl=$_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN."/";
$navbarMenu = array();
$navbarMenu[$LANG_DATABOX_admin_menu['1']]= $adminurl.'information.php';
$navbarMenu[$LANG_DATABOX_admin_menu['2']]= $adminurl.'data.php';
$navbarMenu[$LANG_DATABOX_admin_menu['3']]= $adminurl.'field.php';
$navbarMenu[$LANG_DATABOX_admin_menu['31']]= $adminurl.'fieldset.php';
$navbarMenu[$LANG_DATABOX_admin_menu['4']]= $adminurl.'category.php';
$navbarMenu[$LANG_DATABOX_admin_menu['5']]= $adminurl.'group.php';
$navbarMenu[$LANG_DATABOX_admin_menu['6']]= $adminurl.'backuprestore.php';

//
$pro=$_CONF['path'] . 'plugins/databox/proversion/';

if (file_exists($pro)) {
    $navbarMenu[$LANG_DATABOX_admin_menu['8']]= $adminurl.'pro.php';
}

?>