<?php
// +---------------------------------------------------------------------------+
// | databox_function 共通＆dataのTopMenu設定
// +---------------------------------------------------------------------------+
// $Id: databox_function.php
// public_html/databox/mydata/databox_function.php
// 20110120 tsuchitani AT ivywe DOT co DOT jp
//last update 20181106 hiroron AT hiroron DOT COM

define ('THIS_PLUGIN', 'databox');

require_once('../../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    COM_handle404();
    exit;
}

//require_once ($_CONF['path'] . 'plugins/databox/lib/ppNavbar.php');
require_once( $_CONF['path_system'] . 'lib-admin.php' );

$edt_flg=FALSE;

//############################
$pi_name    = 'databox';
//############################

//ログインチェック
if (COM_isAnonUser()){
	$information = array();
	$information['pagetitle']=$LANG_DATABOX['mydata'];
    $display="";
    $display .= SEC_loginRequiredForm();
	$display=DATABOX_displaypage($pi_name,'',$display,$information);
    COM_output($display);
    exit;
}


$dataurl=$_CONF['site_url'] ."/".THIS_PLUGIN."/mydata/";
//uikit3でnavbarが使えなくなったのでコメントアウト
//$navbarMenu = array();
//$navbarMenu[$LANG_DATABOX_user_menu['2']]= $url.'data.php';
$menu_arr=array(
    array('text'=>$LANG_DATABOX_user_menu['2'], 'url'=>$dataurl.'data.php'),
);
$data_menu_top = ADMIN_createMenu(
    $menu_arr,
    $LANG_DATABOX_user_menu['instructions']
);


?>