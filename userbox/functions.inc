<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | UserBox プラグイン                                                        |
// +---------------------------------------------------------------------------+
// $Id: plugins/userbox/functions.inc
//2011622 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/

if (strpos ($_SERVER['PHP_SELF'], 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

$pi_name         = 'userbox';


//言語ファイル
$langfile = $_CONF['path'] . "plugins/{$pi_name}/language/"
          . $_CONF['language'] . '.php';

if (file_exists ($langfile)) {
    require_once ($langfile);

} else {
    require_once ($_CONF['path'] . "plugins/{$pi_name}/language/japanese_utf-8.php");
}

//custom 言語ファイル
$langfile_custom = $_CONF['path'] . "plugins/{$pi_name}/custom/language/"
          . $_CONF['language'] . '.php';

if (file_exists ($langfile_custom)) {
    require_once ($langfile_custom);
}

//設定ファイル
require_once ($_CONF['path'] . "plugins/{$pi_name}/config.php");

$_USERBOX_VERBOSE = false;
//$_USERBOX_VERBOSE = true;//FOR  TEST

//自動タグ関連の関数
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_autotag.inc");

//BOXシリーズ共通関数
if (function_exists("DATABOX_nl2br")==false) {
    require_once ($_CONF['path'] . "plugins/{$pi_name}/lib/databox_functions.inc");
}

//検索機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_search.inc");

//rss機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_feed.inc");

//stats機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_stats.inc");

//comment機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_comment.inc");

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation
// +---------------------------------------------------------------------------+

// +---------------------------------------------------------------------------+
// | 現在インストールされているバージョン取得
// | 書式 plugin_chkVersion_userbox
// +---------------------------------------------------------------------------+
function plugin_chkVersion_userbox ()
{
    global $_USERBOX_CONF;

    return $_USERBOX_CONF['version'];
}

// +---------------------------------------------------------------------------+
// | 機能  プラグイン更新:バージョンナンバーの更新                             |
// | 書式 plugin_upgrade_userbox                                               |
// +---------------------------------------------------------------------------+
function plugin_upgrade_userbox ()
{
    global $_TABLES, $_USERBOX_CONF;

    // the plugin needs these functions so complain when they doesn't exist
    if (!function_exists ('COM_truncate') ||
        !function_exists ('MBYTE_strpos')) {
        return 3002;
    }

    // no db changes - just update the version numbers
    DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_USERBOX_CONF['version']}', pi_gl_version = '" . VERSION . "' WHERE pi_name = 'userbox'");

    return true;
}

// +---------------------------------------------------------------------------+
// | 機能  プラグインアンインストール
// | 書式 plugin_autouninstall_userbox
// +---------------------------------------------------------------------------+
function plugin_autouninstall_userbox ()
{
    // (1) 削除するテーブル
    $out['tables'][]='USERBOX_addition';
    $out['tables'][]='USERBOX_base';
    $out['tables'][]='USERBOX_category';
    $out['tables'][]='USERBOX_def_category';
    $out['tables'][]='USERBOX_def_field';
    $out['tables'][]='USERBOX_def_group';
    $out['tables'][]='USERBOX_def_xml';

    $out['tables'][]='USERBOX_mst';
    $out['tables'][]='USERBOX_stats';

    // (2) 削除するグループ名
	$out['groups'][]='UserBox Admin';
	$out['groups'][]='UserBox Editor';
	$out['groups'][]='UserBox manager';
	$out['groups'][]='UserBox user';
	
    // (3) 削除するfeatures
    $out['features'][]='userbox.admin';
    $out['features'][]='userbox.edit';
	$out['features'][]='userbox.joingroup';
	$out['features'][]='userbox.user';
	
    // (4) 削除するphp_blocks
    $out['php_blocks']=array();
    // (5) 削除する vars */
    $out['vars']=array();

    return $out;

}

/**
* ☆★現在のユーザは権利があるのをチェック
*
* @return        boolean       Returns true if moderator
*
*/
function plugin_ismoderator_userbox()
{
    //return SEC_hasRights ('user.moderate');
    return true;
}



// +---------------------------------------------------------------------------+
// | 機能  プラグインのアイコン取得
// | 書式 plugin_geticon_userbox
// +---------------------------------------------------------------------------+
function plugin_geticon_userbox ()
{
    global $_CONF;

    return $_CONF['site_url'] . '/userbox/images/icons/userbox.png';
}

// +---------------------------------------------------------------------------+
// | 機能  管理画面メニュ
// | 書式 plugin_cclabel_userbox
// +---------------------------------------------------------------------------+
function plugin_cclabel_userbox()
{
    global $_CONF;

    if (SEC_hasRights('userbox.admin')) {
        return array(
        'userbox'
        ,$_CONF['site_admin_url'] . "/plugins/userbox/index.php"
        ,plugin_geticon_userbox() );
    }
    return "";

}

// +---------------------------------------------------------------------------+
// | 機能  管理者メニュ表示
// | 書式 plugin_getadminoption_usrerbox
// +---------------------------------------------------------------------------+
// | 戻値 nomal:管理者メニュリンク                                             |
// +---------------------------------------------------------------------------+
function plugin_getadminoption_userbox()
{
    global $_CONF;
    global $_TABLES;
    global $LANG_USERBOX_ADMIN;
    if (SEC_hasRights ('userbox.admin') ){
        //下書他も含む全件数
        $cnt = DB_getItem ($_TABLES['USERBOX_base'], 'COUNT(*)');
        return array ($LANG_USERBOX_ADMIN['piname'],
                      $_CONF['site_admin_url'] . '/plugins/userbox/index.php'
                      ,$cnt);


    }
    return "";

}

// +---------------------------------------------------------------------------+
// | 機能  ヘッダメニュリンクを返す                                            |
// | 書式 plugin_getmenuitems_userbox                                          |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:ヘッダメニュリンク                                             |
// +---------------------------------------------------------------------------+
function plugin_getmenuitems_userbox()
{
    global $_CONF;
    global $_USER;
    global $_USERBOX_CONF;
    global $LANG_USERBOX;


    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_USERBOX_CONF['hidemenu'] == 1) || ($anon &&
                ($_CONF['loginrequired'] || $_USERBOX_CONF['loginrequired']))) {
        return false;
    }
    $menuitems[$LANG_USERBOX['profile']] = $_CONF['site_url'] . '/userbox/index.php';

    if ($_USERBOX_CONF['allow_profile_update']==1){
        $menuitems[$LANG_USERBOX['myprofile']] = $_CONF['site_url'] . '/userbox/myprofile/index.php';
    }
    return $menuitems;
}

