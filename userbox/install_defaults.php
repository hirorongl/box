<?php

// Reminder: always indent with 4 spaces (no tabs).
// +---------------------------------------------------------------------------+
// | UserBox Plugin  ユーザボックスプラグイン                                  |
// +---------------------------------------------------------------------------+
// | install_defaults.php                                                      |
// |                                                                           |
// | Initial Installation Defaults used when loading the online configuration  |
// | records. These settings are only used during the initial installation     |
// | and not referenced any more once the plugin is installed.                 |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2000-2008 by the following authors:                         |
// |                                                                           |
// | Authors: Tony Bibbs         - tony AT tonybibbs DOT com                   |
// |          Mark Limburg       - mlimburg AT users.sourceforge DOT net       |
// |          Jason Whittenburg  - jwhitten AT securitygeeks DOT com           |
// |          Dirk Haun          - dirk AT haun-online DOT de                  |
// |          Trinity Bays       - trinity93 AT gmail DOT com                  |
// |          Oliver Spiesshofer - oliver AT spiesshofer DOT com               |
// |          Euan McKay         - info AT heatherengineering DOT com          |
// +---------------------------------------------------------------------------+
// |                                                                           |
// | This program is licensed under the terms of the GNU General Public License|
// | as published by the Free Software Foundation; either version 2            |
// | of the License, or (at your option) any later version.                    |
// |                                                                           |
// | This program is distributed in the hope that it will be useful,           |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of            |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.                      |
// | See the GNU General Public License for more details.                      |
// |                                                                           |
// | You should have received a copy of the GNU General Public License         |
// | along with this program; if not, write to the Free Software Foundation,   |
// | Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.           |
// |                                                                           |
// +---------------------------------------------------------------------------+
//
// $Id: install_defaults.php
// 20120403

if (strpos($_SERVER['PHP_SELF'], 'install_defaults.php') !== false) {
    die('This file can not be used on its own!');
}

global $_USERBOX_DEFAULT;
global $_TABLES;
$_USERBOX_DEFAULT = array();


// +---------------------------------------------------------------------------+
// + 初期値
//メイン設定
// 1ページの行数
$_USERBOX_DEFAULT['perpage']=9;
//ログインを要求する
$_USERBOX_DEFAULT['loginrequired'] = 0;

//メニュに表示しない
$_USERBOX_DEFAULT['hidemenu'] = 0;

//カテゴリ　コードを使用する
$_USERBOX_DEFAULT['categorycode']=0;
//データ　コードを使用する
$_USERBOX_DEFAULT['datacode']=0;
//グループ　コードを使用する
$_USERBOX_DEFAULT['groupcode']=0;
//UserBox のTOPで表示するプログラム
$_USERBOX_DEFAULT['top']="/userbox/profile.php";
//テンプレート 一般画面
$_USERBOX_DEFAULT['templates']="standard";
//テンプレート 管理画面
$_USERBOX_DEFAULT['templates_admin']="standard";

//テーマテンプレートパス';//@@@@@
$_USERBOX_DEFAULT['themespath'] ="userbox/templates/";
//所有者の削除と共に削除する
$_USERBOX_DEFAULT['delete_data'] = 0;//@@@@@
//使用する日付（編集日付or作成日付）';//@@@@@
$_USERBOX_DEFAULT['datefield'] = "modified";

// Display Meta Tags for userbox pages (1 = show, 0 = don't)
$_USERBOX_DEFAULT['meta_tags'] = 0;

$_USERBOX_DEFAULT['layout'] = 'standard';
$_USERBOX_DEFAULT['layout_admin'] = 'standard';

//@@@@@@-->
// メールの送信先
$_USERBOX_DEFAULT['mail_to'] = array();

//所有者に修正を通知する　default いいえ
$_USERBOX_DEFAULT['mail_to_owner'] = 0;

//下書データの修正を通知する　default いいえ
$_USERBOX_DEFAULT['mail_to_draft'] = 0;



//（プロフィール）ユーザの新規登録のドラフトのデフォルト　default はい
$_USERBOX_DEFAULT['user_draft_default'] = 1;

$_USERBOX_DEFAULT['dateformat'] = 'Y/m/d';


