<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | data.php 表示                                                             |
// +---------------------------------------------------------------------------+
// $Id: data.php
// public_html/databox/data.php
// 2010/07/30 tsuchitani AT ivywe DOT co DOT jp

define ('THIS_SCRIPT', 'databox/data.php');
//define ('THIS_SCRIPT', 'databox/test.php');
//debug 時 true
$_DATABOX_VERBOSE = false;

require_once('../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}


function fncComment(
	$id
	,$code
)
// +---------------------------------------------------------------------------+
// | 機能 コメント表示
// | 書式 fncComment($id)
// +---------------------------------------------------------------------------+
// | 戻値 nomal:
// +---------------------------------------------------------------------------+
{
	global $_CONF;
	global $_TABLES;
	//	
	$order = '';
	if (isset ($_REQUEST['order'])) {
		$order = COM_applyFilter ($_REQUEST['order']);
	}
	$mode = '';
	if (isset ($_REQUEST['mode'])) {
		$mode = COM_applyFilter ($_POST['mode']);
	}
	
	$page = 1;
	if (isset ($_REQUEST['cpage'])) {
		$page = COM_applyFilter ($_REQUEST['cpage']);
	}
	//
	
    $tbl=$_TABLES['DATABOX_base'] ;

    //-----
    $sql = "SELECT ";
	
	$sql .= "commentcode "; 
	$sql .= ",owner_id";
	$sql .= ",group_id";
	$sql .= ",perm_owner";
	$sql .= ",perm_group";
	$sql .= ",perm_members";
	$sql .= ",perm_anon";
	$sql .= ",title";
	$sql .= ",id";

    $sql .= " FROM ";
    $sql .= " {$tbl} AS t ";//base
	$sql .= " WHERE ";
	if   ($id<>0) {
		$sql .= " id=".$id;
	}else{
		$sql .= " code='".$code."'";
	}
    $sql .= " AND t.draft_flag=0".LB;
	
	//アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND');
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())";

    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())";
    //
	
    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);
	
    if ($numrows > 0) {

		$A = DB_fetchArray ($result);
		$A = array_map('stripslashes', $A);
		if  ($A['commentcode']>=0){
			$delete_option = (SEC_hasRights('databox.edit') &&
                    SEC_hasAccess($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3 ? true : false);
	
			require_once $_CONF['path_system'] . 'lib-comment.php';
			$retval .= CMT_userComments(
							$A['id']
							, $A['title']
							, 'databox'
							, $order
							, $mode
							, 0
							, $page
							, false
							, $delete_option
							, $A['commentcode']
							);
		}
	}
	

    return $retval;
}

// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'databox';
//############################
$display = '';
$page_title=$LANG_DATABOX_ADMIN['piname'];

// 引数
//public_html/data.php?id=1&m=id&template=yyyy
//public_html/data.php?code=xxxx_en&m=code&template=yyyy
$url_rewrite = false;
$q = false;
$url = $_SERVER["REQUEST_URI"];
if ($_CONF['url_rewrite']) {
    $q = strpos($url, '?');
    if ($q === false) {
        $url_rewrite = true;
    }elseif (substr($url, $q - 4, 4) != '.php') {
        $url_rewrite = true;
    }
}
//
if ($url_rewrite){
	COM_setArgNames(array('idcode','m','template'));
    $m=COM_applyFilter(COM_getArgument('m'));
    $template=COM_applyFilter(COM_getArgument('template'));
    //code 使用の時
    if ($m==="code"){
        $id=0;
        $code=COM_applyFilter(COM_getArgument('idcode'));
    }elseif ($m==="id"){
        $id=COM_applyFilter(COM_getArgument('idcode'),true);
		$code="";
	}else{
        $id=0;
		$code="";
    }
}else{
    $m = COM_applyFilter($_GET['m']);
    $id = COM_applyFilter($_GET['id'],true);
    $code = COM_applyFilter($_GET['code']);
    $template = COM_applyFilter($_GET['template']);
}

//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_DATABOX_CONF['loginrequired'] == 3)
            OR ($_DATABOX_CONF['loginrequired'] == 2)
            OR ($_DATABOX_CONF['loginrequired'] == 1 AND $id>0) 
            OR ($_DATABOX_CONF['loginrequired'] == 1 AND $code<>"") 
			){
        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }

}


$msg = '';
if (isset ($_GET['msg'])) {
    $msg = COM_applyFilter ($_GET['msg'], true);
}

$information = array();
// 'コメントを追加',
if (isset ($_POST['reply']) && ($_POST['reply'] == $LANG01[25])) {
    $display .= COM_refresh ($_CONF['site_url'] . '/comment.php?sid='
             . $_POST['pid'] . '&pid=' . $_POST['pid']
             . '&type=' . $_POST['type']);
    echo $display;
    exit;
}
//
if ($id===0 AND $code==="") {
	$layout=$_DATABOX_CONF['layout'];
	$information['pagetitle']=$LANG_DATABOX['data'];
    if (isset ($msg)) {
        $display .= COM_showMessage ($msg,$pi_name);
    }
	$display.=$LANG_DATABOX_ADMIN['err_id'];
}else{
    $retval= databox_data($id,$template,"yes","page",$code);
	$layout=$retval['layout'];
	$information['headercode']=$retval['headercode'];
	$information['pagetitle']=$retval['title'];
    if (isset ($msg)) {
        $display.= COM_showMessage ($msg,$pi_name);
    }
	$display.=$retval['display'];
	$display.= fncComment($id,$code);
}

$display=DATABOX_displaypage($pi_name,$layout,$display,$information);

COM_output($display);


?>
