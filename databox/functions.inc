<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | DataBox プラグイン                                                        |
// +---------------------------------------------------------------------------+
// $Id: plugins/databox/functions.inc
//20110622 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/

if (strpos ($_SERVER['PHP_SELF'], 'functions.inc') !== false) {
    die ('This file can not be used on its own.');
}

$pi_name         = 'databox';


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
$_USERBOX_CONF['auto_data_create']="1";//自動データ作成

//BOXシリーズ共通関数
if (function_exists("DATABOX_nl2br")==false) {
    require_once ($_CONF['path'] . "plugins/{$pi_name}/lib/databox_functions.inc");
}

$_DATABOX_VERBOSE = false;
//$_DATABOX_VERBOSE = true;//FOR TEST

//自動タグ関連の関数
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_autotag.inc");

//検索機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_search.inc");

//フィード機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_feed.inc");

//STATS機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_stats.inc");

//コメント機能
require_once ($_CONF['path'] . "plugins/{$pi_name}/functions_comment.inc");

// +---------------------------------------------------------------------------+
// | Geeklog Plugin API Implementation                                         |
// +---------------------------------------------------------------------------+

function plugin_chkVersion_databox ()
// +---------------------------------------------------------------------------+
// | 現在インストールされているバージョン取得                                  |
// +---------------------------------------------------------------------------+
{
    global $_DATABOX_CONF;

    return $_DATABOX_CONF['version'];
}


function plugin_upgrade_databox ()
// +---------------------------------------------------------------------------+
// | 機能  プラグイン更新:バージョンナンバーの更新                             |
// +---------------------------------------------------------------------------+
{
    global $_TABLES, $_DATABOX_CONF;

    // the plugin needs these functions so complain when they doesn't exist
    if (!function_exists ('COM_truncate') ||
        !function_exists ('MBYTE_strpos')) {
        return 3002;
    }

    // no db changes - just update the version numbers
    DB_query ("UPDATE {$_TABLES['plugins']} SET pi_version = '{$_DATABOX_CONF['version']}', pi_gl_version = '" . VERSION . "' WHERE pi_name = 'databox'");

    return true;
}

function plugin_autouninstall_databox ()
// +---------------------------------------------------------------------------+
// | 機能  プラグインアンインストール                                          |
// +---------------------------------------------------------------------------+
{
    // (1) 削除するテーブル
    $out['tables'][]='DATABOX_addition';
    $out['tables'][]='DATABOX_base';
    $out['tables'][]='DATABOX_category';
    $out['tables'][]='DATABOX_def_category';
    $out['tables'][]='DATABOX_def_field';
    $out['tables'][]='DATABOX_def_group';
    $out['tables'][]='DATABOX_def_xml';
	$out['tables'][]='DATABOX_stats';
    $out['tables'][]='DATABOX_mst';
	//
    $out['tables'][]='DATABOX_def_category_name';
    $out['tables'][]='DATABOX_def_field_name';
	$out['tables'][]='DATABOX_def_group_name';
	

    // (2) 削除するグループ名
    $out['groups'][]='DataBox Admin';
	$out['groups'][]='DataBox Submitters';
	$out['groups'][]='DataBox Editor';
	
    // (3) 削除するfeatures
    $out['features'][]='databox.admin';
    $out['features'][]='databox.submit';
    $out['features'][]='databox.edit';
    // (4) 削除するphp_blocks
    $out['php_blocks']=array();
    // (5) 削除する vars */
    $out['vars']=array();

    return $out;

}

/**
* ☆★現在のユーザは権利があるのをチェック
* 使用せず
*/
function plugin_ismoderator_databox()
{
    //return SEC_hasRights ('databox.moderate');
    //return SEC_hasRights ('user.moderate');
    return true;
}

function plugin_geticon_databox ()
// +---------------------------------------------------------------------------+
// | 機能  プラグインのアイコン取得                                            |
// +---------------------------------------------------------------------------+
{
    global $_CONF;

    return $_CONF['site_url'] . '/databox/images/icons/databox.png';
}

function plugin_cclabel_databox()
// +---------------------------------------------------------------------------+
// | 機能  投稿管理admin/moderation.php　メニュ
// +---------------------------------------------------------------------------+
{
    global $_CONF;

	if (SEC_hasRights('databox.admin')) {
        return array(
        'databox'
        ,$_CONF['site_admin_url'] . "/plugins/databox/index.php"
        ,plugin_geticon_databox() );
    }
    return "";

}

