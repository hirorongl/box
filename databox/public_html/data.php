<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | data.php 表示                                                             |
// +---------------------------------------------------------------------------+
// $Id: data.php
// public_html/databox/data.php
// 2010/07/30 tsuchitani AT ivywe DOT co DOT jp
// 20110905

define ('THIS_SCRIPT', 'databox/data.php');
//define ('THIS_SCRIPT', 'databox/test.php');


require_once('../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

//debug 時 true
$_DATABOX_VERBOSE = false;




function fncList()
// +---------------------------------------------------------------------------+
// | 機能  一覧表示                                                            |
// | 書式 fncList()                                                            |
// +---------------------------------------------------------------------------+\
// | 戻値 nomal:一覧                                                           |
// +---------------------------------------------------------------------------+
{
    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $LANG09;

    global $_DATABOX_CONF;
    global $LANG_DATABOX_ADMIN;
    global $LANG_DATABOX;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';
	$retval .= COM_startBlock($LANG_DATABOX['list']);
	
    //MENU1:管理画面
    $menu_arr = array ();

    if ($_DATABOX_CONF['hide_whatsnew'] == 'hide') {
        $datecolumn = 'created';
    } else {
        $datecolumn = $_DATABOX_CONF['hide_whatsnew'];
    }

    //ヘッダ：編集～
    $header_arr[] = array('text' => $LANG_DATABOX_ADMIN['orderno'], 'field' => 'orderno', 'sort' => true);
    if ($_DATABOX_CONF['datacode']){
        $header_arr[] = array('text' => $LANG_DATABOX_ADMIN['code'], 'field' => 'code', 'sort' => true);
    }else{
        $header_arr[] = array('text' => $LANG_DATABOX_ADMIN['id'], 'field' => 'id', 'sort' => true);
    }

    $header_arr[] = array('text' => $LANG_DATABOX_ADMIN['title'], 'field' => 'title', 'sort' => true);
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN[$datecolumn], 'field' => $datecolumn, 'sort' => true);
    //
    $text_arr = array('has_menu' =>  true,
      'has_extras'   => true,
      'form_url' => $_CONF['site_url'] . "/".THIS_SCRIPT);


    $sql = "SELECT ";
    $sql .= " id";
    $sql .= " ,title";
    $sql .= " ,code";
    $sql .= " ,draft_flag";
    $sql .= " ,udatetime";
    $sql .= " ,orderno";
    $sql .= " ,".$datecolumn;

    $sql .= " FROM ";
    $sql .= " {$_TABLES['DATABOX_base']} AS t";
    $sql .= " WHERE ";
    $sql .= " 1=1";

    //管理者の時,下書データも含む
    //if ( SEC_hasRights('databox.admin')) {
    //}else{
       $sql .= " AND draft_flag=0".LB;
    //}
    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND');
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())";

    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())";
    //

    $query_arr = array(
        'table' => 'DATABOX_base',
        'sql' => $sql,
        'query_fields' => array('orderno','id','title','code','draft_flag'),
        'default_filter' => $exclude);
    //デフォルトソート項目:
    $defsort_arr = array('field' => 'orderno', 'direction' => 'ASC');
    //List 取得
    //ADMIN_list($component, $fieldfunction, $header_arr, $text_arr,
    //       $query_arr, $menu_arr, $defsort_arr, $filter = '', $extra = '', $options = '')
    $retval .= ADMIN_list(
        'databox'
        , "fncGetListField"
        , $header_arr
        , $text_arr
        , $query_arr
        , $defsort_arr
	);
	
    $retval .= COM_endBlock();

    return $retval;
}

function fncGetListField(
	$fieldname
	, $fieldvalue
	, $A
	, $icon_arr
)
// +---------------------------------------------------------------------------+
// | 一覧取得 ADMIN_list で使用
// +---------------------------------------------------------------------------+
{
    global $_CONF;
    global $LANG_ACCESS;
    global $_DATABOX_CONF;

    $retval = '';

    switch($fieldname) {
        //名
        case 'title':
            $name=COM_stripslashes($A['title']);
            $url=$_CONF['site_url'] . "/databox/data.php";
            $url.="?";
            if ($_DATABOX_CONF['datacode']){
                $url.="m=code";
                $url.="&code=".$A['code'];
            }else{
                $url.="m=id";
                $url.="&id=".$A['id'];
            }
            $url = COM_buildUrl( $url );
            $retval= COM_createLink($name, $url);
            break;

       //各項目
       default:
           $retval = $fieldvalue;
           break;
    }

    return $retval;

}


function fncComment(
	$id
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

    $sql .= " FROM ";
    $sql .= " {$tbl} AS t ";//base
    $sql .= " WHERE ";
    $sql .= " id=".$id;
	
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
			$retval .= CMT_userComments($id, $A['topic'], 'databox',
                                $order, $mode, 0, $page, false,
                                $delete_option, $A['commentcode']);
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



// 引数
$msg = '';
if (isset ($_REQUEST['msg'])) {
    $msg = COM_applyFilter ($_REQUEST['msg'], true);
}

if ($_CONF['url_rewrite']){
    COM_setArgNames(array('m','arg','template','arg2'));

    $m=COM_applyFilter(COM_getArgument('m'));
    //code 使用の時
    if ($m==="code"){
        $id=0;
        $code=COM_applyFilter(COM_getArgument('arg'));
    }elseif ($m==="id"){
        $id=COM_applyFilter(COM_getArgument('arg'),true);
        $code=0;
    }else{
        $id = COM_applyFilter($_REQUEST['id'],true);
        $code = COM_applyFilter($_REQUEST['code']);
        $template = COM_applyFilter($_REQUEST['template']);
    }
    $template=COM_applyFilter(COM_getArgument('template'));

}else{
    $id = COM_applyFilter($_REQUEST['id'],true);
    $code = COM_applyFilter($_REQUEST['code']);
    $template = COM_applyFilter($_REQUEST['template']);
}

if ($id===0){
    if ($code<>""){
        $id=DATABOX_codetoid(
            $code,'DATABOX_base',"id");
    }
}

$display = '';
$page_title= $LANG_DATABOX['data'];

//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_DATABOX_CONF['loginrequired'] === 3)
            OR ($_DATABOX_CONF['loginrequired'] === 2)
            OR ($_DATABOX_CONF['loginrequired'] === 1 AND $id>0) ){
        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }

}

// 'コメントを追加',
if (isset ($_POST['reply']) && ($_POST['reply'] == $LANG01[25])) {
    $display .= COM_refresh ($_CONF['site_url'] . '/comment.php?sid='
             . $_POST['pid'] . '&pid=' . $_POST['pid']
             . '&type=' . $_POST['type']);
    echo $display;
    exit;
}

//
if ($id===0 ) {
    $display .= DATABOX_siteHeader($pi_name,'',$page_title);
    if (isset ($msg)) {
        $display .= COM_showMessage ($msg,$pi_name);
    }
    $display .= fncList();
}else{
    $display .= databox_data($id,$template,"yes","page");
    $display .= fncComment($id);
	
}
$display .= DATABOX_siteFooter($pi_name);

COM_output($display);


?>
