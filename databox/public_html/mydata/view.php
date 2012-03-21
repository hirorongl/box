<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | data view
// +---------------------------------------------------------------------------+
// $Id: view.php
// public_html/databox/mydata/view.php
// 20110627 tsuchitani AT ivywe DOT co DOT jp

define ('THIS_SCRIPT', 'databox/mydata/view.php');
//define ('THIS_SCRIPT', 'databox/mydata/test.php');

//include_once('userbox_functions.php');

//require_once ($_CONF['path'] . 'plugins/userbox/lib/lib_datetimeedit.php');
//require_once $_CONF['path_system'] . 'lib-user.php';
require_once('../../lib-common.php');

//ログイン要チェック

if (empty ($_USER['username'])) {
    $page_title= $LANG_PROFILE[4];
    $display .= DATABOX_siteHeader('DATABOX','',$page_title);
    $display .= SEC_loginRequiredForm();
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    echo $display;
    exit;
}

if ($_DATABOX_CONF['allow_data_update']==1 ){
}else{
    if (SEC_hasRights ('databox.edit') ){
	}else{
	COM_accessLog("User {$_USER['username']} tried to data view	and failed ");
		echo COM_refresh($_CONF['site_url'] . '/index.php');
		exit;
	}
}

// +---------------------------------------------------------------------------+
// | 機能  データ確認画面表示
// | 書式 fncview ()
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncview ($id)
{
    $pi_name="databox";

	global $_CONF;
    global $LANG_USERBOX_ADMIN;

    //template フォルダ
    $tmplfld=DATABOX_templatePath('mydata','default',$pi_name);
    $tmpl = new Template($tmplfld);

    $tmpl->set_file (array (
                'view' => 'view.thtml',
            ));

    //--

    //$tmpl->set_var('site_admin_url', $_CONF['site_admin_url']);

	$tmpl->set_var('about_thispage', $LANG_USERBOX_ADMIN['about_admin_view']);
	
    $tmpl->parse ('output', 'view');
    $view = $tmpl->finish ($tmpl->get_var ('output'));

	$retval="";
	$retval.=$view;
	$retval.= databox_data($id,"","","view");


    return $retval;
}


// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'databox';
//############################
$id = null;
if (isset ($_REQUEST['id'])) {
    $id = COM_applyFilter ($_REQUEST['id'], true);
	//編集権のないデータ はのぞく
	$selection="id=".$id.COM_getPermSql('AND',0,3);
	$id=DB_getItem( $_TABLES['DATABOX_base'],"id",$selection);
}

if ($id===null) {
	COM_accessLog("User {$_USER['username']} tried to data view	and failed ");
		echo COM_refresh($_CONF['site_url'] . '/index.php');
		exit;
}

$display="";

$page_title=$LANG_DATABOX_ADMIN['piname'];
$display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
$display .= fncview($id);
$display .= DATABOX_siteFooter($pi_name,'_admin');

echo $display;

?>