function plugin_getadminoption_databox()
// +---------------------------------------------------------------------------+
// | 機能 管理者メニュ表示 (管理者ブロック)
// +---------------------------------------------------------------------------+
{
    global $_CONF, $_TABLES;
    global $LANG_DATABOX_ADMIN;

    if (SEC_hasRights ('databox.admin') ){
        //下書他も含む全件数
        $cnt = DB_getItem ($_TABLES['DATABOX_base'], 'COUNT(*)');
        return array ($LANG_DATABOX_ADMIN['piname'],
                      $_CONF['site_admin_url'] . '/plugins/databox/index.php'
                      ,$cnt);
    }
    return "";

}

function plugin_getmenuitems_databox()
// +---------------------------------------------------------------------------+
// | 機能  ヘッダメニュリンクを返す                                            |
// +---------------------------------------------------------------------------+
{
    global $_CONF;
    global $_USER;
    global $_DATABOX_CONF;
    global $LANG_DATABOX;

    $anon = (empty ($_USER['uid']) || ($_USER['uid'] <= 1)) ? true : false;
    if (($_DATABOX_CONF['hidemenu'] == 1) || ($anon &&
                ($_CONF['loginrequired'] || $_DATABOX_CONF['loginrequired']))) {
        return false;
    }
    $menuitems[$LANG_DATABOX['data']] = $_CONF['site_url'] . '/databox/index.php';
    if ($_DATABOX_CONF['allow_data_update']==1 ){
        $menuitems[$LANG_DATABOX['mydata']] = $_CONF['site_url'] . '/databox/mydata/index.php';
    }

    return $menuitems;
}

function plugin_getuseroption_databox()
// +---------------------------------------------------------------------------+
// | 機能  ユーザメニュリンクを返す（ユーザブロック）
// +---------------------------------------------------------------------------+
{
    global $_CONF;
    global $LANG_DATABOX;
    global $_DATABOX_CONF;

    $url = $_CONF['site_url'] . '/databox/mydata/index.php';
    if ($_DATABOX_CONF['allow_data_update']==1 ){
        return array ($LANG_DATABOX['mydata'], $url, '');
	}else{
		if (SEC_hasRights ('databox.edit') ){
			return array ($LANG_DATABOX['mydata'], $url, '');
		}else{
			return;
		}
    }
}

function plugin_whatsnewsupported_databox()
// +---------------------------------------------------------------------------+
// | 機能  新着
// +---------------------------------------------------------------------------+
{
    global $_TABLES;
    global $_DATABOX_CONF;
    global $LANG_DATABOX;
    global $LANG_WHATSNEW;


    if ( $_DATABOX_CONF['hide_whatsnew'] == 'hide' ) {
        $retval = false;
    } else {
        $retval = array( $LANG_DATABOX['pidata'],
                         COM_formatTimeString( $LANG_WHATSNEW['new_last'],
                                               $_DATABOX_CONF['whatsnew_interval'] )
                       );
    }
    return $retval;
}

function plugin_getwhatsnew_databox()
// +---------------------------------------------------------------------------+
// | 機能  新着                                                                |
// +---------------------------------------------------------------------------+
// 再テスト要　日付あたり
{
    global $_CONF;
    global $_TABLES;
    global $_DATABOX_CONF;
    global $LANG_DATABOX;

    $retval = '';

    if ($_DATABOX_CONF['hide_whatsnew'] == 'modified') {
        $datecolumn = 'modified';
    } else {
        $datecolumn = 'created';
    }


    // Get newest pro
    $sql  = "SELECT t1.id,t1.title ";
    $sql .= " FROM ";
    $sql .= " {$_TABLES['DATABOX_base']} AS t1";

    $sql .= " WHERE ";
    $sql .= " draft_flag=0 ";
    $sql .= " AND (t1.{$datecolumn} >= ";
    $sql .= " (DATE_SUB(NOW(), INTERVAL {$_DATABOX_CONF['whatsnew_interval']} SECOND)))" ;

    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND');
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())".LB;
    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())";


    $sql .= " ORDER BY {$datecolumn} DESC LIMIT 15";
    $result = DB_query($sql);
    $nrows = DB_numRows($result);

    if ($nrows > 0) {
        $recentnew = array();
        for ($x = 0; $x < $nrows; $x++) {
            $A = DB_fetchArray($result);
            $name = stripslashes($A['title']);
            $name=COM_truncate( $name, $_DATABOX_CONF['title_trim_length'] ,"…");
            $url = COM_buildUrl($_CONF['site_url']
                    . '/databox/data.php?id=' . $A['id']);

            $recentnew[] = COM_createLink($name, $url) . LB;
        }

        $retval .= COM_makeList($recentnew, 'list-new-plugins');
    } else {
        $retval .= $LANG_DATABOX['Norecentnew'] . '<br' . XHTML . '>' . LB;
    }


    return $retval;
}

