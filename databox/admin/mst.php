<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | master Maintenance
// +---------------------------------------------------------------------------+
// $Id: mst.php
// 20121204 tsuchitani AT ivywe DOT co DOT jp

define ('THIS_SCRIPT', 'databox/mst.php');
//define ('THIS_SCRIPT', 'databox/test.php');

require_once('databox_functions.php');
require_once ($_CONF['path'] . 'plugins/databox/lib/lib_mst.php');


// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'databox';
//############################

// 引数
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode'], false);
}
$msg = '';
if (isset ($_REQUEST['msg'])) {
    $msg = COM_applyFilter ($_REQUEST['msg'], true);
}
$id = '';
if (isset ($_REQUEST['id'])) {
    $id = COM_applyFilter ($_REQUEST['id'], true);
}

$old_mode="";
if (isset($_REQUEST['old_mode'])) {
    $old_mode = COM_applyFilter($_REQUEST['old_mode'],false);
    if ($mode==$LANG_ADMIN['cancel']) {
        $mode = $old_mode;
    }
}

if (($mode == $LANG_ADMIN['save']) && !empty ($LANG_ADMIN['save'])) { // save
    $mode="save";
}else if (($mode == $LANG_ADMIN['delete']) && !empty ($LANG_ADMIN['delete'])) {
    $mode="delete";
}

//echo "mode=".$mode."<br>";
if ($mode=="" 
	OR $mode=="edit" 
	OR $mode=="new" 
	OR $mode=="export" 
	OR $mode=="sampleimport" 
	OR $mode=="copy"
	) {
}else{
    if (!SEC_checkToken()){
 //    if (SEC_checkToken()){//テスト用
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
}


if ($mode=="export") {
    LIB_export ($pi_name);
    exit;
}
if ($mode=="sampleimport") {
    LIB_sampleimport ($pi_name);
}

//
$menuno=51;
$display = '';
$information = array();

switch ($mode) {
    case 'new':// 新規登録
        $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['new'];
        $display .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
        $display .= LIB_Edit($pi_name."", $edt_flg,$msg);
        break;

    case 'save':// 保存
		$display.=ppNavbarjp($navbarMenu,$LANG_ASSIST_admin_menu[$menuno]);
		$retval= LIB_Save ($pi_name,$edt_flg,$navbarMenu,$menuno);
        $information['pagetitle']=$retval['title'];
		$display.=$retval['display'];
        break;
    case 'delete':// 削除
        $display .= LIB_delete($pi_name);
    break;
    case 'copy'://コピー
    case 'edit':// 編集
        if (!empty ($id) ) {
            $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
            if ($edt_flg==FALSE){
                $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
            }
            $display .= LIB_Edit($pi_name,$id, $edt_flg,$msg,"",$mode);
        }
        break;

    default:// 初期表示、一覧表示

        $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'];
        if (isset ($msg)) {
            $display .= COM_showMessage ($msg,$pi_name);
        }
        $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);

        $display .= LIB_List($pi_name);

}

$display=DATABOX_displaypage($pi_name,'_admin',$display,$information);

COM_output($display);

?>
