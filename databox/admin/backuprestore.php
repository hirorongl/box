<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | BACKUP & RESTORE
// +---------------------------------------------------------------------------+
// $Id: backuprestore.php
// public_html/admin/plugins/databox/backuprestore.php
// 20120327 tsuchitani AT ivywe DOT co DOT jp

// @@@@@追加予定：データのバックアップリストア
// @@@@@追加予定：データのクリア
// @@@@@追加予定：サンプルデータのインポート

define ('THIS_SCRIPT', 'backuprestore.php');
//define ('THIS_SCRIPT', 'test.php');

require_once('databox_functions.php');
require_once ($_CONF['path'] . 'plugins/assist/lib/lib_configuration.php');


function fncDisply(
	$pi_name
)
// +---------------------------------------------------------------------------+
// | 画面表示
// | 書式 fncDisply($pi_name)
// +---------------------------------------------------------------------------+
// | 戻値 nomal:編集画面
// +---------------------------------------------------------------------------+
// 20101126
{
    global $_CONF;
    global $LANG_DATABOX_ADMIN;

    $tmplfld=DATABOX_templatePath('admin','default',$pi_name);
    $templates = new Template($tmplfld);
    $templates->set_file (array (
        'list' => 'backuprestore.thtml',
    ));

    $templates->set_var('about_thispage', $LANG_DATABOX_ADMIN['about_admin_backuprestore']);
    $templates->set_var ('site_admin_url', $_CONF['site_admin_url']);

    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);
    $templates->set_var('gltoken_name', CSRF_TOKEN);
    $templates->set_var('gltoken', $token);
    $templates->set_var ( 'xhtml', XHTML );


    $templates->set_var ( 'config', $LANG_DATABOX_ADMIN['config']);
    $templates->set_var ( 'config_backup', $LANG_DATABOX_ADMIN['config_backup']);
    $templates->set_var ( 'config_init', $LANG_DATABOX_ADMIN['config_init']);
	$templates->set_var ( 'config_restore', $LANG_DATABOX_ADMIN['config_restore']);
    $templates->set_var ( 'config_update', $LANG_DATABOX_ADMIN['config_update']);
	
    $templates->set_var ( 'config_backup_help', $LANG_DATABOX_ADMIN['config_backup_help']);
    $templates->set_var ( 'config_init_help', $LANG_DATABOX_ADMIN['config_init_help']);
    $templates->set_var ( 'config_restore_help', $LANG_DATABOX_ADMIN['config_restore_help']);
	$templates->set_var ( 'config_update_help', $LANG_DATABOX_ADMIN['config_update_help']);

    $err_backup_file= "";
    if (file_exists($_CONF["path_data"]."databoxconfig_bak.php")) {
        $templates->set_var ('restore_disable', "");
        if (is_writable($_CONF["path_data"]."databoxconfig_bak.php")) {
        }else{
            $err_backup_file= $LANG_DATABOX_ADMIN['err_backup_file_non_writable'];
        }

    }else{
        $templates->set_var ('restore_disabled', "disabled");
        $err_backup_file= $LANG_DATABOX_ADMIN['err_backup_file_not_exist'];
    }
    $templates->set_var ('err_backup_file', $err_backup_file);

    $templates->parse ('output', 'list');

    $content = $templates->finish ($templates->get_var ('output'));
    $retval .=$content;

    return $retval ;

}


// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'databox';
//############################

$action ="";
if (isset ($_REQUEST['action'])) {
    $action = COM_applyFilter($_REQUEST['action'],false);
}

if ($action=="" ) {
}else{
    if (!SEC_checkToken()){
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
}

$display = '';
$menuno=6;
$information = array();


$information['pagetitle']=$LANG_DATABOX_ADMIN['piname']."backup and restore";
$display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
if (isset ($_REQUEST['msg'])) {
    $display .= COM_showMessage (COM_applyFilter ($_REQUEST['msg'],
                                                  true), $pi_name);
}

switch ($action) {
    case $LANG_DATABOX_ADMIN['config_init']:
        $display.=LIB_Deleteconfig($pi_name,$config);
        $display.=LIB_Initializeconfig($pi_name);
        break;
    case $LANG_DATABOX_ADMIN['config_backup']:
        $display.=LIB_Backupconfig($pi_name);
        break;
    case $LANG_DATABOX_ADMIN['config_restore'];
        $display.=LIB_Restoreconfig($pi_name,$config);
		break;
    case $LANG_DATABOX_ADMIN['config_update']:
		$display.=LIB_Backupconfig($pi_name,"update");
		$display.=LIB_Deleteconfig($pi_name,$config);
		$display.=LIB_Initializeconfig($pi_name);
		$display.=LIB_Restoreconfig($pi_name,$config,"update");

    default:
}

$display.=fncDisply($pi_name);

$display=DATABOX_displaypage($pi_name,'_admin',$display,$information);
COM_output($display);


?>