// +---------------------------------------------------------------------------+
// | 機能  User Function ニュリンクを返す
// | 書式 plugin_getuseroption_userbox
// +---------------------------------------------------------------------------+
// | 戻値 nomal:User Function メニュリンク
// +---------------------------------------------------------------------------+
//
function plugin_getuseroption_userbox()
{
    global $_CONF;
    global $LANG_USERBOX;
    global $_USERBOX_CONF;
	
	$url = $_CONF['site_url'] . '/userbox/myprofile/index.php';
    if ($_USERBOX_CONF['allow_profile_update']==1){
		return array ($LANG_USERBOX['myprofile'], $url, '');
	}else{	
	   if (SEC_hasRights ('userbox.edit') OR SEC_hasRights ('userbox.joingroup')){
		   return array ($LANG_USERBOX['myprofile'], $url, '');
	   }else{
           return;
	   }
	}

}

// +---------------------------------------------------------------------------+
// | 機能  新着
// | 書式 plugin_whatsnewsupported_userbox
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function plugin_whatsnewsupported_userbox()
{
    global $_TABLES;
    global $_USERBOX_CONF;
    global $LANG_USERBOX;
    global $LANG_WHATSNEW;


    if ( $_USERBOX_CONF['hide_whatsnew'] == 'hide' ) {
        $retval = false;
    } else {
        $retval = array( $LANG_USERBOX['pidata'],
                         COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                               $_USERBOX_CONF['whatsnew_interval'] )
                       );
    }
    return $retval;
}