//データ保存後の画面遷移　一般画面
$_USERBOX_DEFAULT['aftersave'] = 'item';
//データ保存後の画面遷移　管理画面
$_USERBOX_DEFAULT['aftersave_admin'] = 'item';

//グループのデフォルト
$grp_id =DB_getItem($_TABLES['groups'], 'grp_id', "grp_name='UserBox Admin'");
$_USERBOX_DEFAULT['grp_id_default'] = $grp_id;

//（プロフィール）更新を許可する　default はい
$_USERBOX_DEFAULT['allow_profile_update'] = 1;
//（プロフィール）マイグループ更新を許可する　default はい
$_USERBOX_DEFAULT['allow_group_update'] = 1;

//（プロフィール） ログインユーザを登録する　default いいえ
$_USERBOX_DEFAULT['allow_loggedinusers'] =0;//@@@@@@

//デフォルト画像URL
$_USERBOX_DEFAULT['default_img_url'] = "";

// 説明入力をチェックする　default いいえ
$_USERBOX_DEFAULT['descriptionemptycheck'] = 0;

//入力制限文字数
$_USERBOX_DEFAULT['maxlength_description'] = "1677215";
$_USERBOX_DEFAULT['maxlength_meta_description'] = "65535";
$_USERBOX_DEFAULT['maxlength_meta_keywords'] = "65535";


//---（１）新着
// 新着の期間
$_USERBOX_DEFAULT['whatsnew_interval'] = 1209600; // 2 weeks
//新着を表示しない
$_USERBOX_DEFAULT['hide_whatsnew'] = "hide";
//タイトル最大長
$_USERBOX_DEFAULT['title_trim_length'] = 20;

//---(2)検索
//データボックスを検索する
$_USERBOX_DEFAULT['include_search'] = 1;
//検索対象にする追加項目の数
$_USERBOX_DEFAULT['additionsearch'] = 10;


//---(3)パーミッションデフォルト
$_USERBOX_DEFAULT['default_permissions'] = array(3, 2, 2, 2);

//（４）自動タグ
$_USERBOX_DEFAULT['intervalday'] = 90;
$_USERBOX_DEFAULT['limitcnt'] = 10;
$_USERBOX_DEFAULT['newmarkday']=3;
$_USERBOX_DEFAULT['categories']="";
$_USERBOX_DEFAULT['new_img']="<img width='29' height='11' "
    ." src='{$_CONF['site_url']}/userbox/images/icons/icon_new.gif'"
    ." alt='NEW!' />";
$_USERBOX_DEFAULT['rss_img']="<img width='35' height='16' "
    ."src='{$_CONF['site_url']}/userbox/images/icons/icon_RSS.gif' alt='RSS' "
    ."class='icon_rss' >";



//（5）file @@@@@
$_USERBOX_DEFAULT['imgfile_size'] = "1048576";
$_USERBOX_DEFAULT['imgfile_type'] = array('image/jpeg','image/gif');

//@@@@@---->準備中
$_USERBOX_DEFAULT['imgfile_size2'] = "1048576";
$_USERBOX_DEFAULT['imgfile_type2'] = array('image/jpeg','image/gif');

// ★画像保存URL  サイトURL/ の後の指定
$_USERBOX_DEFAULT['imgfile_frd'] = "images/userbox/";
//サムネイル
// ★サムネイル画像保存URL  サイトURL/ の後の指定
$_USERBOX_DEFAULT['imgfile_thumb_frd'] = "images/userbox/";

/*-- サムネイル--*/
//サムネイルを使用する？ Yes=1 No=0(GDライブラリ利用不可の場合は自動判定)
$_USERBOX_DEFAULT['imgfile_thumb_ok'] = "1";
//サムネイルの大きさ(これ以上の大きい画像はjpg,pngのサムネイル作成)
$_USERBOX_DEFAULT['imgfile_thumb_w'] = 160;
$_USERBOX_DEFAULT['imgfile_thumb_h'] = 100;
//リンク先の画像の大きさ(これ以上の大きい画像は縮小する)
$_USERBOX_DEFAULT['imgfile_thumb_w2'] = 640;
$_USERBOX_DEFAULT['imgfile_thumb_h2'] = 640;

/*-- サムネイル作成できない(orしない)場合)--*/
//アイテム内に表示する画像の最大横幅(imgタグ内のwidthの値)
$_USERBOX_DEFAULT['imgfile_smallw'] = 160;



