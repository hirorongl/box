<?php
// +---------------------------------------------------------------------------+
// | userbox_function 共通＆navbarMenu設定                                     |
// +---------------------------------------------------------------------------+
// $Id: userbox_function.php
// public_html/admin/plugins/userbox/userbox_function.php
// 20101110 tsuchitani AT ivywe DOT co DOT jp
//last update 20181106 hiroron AT hiroron DOT COM

define ('THIS_PLUGIN', 'userbox');

require_once('../../../lib-common.php');
if (!in_array('userbox', $_PLUGINS)) {
    COM_handle404();
    exit;
}

//require_once ($_CONF['path'] . 'plugins/userbox/lib/ppNavbar.php');
require_once( $_CONF['path_system'] . 'lib-admin.php' );

$edt_flg=FALSE;

// 権限チェック
if (SEC_hasRights('userbox.admin')) {
}else{
    $display="";
    $display .= COM_siteHeader('menu', $MESSAGE[30]);
    $display .= COM_startBlock ($MESSAGE[30], '',
                                COM_getBlockTemplate ('_msg_block', 'header'));
    $display .= $MESSAGE[35];
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    $display .= COM_siteFooter();

    // Log attempt to error.log
    COM_accessLog("User {$_USER['username']} tried to illegally access the userbox administration screen.");

    echo $display;

    exit;
}

//uikit3でnavbarが使えなくなったのでコメントアウト
/*
$adminurl=$_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN."/";
$navbarMenu = array();
$navbarMenu[$LANG_USERBOX_admin_menu['1']]= $adminurl.'information.php';
$navbarMenu[$LANG_USERBOX_admin_menu['2']]= $adminurl.'profile.php';
$navbarMenu[$LANG_USERBOX_admin_menu['3']]= $adminurl.'field.php';
$navbarMenu[$LANG_USERBOX_admin_menu['31']]= $adminurl.'fieldset.php';
$navbarMenu[$LANG_USERBOX_admin_menu['4']]= $adminurl.'category.php';
$navbarMenu[$LANG_USERBOX_admin_menu['5']]= $adminurl.'group.php';
$navbarMenu[$LANG_USERBOX_admin_menu['51']]= $adminurl.'mst.php';
$navbarMenu[$LANG_USERBOX_admin_menu['6']]= $adminurl.'backuprestore.php';

$pro=$_CONF['path'] . 'plugins/userbox/proversion/';
if (file_exists($pro)) {
    $navbarMenu[$LANG_USERBOX_admin_menu['8']]= $adminurl.'xml.php';
}
*/
$adminurl=$_CONF['site_admin_url'] .'/plugins/'.THIS_PLUGIN."/";
$menu_arr = array(
    array('text' => $LANG_USERBOX_admin_menu['1'], 'url' => $adminurl.'information.php'),
    array('text' => $LANG_USERBOX_admin_menu['2'], 'url' => $adminurl.'profile.php'),
    array('text' => $LANG_USERBOX_admin_menu['3'], 'url' => $adminurl.'field.php'),
    array('text' => $LANG_USERBOX_admin_menu['31'], 'url' => $adminurl.'fieldset.php'),
    array('text' => $LANG_USERBOX_admin_menu['4'], 'url' => $adminurl.'category.php'),
    array('text' => $LANG_USERBOX_admin_menu['5'], 'url' => $adminurl.'group.php'),
    array('text' => $LANG_USERBOX_admin_menu['51'], 'url' => $adminurl.'mst.php'),
    array('text' => $LANG_USERBOX_admin_menu['6'], 'url' => $adminurl.'backuprestore.php'),
);
$pro=$_CONF['path'] . 'plugins/userbox/proversion/';
if (file_exists($pro)) {
    $menu_arr[]= array('text' => $LANG_USERBOX_admin_menu['8'], 'url' => $adminurl.'xml.php');
}
$admin_menu_top = ADMIN_createMenu(
    $menu_arr,
    $LANG_USERBOX_ADMIN['instructions'],
    plugin_geticon_userbox()
);

?>