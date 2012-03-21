<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | category Maintenance
// +---------------------------------------------------------------------------+
// $Id: category.php

// public_html/admin/plugins/databox/group.php
// public_html/admin/plugins/userbox/group.php
// public_html/admin/plugins/formbox/group.php
// 20101111 tsuchitani AT ivywe DOT co DOT jp
// @@@@@追加予定：import
// @@@@@追加予定：更新したらメール送信

define ('THIS_SCRIPT', 'userbox/category.php');
//define ('THIS_SCRIPT', 'userbox/test.php');

require_once('userbox_functions.php');
require_once ($_CONF['path'] . 'plugins/userbox/lib/lib_category.php');

// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'userbox';
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
if ($mode=="" OR $mode=="edit" OR $mode=="new" OR $mode=="drafton" OR $mode=="draftoff"
    OR $mode=="export" OR $mode=="import" OR $mode=="copy") {
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

//
$menuno=4;
$display = '';

//echo "mode=".$mode."<br>";
switch ($mode) {
    case 'new':// 新規登録
        $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['new'];
        $display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
        $display .=ppNavbarjp($navbarMenu,$LANG_USERBOX_admin_menu[$menuno]);
        $display .= LIB_Edit($pi_name."", $edt_flg,$msg);
        $display .= DATABOX_siteFooter($pi_name,'_admin');
        break;

    case 'save':// 保存
        $display .= LIB_Save ($pi_name,$edt_flg,$navbarMenu,$menuno);
        break;
    case 'delete':// 削除
        $display .= LIB_delete($pi_name);
    break;
    case 'copy'://コピー
    case 'edit':// 編集
        if (!empty ($id) ) {
            $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['edit'];
            $display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);

            if ($edt_flg==FALSE){
                $display.=ppNavbarjp($navbarMenu,$LANG_USERBOX_admin_menu[$menuno]);
            }
            $display .= LIB_Edit($pi_name,$id, $edt_flg,$msg,"",$mode);
            $display .= DATABOX_siteFooter($pi_name,'_admin');

        }
        break;

    case 'import':// インポート
        $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['import'];
        $display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);

        $display .= fncimport();
        $display .= DATABOX_siteFooter($pi_name,'_admin');

        break;


    default:// 初期表示、一覧表示

        $page_title=$LANG_USERBOX_ADMIN['piname'];
        $display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);

        if (isset ($msg)) {
            $display .= COM_showMessage ($msg,$pi_name);
        }
        $display.=ppNavbarjp($navbarMenu,$LANG_USERBOX_admin_menu[$menuno]);

        $display .= LIB_List($pi_name);
        $display .= DATABOX_siteFooter($pi_name,'_admin');


}



COM_output($display);

?>