// ★ファイル保存  絶対アドレスの指定
$_USERBOX_DEFAULT['file_path'] = $_CONF['path_data']."userbox_data/";
$_USERBOX_DEFAULT['file_size'] = "";
$_USERBOX_DEFAULT['file_type'] = array();


//(6) autotag permissions
$_USERBOX_DEFAULT['autotag_permissions_userbox'] = array (2, 2, 2, 2);

//（9）Professional Version
$_USERBOX_DEFAULT['path_xml'] = $_CONF['path_html']."userbox_data";
$_USERBOX_DEFAULT['path_xml_out']=$_CONF['path']."data/userbox_data";




// +---------------------------------------------------------------------------+


/**
* Initialize Links plugin configuration
*
* Creates the database entries for the configuation if they don't already
* exist. Initial values will be taken from $_LI_CONF if available (e.g. from
* an old config.php), uses $_LI_DEFAULT otherwise.
*
* @return   boolean     true: success; false: an error occurred
*
*/
function plugin_initconfig_userbox()
{
    global $_USERBOX_CONF;
    global $_USERBOX_DEFAULT;

    if (is_array($_USERBOX_CONF) && (count($_USERBOX_CONF) > 1)) {
        $_USERBOX_DEFAULT = array_merge($_USERBOX_DEFAULT, $_USERBOX_CONF);
    }

    $pi_name="userbox";

    $c = config::get_instance();

    if (!$c->group_exists($pi_name)) {
    /**
     * Adds a configuration variable to the config object
     *
     * @param string $param_name        name of the parameter to add
     * @param mixed  $default_value     the default value of the parameter
     *                                  (also will be the initial value)
     * @param string $display_name      name that will be displayed on the
     *                                  user interface
     * @param string $type              the type of the configuration variable
     *
     *    If the configuration variable is an array, prefix this string with
     *    '@' if the administrator should NOT be able to add or remove keys
     *    '*' if the administrator should be able to add named keys
     *    '%' if the administrator should be able to add numbered keys
     *    These symbols can be repeated like such: @@text if the configuration
     *    variable is an array of arrays of text.
     *    The base variable types are:
     *    'text'    textbox displayed     string  value stored
     *    'select'  selectbox displayed   string  value stored
     *    'hidden'  no display            string  value stored
     *
     * @param string $subgroup          subgroup of the variable
     *                                  (the second row of tabs on the user interface)
     * @param string $fieldset          the fieldset to display the variable under
     * @param array  $selection_array   possible selections for the 'select' type
     *                                  this MUST be passed if you use the 'select'
     *                                  type
     * @param int    $sort              sort rank on the user interface (ascending)
     *
     * @param boolean $set              whether or not this parameter is set
     */
        //function add(
        // $param_name
        //  , $default_value
        //  , $type,$subgroup,$fieldset,$selection_array, $sort, $set
            //  , $group=$pi_name)

        //メイン
        $c->add(
            'sg_main'
            , NULL , 'subgroup'
            , 0, 0
            , NULL, 0, true
            , $pi_name);
		//(0)メイン設定
        $c->add('tab_main', NULL, 'tab', 0, 0, NULL, 0, true, $pi_name, 0);
        $c->add(
            'fs_main'
            , NULL, 'fieldset'
            , 0, 0
            , NULL, 0, true
			, $pi_name
			,0);
        $c->add(
            'perpage'
            ,$_USERBOX_DEFAULT['perpage']
            ,'text', 0, 0, NULL, 10, TRUE
			, $pi_name
			,0);
        $c->add(
            'loginrequired'
            ,$_USERBOX_DEFAULT['loginrequired']
            ,'select', 0, 0, 23, 20, true
			, $pi_name
			,0);
        $c->add(
            'hidemenu'
            ,$_USERBOX_DEFAULT['hidemenu']
            ,'select', 0, 0, 0, 30, true
			, $pi_name
			,0);

        $c->add(
            'categorycode'
            , $_USERBOX_DEFAULT['categorycode']
            , 'select',  0, 0, 1, 40, true
			, $pi_name
			,0);
        $c->add(
            'datacode'
            , $_USERBOX_DEFAULT['datacode']
            , 'select',  0, 0, 1, 50, true
			, $pi_name
			,0);
        $c->add(
            'groupcode'
            , $_USERBOX_DEFAULT['groupcode']
            , 'select',  0, 0, 1, 60, true
			, $pi_name
			,0);

        $c->add(
            'top'
            ,$_USERBOX_DEFAULT['top']
            ,'text', 0, 0, NULL, 70, TRUE
			, $pi_name
			,0);
        $c->add(
            'templates'
            , $_USERBOX_DEFAULT['templates']
            , 'select',  0, 0, 20, 80, true
			, $pi_name
			,0);
        $c->add(
            'templates_admin'
            , $_USERBOX_DEFAULT['templates_admin']
            , 'select',  0, 0, 20, 90, true
			, $pi_name
			,0);
        $c->add(
            'themespath'
            ,$_USERBOX_DEFAULT['themespath']
            ,'text', 0, 0, NULL, 100, TRUE
			, $pi_name
			,0);

        $c->add(
            'delete_data'
            , $_USERBOX_DEFAULT['delete_data']
            , 'select',  0, 0, 1, 110, true
			, $pi_name
			,0);
        $c->add(
            'datefield'
            , $_USERBOX_DEFAULT['datefield']
            , 'select',  0, 0, 21, 120, true
			, $pi_name
			,0);


        $c->add('meta_tags'
            , $_USERBOX_DEFAULT['meta_tags']
            , 'select',  0, 0, 0, 130, true
			, $pi_name
			,0);

        $c->add(
            'layout'
            , $_USERBOX_DEFAULT['layout']
            , 'select',  0, 0, 22, 140, true
			, $pi_name
			,0);

        $c->add(
            'layout_admin'
            , $_USERBOX_DEFAULT['layout_admin']
            , 'select',  0, 0, 22, 150, true
			, $pi_name
			,0);
        $c->add(
            'mail_to'
            ,array()
            ,'%text', 0, 0, 0, 160, TRUE
			, $pi_name
			,0);
        $c->add(
            'mail_to_owner'
            ,$_DATABOX_DEFAULT['mail_to_owner']
            ,'select', 0, 0, 0, 170, true
			, $pi_name
			,0);
		
        $c->add(
            'mail_to_draft'
            ,$_DATABOX_DEFAULT['mail_to_draft']
            ,'select', 0, 0, 0, 180, true
			, $pi_name
			,0);
		
        $c->add(
            'user_draft_default'
            ,$_USERBOX_DEFAULT['user_draft_default']
            ,'select', 0, 0, 0, 190, true
			, $pi_name
			,0);
        //
        $c->add(
            'dateformat'
            ,$_USERBOX_DEFAULT['dateformat']
            ,'text', 0, 0, NULL, 200, TRUE
			, $pi_name
			,0);

        $c->add(
            'aftersave'
            ,$_USERBOX_DEFAULT['aftersave']
            ,'select', 0, 0,25, 210, true
			, $pi_name
			,0);

        $c->add(
            'aftersave_admin'
            ,$_USERBOX_DEFAULT['aftersave_admin']
            ,'select', 0, 0, 9, 220, true
			, $pi_name
			,0);


        $c->add(
            'grp_id_default'
            ,$_USERBOX_DEFAULT['grp_id_default']
            ,'select', 0, 0, 24, 230, true
			, $pi_name
			,0);

        $c->add(
            'allow_profile_update'
            ,$_USERBOX_DEFAULT['allow_profile_update']
            ,'select', 0, 0, 0, 240, true
			, $pi_name
			,0);

        $c->add(
            'allow_group_update'
            ,$_USERBOX_DEFAULT['allow_group_update']
            ,'select', 0, 0, 0, 250, true
			, $pi_name
			,0);
		
		$c->add(
            'allow_loggedinusers'
            ,$_USERBOX_DEFAULT['allow_loggedinusers']
            ,'select', 0, 0, 0, 260, true
			, $pi_name
			,0);
		
		$c->add(
            'default_img_url'
            ,$_USERBOX_DEFAULT['default_img_url']
            ,'text', 0, 0, NULL, 270, TRUE
			, $pi_name
			,0);
		
		$c->add(
            'descriptionemptycheck'
            ,$_USERBOX_DEFAULT['descriptionemptycheck']
            ,'select', 0, 0, 0, 280, true
			, $pi_name
			,0);
		
        $c->add(
            'maxlength_description'
            ,$_USERBOX_DEFAULT['maxlength_description']
            ,'text', 0, 0, NULL, 290, TRUE
			, $pi_name
			,0);
        $c->add(
            'maxlength_meta_description'
            ,$_USERBOX_DEFAULT['maxlength_meta_description']
            ,'text', 0, 0, NULL, 300, TRUE
			, $pi_name
			,0);
        $c->add(
            'maxlength_meta_keywords'
            ,$_USERBOX_DEFAULT['maxlength_meta_keywords']
            ,'text', 0, 0, NULL, 310, TRUE
			, $pi_name
			,0);

		//(1)新着
        $c->add('tab_whatsnew', NULL, 'tab', 0, 1, NULL, 0, true, $pi_name, 1);

        $c->add(
            'fs_whatsnew'
            , NULL, 'fieldset'
            , 0, 1
            , NULL, 0, true
			, $pi_name
			,1);
        $c->add(
            'whatsnew_interval'
            ,$_USERBOX_DEFAULT['whatsnew_interval']
            ,'text', 0, 1, NULL, 10, TRUE
			, $pi_name
			,1);
        $c->add(
            'hide_whatsnew'
            ,$_USERBOX_DEFAULT['hide_whatsnew']
            ,'select', 0, 1, 5, 20, true
			, $pi_name
			,1);
        $c->add(
            'title_trim_length'
            ,$_USERBOX_DEFAULT['title_trim_length']
            ,'text', 0, 1, NULL, 30, TRUE
			, $pi_name
			,1);


		//(2)検索
        $c->add('tab_search', NULL, 'tab', 0, 2, NULL, 0, true, $pi_name, 2);

        $c->add(
            'fs_search'
            , NULL, 'fieldset'
            , 0, 2, NULL, 0, true
			, $pi_name
			,2);
        $c->add(
            'include_search'
            , $_USERBOX_DEFAULT['include_search']
            , 'select',  0, 2, 0, 10, true
			, $pi_name
			,2);
        $c->add(
            'additionsearch'
            , $_USERBOX_DEFAULT['additionsearch']
            ,'text', 0, 2, NULL, 20, TRUE
			, $pi_name
			,2);

		//(3)パーミッション
        $c->add('tab_permissions', NULL, 'tab', 0, 3, NULL, 0, true, $pi_name, 3);

        $c->add(
            'fs_permissions'
            , NULL, 'fieldset'
            , 0, 3
            , NULL, 0, true
			, $pi_name
			,3);
        $c->add(
            'default_permissions'
            , $_USERBOX_DEFAULT['default_permissions']
            ,'@select' , 0, 3 , 12, 130, true
			, $pi_name
			,3);

		//(4)自動タグ
        $c->add('tab_autotag', NULL, 'tab', 0, 4, NULL, 0, true, $pi_name, 4);

        $c->add(
            'fs_autotag'
            , NULL, 'fieldset'
            , 0, 4, NULL, 0, true
			, $pi_name
			,4);

        $c->add(
            'intervalday'
            ,$_USERBOX_DEFAULT['intervalday']
            ,'text', 0, 4, NULL, 10, TRUE
			, $pi_name
			,4);
        $c->add(
            'limitcnt'
            ,$_USERBOX_DEFAULT['limitcnt']
            ,'text', 0, 4, NULL, 20, TRUE
			, $pi_name
			,4);
        $c->add(
            'newmarkday'
            ,$_USERBOX_DEFAULT['newmarkday']
            ,'text', 0, 4, NULL, 30, TRUE
			, $pi_name
			,4);
        $c->add(
            'categories'
            ,$_USERBOX_DEFAULT['categories']
            ,'text', 0, 4, NULL, 40, TRUE
			, $pi_name
			,4);
        $c->add(
            'new_img'
            ,$_USERBOX_DEFAULT['new_img']
            ,'textarea', 0, 4, NULL, 50, TRUE
			, $pi_name
			,4);
        $c->add(
            'rss_img'
            ,$_USERBOX_DEFAULT['rss_img']
            ,'textarea', 0, 4, NULL, 60, TRUE
			, $pi_name
			,4);

		//(5)file
        $c->add('tab_file', NULL, 'tab', 0, 5, NULL, 0, true, $pi_name, 5);

        $c->add(
            'fs_file'
            , NULL, 'fieldset'
            , 0, 5, NULL, 0, true
			, $pi_name
			,5);

        $c->add(
            'imgfile_size'
            ,$_USERBOX_DEFAULT['imgfile_size']
            ,'text', 0, 5, NULL, 10, TRUE
			, $pi_name
			,5);
        $c->add(
            'imgfile_type'
            ,$_USERBOX_DEFAULT['imgfile_type']
            ,'%text', 0, 5, 0, 20, TRUE
			, $pi_name
			,5);
		
		
		
		
		$c->add(
            'imgfile_size2'
            ,$_USERBOX_DEFAULT['imgfile_size2']
            ,'text', 0, 5, NULL, 30, TRUE
			, $pi_name
			,5);
        $c->add(
            'imgfile_type2'
            ,$_USERBOX_DEFAULT['imgfile_type2']
            ,'%text', 0, 5, 0, 40, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'imgfile_frd'
            ,$_USERBOX_DEFAULT['imgfile_frd']
            ,'text', 0, 5, NULL, 50, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'imgfile_thumb_frd'
            ,$_USERBOX_DEFAULT['imgfile_thumb_frd']
            ,'text', 0, 5, NULL, 60, TRUE
			, $pi_name
			,5);
		
		$c->add(
            'imgfile_thumb_ok'
            ,$_USERBOX_DEFAULT['imgfile_thumb_ok']
            ,'select', 0, 5, 0, 70, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'imgfile_thumb_w'
            ,$_USERBOX_DEFAULT['imgfile_thumb_w']
            ,'text', 0, 5, NULL, 80, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'imgfile_thumb_h'
            ,$_USERBOX_DEFAULT['imgfile_thumb_h']
            ,'text', 0, 5, NULL, 90, TRUE
			, $pi_name
			,5);
		
		$c->add(
            'imgfile_thumb_w2'
            ,$_USERBOX_DEFAULT['imgfile_thumb_w2']
            ,'text', 0, 5, NULL,100, TRUE
			, $pi_name
			,5);
		
		$c->add(
            'imgfile_thumb_h2'
            ,$_USERBOX_DEFAULT['imgfile_thumb_h2']
            ,'text', 0, 5, NULL, 110, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'imgfile_smallw'
            ,$_USERBOX_DEFAULT['imgfile_smallw']
            ,'text', 0, 5, NULL, 120, TRUE
			, $pi_name
			,5);



        $c->add(
            'file_path'
            ,$_USERBOX_DEFAULT['file_path']
            ,'text', 0, 5, NULL, 130, TRUE
			, $pi_name
			,5);
		
		
		$c->add(
            'file_size'
            ,$_USERBOX_DEFAULT['file_size']
            ,'text', 0, 5, NULL, 140, TRUE
			, $pi_name
			,5);
		
        $c->add(
            'file_type'
            ,$_USERBOX_DEFAULT['file_type']
            ,'%text', 0, 5, 0, 150, TRUE
			, $pi_name
			,5);

		//(6)autotag_permissions
        $c->add('tab_autotag_permissions', NULL, 'tab', 0, 6, NULL, 0, true, $pi_name, 6);
        $c->add(
            'fs_autotag_permissions'
            , NULL, 'fieldset'
            , 0, 6, NULL, 0, true
			, $pi_name
			,6);

        $c->add(
            'autotag_permissions_userbox'
            ,$_USERBOX_DEFAULT['autotag_permissions_userbox']
            ,'@select', 0, 6, 13, 10, TRUE
			, $pi_name
			,6);

       //(9)XML
        $c->add('tab_xml', NULL, 'tab', 0, 9, NULL, 0, true, $pi_name, 9);
        $c->add(
            'fs_xml'
            , NULL, 'fieldset'
            , 0, 9, NULL, 0, true
			, $pi_name
			,9);

        $c->add(
            'path_xml'
            ,$_USERBOX_DEFAULT['path_xml']
            ,'text', 0, 9, NULL, 10, TRUE
			, $pi_name
			,9);
	   $c->add(
            'path_xml_out'
            ,$_USERBOX_DEFAULT['path_xml_out']
            ,'text', 0, 9, NULL, 20, TRUE
 			, $pi_name
			,9);


    }

    return true;
}

?>