// +---------------------------------------------------------------------------+
// | 機能  新着
// | 書式 plugin_getwhatsnew_userbox
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
// @@@@@@再テスト要　日付あたり 件数指定？１５？
function plugin_getwhatsnew_userbox()
{
    global $_CONF;
    global $_TABLES;
    global $_USERBOX_CONF;
    global $LANG_USERBOX;

    $retval = '';

    if ($_USERBOX_CONF['hide_whatsnew'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }


    // Get newest pro
    $sql  = "SELECT ";
    $sql .= "t1.id";
    $sql .= ",t2.username ";
    $sql .= " FROM ";
    $sql .= " {$_TABLES['USERBOX_base']} AS t1";
    $sql .= " ,{$_TABLES['users']} AS t2";

    $sql .= " WHERE ";
    $sql .= " draft_flag=0 ";
    $sql .= " AND t1.id = t2.uid ";

    $sql .= " AND (t1.{$datecolumn} >= ";
    $sql .= " (DATE_SUB(NOW(), INTERVAL {$_USERBOX_CONF['whatsnew_interval']} SECOND)))" ;

    //@@@@@@@@--------->
    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND');
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())".LB;
    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())";
    //@@@@@@@@<---------


    $sql .= " ORDER BY {$datecolumn} DESC LIMIT 15";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $recentnew = array();
        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);
            $name = stripslashes($A['title']);
            $name=COM_truncate( $name, $_USERBOX_CONF['title_trim_length'] ,"…");
            $url = COM_buildUrl($_CONF['site_url']
                    . '/userbox/profile.php?id=' . $A['id']);

            $recentnew[] = COM_createLink($name, $url) . LB;
        }

        $retval .= COM_makeList($recentnew, 'list-new-plugins');
    } else {
        $retval .= $LANG_USERBOX['Norecentnew'] . '<br' . XHTML . '>' . LB;
    }


    return $retval;
}


// +---------------------------------------------------------------------------+
// | 機能  ユーザ削除                                                          |
// | 書式 plugin_user_delete_profile                                           |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
// 20110613
function plugin_user_delete_userbox ($uid)
{
    global $_TABLES;
	
	$pi_name="userbox";
	
    $addition_def=DATABOX_getadditiondef($pi_name);//@@@@@
    $additionfields = DATABOX_getadditiondatas($uid,$pi_name);

	
    DB_delete ($_TABLES['USERBOX_base'], 'id', $uid);
    //カテゴリ
    $rt=DATABOX_savedatas("category_id",$_TABLES['USERBOX_category'],$uid);
	//追加項目
	DATABOX_deleteaddtionfiles($additionfields,$addition_def,$pi_name);
    $rt=DATABOX_saveaddtiondatas($uid,"","",$pi_name);

    //hits
    DB_delete ($_TABLES['USERBOX_stats'], 'id', $uid);

}

// +---------------------------------------------------------------------------+
// | 機能  ユーザ新規登録                                                      |
// | 書式 plugin_user_delete_profile                                           |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
// update20110613
function plugin_user_create_userbox ($uid)
{
	if  (userbox_isuser($uid)===FALSE){
		return;
	}
	
	global $_USERBOX_CONF;//@@@@@20110613
    global $_TABLES;
    global $_USER;
	
	$table=$_TABLES['USERBOX_def_field'];
	$table1=$_TABLES['USERBOX_base'];
    $table2=$_TABLES['USERBOX_addition'];

    $uuid=$_USER['uid'];
    if ($uuid===""){
        $uuid=0;
    }


    $group_id =$_USERBOX_CONF['grp_id_default'];//@@@@@20110613

    $array = array();
    SEC_setDefaultPermissions($array, $_USERBOX_CONF['default_perm']);
    $perm_owner = $array['perm_owner'];
    $perm_group = $array['perm_group'];
    $perm_anon = $array['perm_anon'];
    $perm_members = $array['perm_members'];

    $sql=LB;
    $sql.="INSERT INTO {$_TABLES['USERBOX_base']} (".LB;
    $sql.=" `id`,`owner_id`,`modified`,`created`,`released`".LB;
    $sql.=" ,`uuid`".LB;
    $sql.=" ,`group_id`,`perm_owner`,`perm_group`,`perm_anon`,`perm_members`".LB;
    $sql.=")".LB;

    $sql .= " VALUES (".LB;
    $sql .= "'{$uid}','{$uid}',NOW( ),NOW( ),NOW( )".LB;
    $sql.=" ,".$uuid .LB;
    $sql.=" ,".$group_id.LB ;
    $sql.=" ,".$perm_owner.LB ;
    $sql.=" ,".$perm_group.LB ;
    $sql.=" ,".$perm_anon.LB ;
    $sql.=" ,".$perm_members.LB ;

    $sql .= ")";
    DB_query ($sql);

    //カテゴリ
    //追加項目
    $sql = "SELECT ";
    $sql .= " field_id";
    $sql .= " ,type";
    $sql .= " ,selection";

    $sql .= " FROM ";
    $sql .= $table;
    $sql .= " order by field_id ";

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);

            $field_id=$A['field_id'];
            $type=$A['type'];
            $selection=$A['selection'];

            $sql2="INSERT INTO ".$table2.LB;
            $sql2.=" (`id`,`field_id`,`value`)".LB;
            $sql2.=" VALUES (";
            $sql2.=" ".$uid;
            $sql2.=" ,".$field_id;
            //7 = 'オプションリスト';
            //8 = 'ラジオボタンリスト';
            if (($type==7 OR $type==8) AND ($selection<>"")){
                $sql2.=",'0' ";
            }else{
                $sql2.=",'' ";
            }
            $sql2.=" )";

            DB_query($sql2);
        }

    }

}
// +---------------------------------------------------------------------------+
// | 機能  ヘッダコード編集：
// | jQueryプラグインのjquery_datepickerを使えるようにする
// | jQueryプラグインが有効であること
// +---------------------------------------------------------------------------+
//
function plugin_getheadercode_userbox()
{
    global $_PLUGINS;
	global $_SCRIPTS;
	global $_CONF;
	
	
	//jquery があれば〜
	//$_SCRIPTS->setJavaScriptLibrary('jquery');
	//$datepicker=$_CONF['path_html'].'/jquery/datepicker/datepicker.js'
	//if  (file_exists($datepicker) ){
	
	//GL のバージョンが1.8.0 より新しければ
	//jquery 有効であれば〜
	if (version_compare(VERSION, '1.8.0') >= 0) {
		if (in_array("jquery", $_PLUGINS)){
			$jsfooter=$_SCRIPTS->getFooter();
			$datepicker=mb_strpos($jsfooter,"datepicker");
			if (!$datepicker) {
				$strext= '/jquery/datepicker/datepicker.js';
				$_SCRIPTS->setJavaScriptFile('jquery_datepicker', $strext);
				$css = '/jquery/datepicker/datepicker.css';
				$_SCRIPTS->setCSSFile('jquery_datepicker_css', $css, true);
			}
		}
	}
	return;
}
// +---------------------------------------------------------------------------+
// | 機能  無効←→有効変更された時の処理
// | フィードの有効無効の変更
// | User にないデータを削除　UserBox にないデータを追加
// +---------------------------------------------------------------------------+
//
function plugin_enablestatechange_userbox ($enable)
{
	global $_CONF;
    global $_TABLES;
	global $_USERBOX_CONF;
	
    $is_enabled = $enable ? 1 : 0;

    // toggle links feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = $is_enabled WHERE type = 'userbox'");
	
    if ($enable) {
        /**
        * At this time, $_XMLSMAP_CONF is visible only in
        * PLG_enableStateChange().  So we have to reload them from DB.
        */
        $_USERBOX_CONF = userbox_loadConfig();
        userbox_update();
	}
}