function plugin_user_delete_databox ($uid)
// +---------------------------------------------------------------------------+
// | 機能  所有者（ユーザ）が削除された時の処理
// +---------------------------------------------------------------------------+
{
    global $_TABLES;
    global $_DATABOX_CONF;

    if (DB_count ($_TABLES['DATABOX_base'], 'owner_id', $uid) == 0) {
        return;
    }
	
	//所有者の削除と共に削除する
    if ($_DATABOX_CONF['delete_data'] == 1) {
        $sql="SELECT id FROM ".$_TABLES['DATABOX_base']." WHERE owner_id=".$uid;

        $result = DB_query( $sql );
        $nrows = DB_numRows( $result );
        for( $i = 0; $i < $nrows; $i++ )    {
            $A = DB_fetchArray( $result, true );
            $id=$A['id'];
            DB_delete ($_TABLES['DATABOX_base'], 'id', $id);
            //カテゴリ
            $rt=DATABOX_savedatas("category_id",$_TABLES['DATABOX_category'],$id);
            //追加項目
            $rt=DATABOX_saveaddtiondatas($id);
        }

	//所有者の削除でRootユーザ所有に変更する
    } else {
        $rootgroup = DB_getItem ($_TABLES['groups'], 'grp_id',
                                 "grp_name = 'Root'");
        $sql = "SELECT DISTINCT ug_uid FROM {$_TABLES['group_assignments']} ";
        $sql .= " WHERE ug_main_grp_id = $rootgroup ORDER BY ug_uid LIMIT 1";
        $result = DB_query ($sql);
        $A = DB_fetchArray ($result);
        $rootuser = $A['ug_uid'];

        $sql="UPDATE {$_TABLES['DATABOX_base']} SET owner_id = $rootuser WHERE owner_id = $uid";
        DB_query ($sql);
    }
}

function plugin_getheadercode_databox()
// +---------------------------------------------------------------------------+
// | 機能  ヘッダコード編集：
// | jQueryプラグインのjquery_datepickerを使えるようにする
// | jQueryプラグインが有効であること
// +---------------------------------------------------------------------------+
//
{
    global $_PLUGINS;
	global $_SCRIPTS;
	global $_CONF;

	//GL のバージョンが1.8.0 より新しければ
	//jquery 有効であれば〜datepicker セット
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


function plugin_enablestatechange_databox ($enable)
// +---------------------------------------------------------------------------+
// | 機能  無効←→有効変更された時の処理
// | フィードの有効無効の変更
// +---------------------------------------------------------------------------+
{
    global $_TABLES;

    $is_enabled = $enable ? 1 : 0;

    // toggle links feeds
    DB_query ("UPDATE {$_TABLES['syndication']} SET is_enabled = $is_enabled WHERE type = 'databox'");
	
}

/**
* Provide URL of a documentation file
*
* @param   string  $file   documentation file being requested, e.g. 'config'
* @return  mixed           URL or false when not available
*/
function plugin_getdocumentationurl_databox(
	$file
) {
	global $_CONF;

	static $doc_url = NULL;

	if ($doc_url === NULL) {
		switch ($file) {
			case 'index':
			case 'config':
				$lang = COM_getLanguageName();
				$path = 'admin/plugins/databox/docs/';
				if (!file_exists($_CONF['path_html'] . $path . $lang . '/databox.html')) {
					$lang = 'japanese';//'english';
				}
		
				$doc_url = $_CONF['site_url'] . '/' . $path . $lang . '/databox.html';
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
function plugin_getconfigtooltip_databox(
	$id
){
	// Use config tooltip hack where tooltip is read from the config documentation
	return NULL;
}


// 20110928
//function plugin_user_delete_userbox ($uid)
// 使ってる？
function databox_deletedata ($id)
{
    global $_TABLES;
	
	$pi_name="databox";
	
    $addition_def=DATABOX_getadditiondef($pi_name);//@@@@@
    $additionfields = DATABOX_getadditiondatas($id,$pi_name);
	
	//--
    DB_delete ($_TABLES['DATABOX_base'], 'id', $id);

    //カテゴリ
    $rt=DATABOX_savedatas("category_id",$_TABLES['DATABOX_category'],$id);
	//追加項目
	DATABOX_deleteaddtionfiles($additionfields,$addition_def,$pi_name);
	$rt=DATABOX_saveaddtiondatas($id,"","",$pi_name); 
	//hits
    DB_delete ($_TABLES['DATABOX_stats'], 'id', $id);

}

?>