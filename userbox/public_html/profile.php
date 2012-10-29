<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | profile.php 表示                                                             |
// +---------------------------------------------------------------------------+
// $Id: profile.php
// public_html/userbox/profile.php
// 20110203 tsuchitani AT ivywe DOT co DOT jp
//20111007

define ('THIS_SCRIPT', 'userbox/profile.php');
//define ('THIS_SCRIPT', 'userbox/test.php');


require_once('../lib-common.php');
if (!in_array('userbox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

//debug 時 true
$_USERBOX_VERBOSE = false;






// +---------------------------------------------------------------------------+
// | 機能  一覧表示                                                            |
// | 書式 fncList()                                                            |
// +---------------------------------------------------------------------------+\
// | 戻値 nomal:一覧                                                           |
// +---------------------------------------------------------------------------+
// 20110613
function fncList()
{
    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $LANG09;
    global $LANG28;

    global $LANG_USERBOX_ADMIN;
    global $LANG_USERBOX;

    global $_USERBOX_CONF;

    $table = $_TABLES['USERBOX_base'];
    $table1 = $_TABLES['users'];

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';
	$retval .= COM_startBlock($LANG_USERBOX['list']);

    //MENU1:管理画面
    $menu_arr = array ();

    if ($_USERBOX_CONF['hide_whatsnew'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }

    //ヘッダ：編集～
    $header_arr[]=array('text' => $LANG28['2'], 'field' => 'id', 'sort' => true);
    $header_arr[]=array('text' => $LANG28['3'], 'field' => 'username', 'sort' => username);
    $header_arr[]=array('text' => $LANG_USERBOX_ADMIN[$datecolumn], 'field' => $datecolumn, 'sort' => true);

    $header_arr[]=array('text' => $LANG28['4'], 'field' => 'fullname', 'sort' => fullname);

    //
    $text_arr = array('has_menu' =>  true,
      'has_extras'   => true,
      'form_url' => $_CONF['site_url'] . "/".THIS_SCRIPT);

//kokokara
    $sql = "SELECT ";
    $sql .= " id";
    $sql .= " ,draft_flag";
     $sql .= " ,UNIX_TIMESTAMP(udatetime) AS udatetime";
    $sql .= " ,orderno";
    $sql .= " ,UNIX_TIMESTAMP(".$datecolumn.") AS ".$datecolumn;

    $sql .= " ,t1.username";
    $sql .= " ,t1.fullname";

    $sql .= " FROM ";
    $sql .= " {$table} AS t";
    $sql .= " ,{$table1} AS t1";
    $sql .= " WHERE ";
    $sql .= " t.id=t1.uid";

    //管理者の時,下書データも含む
    //if ( SEC_hasRights('userbox.admin')) {
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
        'table' => " {$table} AS t ,{$table1} AS t1",
        'sql' => $sql,
        'query_fields' => array('id','username','fullname','draft_flag'),
        'default_filter' => $exclude);
    //デフォルトソート項目:
    $defsort_arr = array('field' => 'id', 'direction' => 'ASC');
    //List 取得
    //ADMIN_list($component, $fieldfunction, $header_arr, $text_arr,
    //       $query_arr, $menu_arr, $defsort_arr, $filter = '', $extra = '', $options = '')
    $retval .= ADMIN_list(
        'userbox'
        , "fncGetListField"
        , $header_arr
        , $text_arr
        , $query_arr
        , $defsort_arr
        );

    $retval .= COM_endBlock();

    return $retval;
}

// +---------------------------------------------------------------------------+
// | 一覧取得 ADMIN_list で使用
// +---------------------------------------------------------------------------+
function fncGetListField($fieldname, $fieldvalue, $A, $icon_arr)
{

    $pi_name="userbox";

    global $_CONF;
    global $LANG_ACCESS;

    global $_USERBOX_CONF;


    $retval = '';

    switch($fieldname) {
        //コード
        case 'code':
            $name=COM_applyFilter($A['code']);
            $url=$_CONF['site_url'] . "/".THIS_SCRIPT;
            $url.="?";
            $url.="m=code";
            $url.="&code=".$A['code'];
            $url = COM_buildUrl( $url );
            $retval= COM_createLink($name, $url);
            break;

        //氏名
        case 'username':
            $username=COM_applyFilter($A['username']);
            $url=$_CONF['site_url'] . "/userbox/profile.php";
            $url.="?";
            if ($_USERBOX_CONF['datacode']){
                $url.="m=code";
                $url.="&code=".$A['username'];
            }else{
                $url.="m=id";
                $url.="&id=".$A['id'];
            }
            $url = COM_buildUrl( $url );
            $retval= COM_createLink($username, $url);
            break;
		case 'udatetime':
		case 'modified':
		case 'created':
		case 'released':
			$curtime = COM_getUserDateTimeFormat($A['{$fieldname}']);
			$retval = $curtime[0];
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
		$mode = COM_applyFilter ($_REQUEST['mode']);
	}
	$page = 1;
	if (isset ($_REQUEST['cpage'])) {
		$page = COM_applyFilter ($_REQUEST['cpage']);
	}
	//
	
    $tbl=$_TABLES['USERBOX_base'] ;

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
			$delete_option = (SEC_hasRights('userbox.edit') &&
                    SEC_hasAccess($A['owner_id'], $A['group_id'],
                    $A['perm_owner'], $A['perm_group'], $A['perm_members'],
                    $A['perm_anon']) == 3 ? true : false);
	
			require_once $_CONF['path_system'] . 'lib-comment.php';
			$retval .= CMT_userComments($id, $A['topic'], 'userbox',
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
$pi_name    = 'userbox';
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

$code=DATABOX_swichlang($code);

$display = '';
$page_title= $LANG_USERBOX['profile'];


//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_USERBOX_CONF['loginrequired'] === "3")
            OR ($_USERBOX_CONF['loginrequired'] === "2")
            OR ($_USERBOX_CONF['loginrequired'] === "1" AND $id>0) ){
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


if ($id===0 AND $code==="") {
    $page_title=$LANG_USERBOX_ADMIN['piname'];
    $display .= DATABOX_siteHeader($pi_name,'',$page_title);

    if (isset ($msg)) {
        $display .= COM_showMessage ($msg,$pi_name);
    }
    $display .= fncList();

}else{
	$display .= userbox_profile($id,$template,"yes","page",$code);
    $display .= fncComment($id);
}
$display .= DATABOX_siteFooter($pi_name);

echo $display;

?>