//PLG_groupChanged
// @param    int     $grp_id     Group ID
// @param    string  $mode       type of change: 'new', 'edit', or 'delete'
function plugin_group_changed_userbox (
	$grp_id
	,$mode
)
{
	global $_CONF;
	
	$dummy=userbox_update();
	
	return;
}

function plugin_user_changed_userbox (
	$uid
)
{
	global $_TABLES;

	$userboxuser=userbox_isuser($uid);
	$userboxdata = DB_getItem ($_TABLES['USERBOX_base'], 'COUNT(*)',"id=".$uid);
	
	//userboxuserなのに データがない時　追加
	if  ($userboxuser){
		if  ($userboxdata==0){
			$dummy=plugin_user_create_userbox ($uid);
		}
	//userboxuserではないのにuserbox データがある時　削除
	}else{
		if  ($userboxdata>0){
			$dummy=plugin_user_delete_userbox ($uid);
		}
	}
		
	return;
}

function plugin_configchange_userbox (
	$group
	, $changes = array()
)
{
    global $_USERBOX_CONF;
	
    $need_update = FALSE;

    if ($group == 'userbox') {
        if (is_array($changes) AND (count($changes) > 0)) {
            /**
            * At this time, changes in configuration is not reflected in
            * $_XMLSMAP_CONF yet.  So we have to reload them from DB.
            */
            $_USERBOX_CONF = userbox_loadConfig();

            foreach ($changes as $name) {
                if ($name == 'allow_loggedinusers') {
					$need_update=TRUE;
				}
            }
        }
    }
	
    if ($need_update) {
		$dummy=userbox_update();
	}
}
/**
* Provide URL of a documentation file
*
* @param   string  $file   documentation file being requested, e.g. 'config'
* @return  mixed           URL or false when not available
*/
function plugin_getdocumentationurl_userbox(
	$file
) {
	global $_CONF;

	static $doc_url = NULL;

	if ($doc_url === NULL) {
		switch ($file) {
			case 'index':
			case 'config':
				$lang = COM_getLanguageName();
				$path = 'admin/plugins/userbox/docs/';
				if (!file_exists($_CONF['path_html'] . $path . $lang . '/assist.html')) {
					$lang = 'japanese';//'english';
				}
		
				$doc_url = $_CONF['site_url'] . '/' . $path . $lang . '/userbox.html';
				break;

			default:
				$doc_url = FALSE;
				break;
		}
	}
	
	return $doc_url;
}

/**
* Provides text for a Configuration tooltip
*
* @param    string  $id     Id of config value
* @return   mixed           Text to use regular tooltip, NULL to use config 
*                           tooltip hack, or empty string when not available
*/
function plugin_getconfigtooltip_userbox(
	$id
){
	// Use config tooltip hack where tooltip is read from the config documentation
	return NULL;
}


// userboxuser
function userbox_isuser(
	$uid
)
{
	global $_USERBOX_CONF;
	global $_TABLES;
	
	
	$sql="";
	$sql.="SELECT t1.ug_uid";
	$sql.=" FROM {$_TABLES['group_assignments']} AS t1";
	$sql.=" WHERE t1.ug_uid =".$uid;
	
	if  ($_USERBOX_CONF["allow_loggedinusers"]==0){
		$sql.=" AND ";
		$sql.=" (";
		$sql.="   (t1.ug_main_grp_id=1)";
		$sql.=" OR ";
		$sql.="   (ug_main_grp_id IN (";
		$sql.="   SELECT acc_grp_id";
		$sql.="   FROM {$_TABLES['access']} AS t2, {$_TABLES['features']} AS t3 ";
		$sql.="   WHERE t2.acc_ft_id = t3.ft_id ";
		$sql.="   AND t3.ft_name = 'userbox.user')";
		$sql.="   )";
		$sql.=" )";
	}
    $result = DB_query ($sql);
	$numrows = DB_numRows ($result);
	if  ($numrows==0) {
		$rt=FALSE;
	}else{
		$rt=TRUE;
	}
	RETURN $rt;
}
/**
* Loads config infor with config.class.php
*
* @return   mixed   XMLSitemap config array or FALSE
*/
function userbox_loadConfig()
{
    global $_CONF;

    require_once $_CONF['path_system'] . 'classes/config.class.php';

    $config = config::get_instance();
    if ($config->group_exists('userbox')) {
        return $config->get_config('userbox');
    } else {
        return FALSE;
    }
}

function userbox_update(
)
{

    global $_CONF;
	global $_TABLES;
	
	$tbl1=$_TABLES['USERBOX_base'];
	$tbl2=$_TABLES['users'];
		
	//=====
	// UserBox にあって　user にないデータを削除する
    $display.="Deleted user1"."<br>";
	
	$sql = "SELECT id ";
	$sql .= " FROM {$tbl1} ";
	$sql .= " WHERE id not in (SELECT uid FROM {$tbl2} )";
	
	$result = DB_query ($sql);
    $numrows = DB_numRows ($result);
    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
			$A = DB_fetchArray ($result);
			$id=COM_applyFilter($A['id']);
			$display.="{$id} ";
			$dummy=plugin_user_delete_userbox ($id);
		}
	}
    $display.="<br>";
    $display.="Created user"."<br>";
	
	//=====
	//UserBox user にあるが　UserBox.user でないデータを削除
    $display.="Deleted user2"."<br>";
	
	$sql = "SELECT id ";
	$sql .= " FROM {$tbl1} AS t1";
	$sql .= " ,{$tbl2} AS t2";
	$sql .= " WHERE t1.id =t2.uid";
	
	$result = DB_query ($sql);
    $numrows = DB_numRows ($result);
    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
			$A = DB_fetchArray ($result);
			$id=COM_applyFilter($A['id']);
			if (userbox_isuser($id)){
			}else{
				$display.="{$id} ";
				$dummy=plugin_user_delete_userbox ($id);
			}
		}
	}
    $display.="<br>";
    $display.="Created user"."<br>";
	
	//=====
	// user にあって　UserBox にないデータを追加する
	$sql = "SELECT uid ";
	$sql .= " FROM {$tbl2} ";
	$sql .= " WHERE uid >1";
	$sql .= " AND  uid not in (SELECT id FROM {$tbl1} )";
	
	$result = DB_query ($sql);
    $numrows = DB_numRows ($result);
    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
			$A = DB_fetchArray ($result);
			$uid=COM_applyFilter($A['uid']);
			$display.="{$uid} ";
			$dummy=plugin_user_create_userbox ($uid);
		}
	}

    $display.="<br>";
    $display.=".......... UserBox Data Update finished!"."<br>";
	
	return $display;
}

?>