<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | data maintenannce
// +---------------------------------------------------------------------------+
// $Id: data.php
// public_html/admin/plugins/databox/data.php
// 2010818 tsuchitani AT ivywe DOT co DOT jp
// 20101207

// @@@@@追加予定：import
// @@@@@追加予定：export に category
// @@@@@追加予定：日付入力


define ('THIS_SCRIPT', 'databox/data.php');
//define ('THIS_SCRIPT', 'databox/test.php');

include_once('databox_functions.php');
require_once($_CONF['path'] . 'plugins/databox/lib/lib_datetimeedit.php');

// +---------------------------------------------------------------------------+
// | 機能  一覧表示                                                            |
// | 書式 fncList()                                                            |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:一覧                                                           |
// +---------------------------------------------------------------------------+
// 20101021 orderno
function fncList()
{
    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $LANG09;
    global $LANG_DATABOX_ADMIN;
    global $LANG_DATABOX;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

    $retval = '';

    //MENU1:管理画面
    $url1=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?mode=new';
    $url2=$_CONF['site_url'] . '/databox/index.php';
    $url3=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?mode=drafton';
    $url4=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?mode=draftoff';
    $url5=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?mode=export';
    $url6=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?mode=import';
    $menu_arr = array (
        array('url' => $url1,
              'text' => $LANG_DATABOX_ADMIN["new"]),
        array('url' => $url2,
              'text' => $LANG_DATABOX['list']),

        array('url' => $url3,
              'text' => $LANG_DATABOX_ADMIN['drafton']),
        array('url' => $url4,
              'text' => $LANG_DATABOX_ADMIN['draftoff']),

        array('url' => $url5,
              'text' => $LANG_DATABOX_ADMIN['export']),

//        array('url' => $url6,
//              'text' => $LANG_DATABOX_ADMIN['import']),

        array('url' => $_CONF['site_admin_url'],
              'text' => $LANG_ADMIN['admin_home']));

    $retval .= COM_startBlock($LANG_DATABOX_ADMIN['admin_list'], '',
                              COM_getBlockTemplate('_admin_block', 'header'));
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG_DATABOX_ADMIN['instructions'],
        plugin_geticon_databox()
    );


    //ヘッダ：編集～
    $header_arr = array(
        array('text' => $LANG_DATABOX_ADMIN['orderno'], 'field' => 'orderno', 'sort' => true),
        array('text' => $LANG_ADMIN['edit'], 'field' => 'editid', 'sort' => false),
        array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false),
        array('text' => $LANG_DATABOX_ADMIN['id'], 'field' => 'id', 'sort' => true),
        array('text' => $LANG_DATABOX_ADMIN['code'], 'field' => 'code', 'sort' => true),
        array('text' => $LANG_DATABOX_ADMIN['title'], 'field' => 'title', 'sort' => true),
        //array('text' => $LANG_DATABOX_ADMIN['modified'], 'field' => 'modified', 'sort' => true),
        array('text' => $LANG_DATABOX_ADMIN['udatetime'], 'field' => 'udatetime', 'sort' => true),
        array('text' => $LANG_DATABOX_ADMIN['draft'], 'field' => 'draft_flag', 'sort' => true)
    );
    //
    $text_arr = array('has_menu' =>  true,
      'has_extras'   => true,
      'form_url' => $_CONF['site_admin_url'] . "/plugins/".THIS_SCRIPT);

    //Query
    $sql = "SELECT ";
    $sql .= " id";
    $sql .= " ,title";
    $sql .= " ,code";
    $sql .= " ,draft_flag";
    $sql .= " ,modified";
    $sql .= " ,udatetime";
    $sql .= " ,orderno";


    $sql .= " FROM ";
    $sql .= " {$_TABLES['DATABOX_base']} AS t";
    $sql .= " WHERE ";
    $sql .= " 1=1";

    $query_arr = array(
        'table' => 'DATABOX_base',
        'sql' => $sql,
        'query_fields' => array('id','title','code','draft_flag','orderno'),
        'default_filter' => $exclude);
    //デフォルトソート項目:
    $defsort_arr = array('field' => 'orderno', 'direction' => 'ASC');
    //List 取得
    //ADMIN_list(
    //       $component, $fieldfunction, $header_arr, $text_arr,
    //       $query_arr, $menu_arr, $defsort_arr, $filter = '', $extra = '', $options = '')
    $retval .= ADMIN_list(
        'databox'
        , "fncGetListField"
        , $header_arr
        , $text_arr
        , $query_arr
        , $defsort_arr
        );

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

// +---------------------------------------------------------------------------+
// | 一覧取得 ADMIN_list で使用
// +---------------------------------------------------------------------------+
function fncGetListField($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF;
    global $LANG_ACCESS;
    global $_DATABOX_CONF;

    $retval = '';

    switch($fieldname) {
        //編集アイコン
        case 'editid':
            $url=$_CONF['site_admin_url'] . "/plugins/".THIS_SCRIPT;
            $url.="?";
            $url.="mode=edit";
            $url.="&amp;id=".$A['id'];
            $retval = COM_createLink($icon_arr['edit'],$url);
            break;
        case 'copy':
            $url=$_CONF['site_admin_url'] . "/plugins/".THIS_SCRIPT;
            $url.="?";
            $url.="mode=copy";
            $url.="&amp;id=".$A['id'];
            $retval = COM_createLink($icon_arr['copy'],$url);
            break;

        //名
        case 'title':
            $name=COM_applyFilter($A['title']);
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
        //下書
        case 'draft_flag':
            if ($A['draft_flag'] == 1) {
                $switch = 'checked="checked"';
            } else {
                $switch = '';
            }
            $retval = "<form action=\"{$_CONF['site_admin_url']}";
            $retval .= "/plugins/".THIS_SCRIPT."\" method=\"post\">";
            $retval .= "<input type=\"checkbox\" name=\"drafton\" ";
            $retval .= "onclick=\"submit()\" value=\"{$A['draft_flag']}\" $switch>";
            $retval .= "<input type=\"hidden\" name=\"draftChange\" ";
            $retval .= "value=\"{$A['id']}\">";

            $retval .= "<input type=\"hidden\" name=\"".CSRF_TOKEN."\"";
            $retval .= " value=\"".SEC_createToken()."\"".XHTML.">";

            $retval .= "</form>";
            break;
        //各項目
        default:
            $retval = $fieldvalue;
            break;
    }

    return $retval;

}
// +---------------------------------------------------------------------------+
// | 機能  編集画面表示                                                        |
// | 書式 fncEdit($id , $edt_flg,$msg,$errmsg)                                 |
// +---------------------------------------------------------------------------+
// | 引数 $id:                                                                 |
// | 引数 $edt_flg:                                                            |
// | 引数 $msg:メッセージ番号                                                  |
// | 引数 $errmsg
// | 引数 $mode:
// +---------------------------------------------------------------------------+
// | 戻値 nomal:編集画面                                                       |
// +---------------------------------------------------------------------------+
// update 20100927-1020 defaulttemplatesdirectory add
// update 20110826- eyechatchingimage add

function fncEdit(
    $id
    ,$edt_flg
    ,$msg = ''
    ,$errmsg=""
    ,$mode="edit"
)
{

    $pi_name="databox";

    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $MESSAGE;
    global $LANG_ACCESS;
    global $_USER;

    global $_DATABOX_CONF;
    global $LANG_DATABOX_ADMIN;
    global $LANG_DATABOX;

    $retval = '';

    $delflg=false;

    $addition_def=DATABOX_getadditiondef();

    //メッセージ表示
    if (!empty ($msg)) {
        $retval .= COM_showMessage ($msg,'databox');
        $retval .= $errmsg;

        // clean 'em up
        $code=COM_applyFilter($_POST['code']);
        $title = COM_applyFilter($_POST['title']);
        $page_title = COM_applyFilter($_POST['page_title']);
        $description=$_POST['description'];//COM_applyFilter($_POST['description']);
		$defaulttemplatesdirectory = COM_applyFilter($_POST['defaulttemplatesdirectory']);
        $eyechatchingimage = COM_applyFilter($_POST['eyechatchingimage']);//@@@@@@
        $eyechatchingimage_del=COM_applyFilter($_POST['eyechatchingimage_del']);

        $draft_flag = COM_applyFilter ($_POST['draft_flag'],true);
        $hits = COM_applyFilter ($_POST['hits'],true);
        $comments = COM_applyFilter ($_POST['comments'],true);
        $commentcode = COM_applyFilter ($_POST['commentcode'],true);

        //@@@@@
        $comment_expire_flag = COM_applyFilter ($_POST['comment_expire_flag'],true);
        if ($comment_expire_flag===0){
               $w = mktime(0, 0, 0, date('m'),
               date('d') + $_CONF['article_comment_close_days'], date('Y'));
               $comment_expire_year=date('Y', $w);
            $comment_expire_month=date('m', $w);
            $comment_expire_day=date('d', $w);
            $comment_expire_hour=0;
            $comment_expire_minute=0;
        }else{
            $comment_expire_month = COM_applyFilter ($_POST['comment_expire_month'],true);
            $comment_expire_day = COM_applyFilter ($_POST['comment_expire_day'],true);
            $comment_expire_year = COM_applyFilter ($_POST['comment_expire_year'],true);
            $comment_expire_hour = COM_applyFilter ($_POST['comment_expire_hour'],true);
            $comment_expire_minute = COM_applyFilter ($_POST['comment_expire_minute'],true);
        }

        $meta_description = COM_applyFilter ($_POST['meta_description']);
        $meta_keywords = COM_applyFilter ($_POST['meta_keywords']);

        $category = $_POST['category'];

        $additionfields=$_POST['afield'];
        $additionfields_fnm=$_POST['afield_fnm'];//@@@@@
        $additionfields_del=$_POST['afield_del'];
        $additionfields=DATABOX_cleanaddtiondatas
            ($additionfields,$addition_def,$additionfields_fnm,$additionfields_del);

        $owner_id = COM_applyFilter ($_POST['owner_id'],true);
        $group_id = COM_applyFilter ($_POST['group_id'],true);
        //
        $array['perm_owner']=$_POST['perm_owner'];
        $array['perm_group']=$_POST['perm_group'];
        $array['perm_members']=$_POST['perm_members'];
        $array['perm_anon']=$_POST['perm_anon'];

        if (is_array($array['perm_owner']) || is_array($array['perm_group']) ||
                is_array($array['perm_members']) ||
                is_array($array['perm_anon'])) {

            list($perm_owner, $perm_group, $perm_members, $perm_anon)
                = SEC_getPermissionValues($array['perm_owner'], $array['perm_group'], $array['perm_members'], $array['perm_anon']);

        } else {
            $perm_owner   = $array['perm_owner'];
            $perm_group   = $array['perm_group'];
            $perm_members = $array['perm_members'];
            $perm_anon    = $array['perm_anon'];
        }


        //編集日
        $modified_autoupdate = COM_applyFilter ($_POST['modified_autoupdate'],true);
        $modified_month = COM_applyFilter ($_POST['modified_month'],true);
        $modified_day = COM_applyFilter ($_POST['modified_day'],true);
        $modified_year = COM_applyFilter ($_POST['modified_year'],true);
        $modified_hour = COM_applyFilter ($_POST['modified_hour'],true);
        $modified_minute = COM_applyFilter ($_POST['modified_minute'],true);
        //公開日
        $released_month = COM_applyFilter ($_POST['released_month'],true);
        $released_day = COM_applyFilter ($_POST['released_day'],true);
        $released_year = COM_applyFilter ($_POST['released_year'],true);
        $released_hour = COM_applyFilter ($_POST['released_hour'],true);
        $released_minute = COM_applyFilter ($_POST['released_minute'],true);
        //公開終了日
        $expired_available = COM_applyFilter ($_POST['expired_available'],true);
        $expired_flag = COM_applyFilter ($_POST['expired_flag'],true);

        if ($expired_flag===0){
            $w = mktime(0, 0, 0, date('m'),
                date('d') + $_CONF['article_comment_close_days'], date('Y'));
            $expired_year=date('Y', $w);
            $expired_month=date('m', $w);
            $expired_day=date('d', $w);
            $expired_hour=0;
            $expired_minute=0;
        }else{
            $expired_month = COM_applyFilter ($_POST['expired_month'],true);
            $expired_day = COM_applyFilter ($_POST['expired_day'],true);
            $expired_year = COM_applyFilter ($_POST['expired_year'],true);
            $expired_hour = COM_applyFilter ($_POST['expired_hour'],true);
            $expired_minute = COM_applyFilter ($_POST['expired_minute'],true);
        }
        //作成日付
        $created_month=COM_applyFilter ($_POST['created_month'],true);
        $created_day = COM_applyFilter ($_POST['created_day'],true);
        $created_year =COM_applyFilter ($_POST['created_year'],true);
        $created_hour = COM_applyFilter ($_POST['created_hour'],true);
        $created_minute = COM_applyFilter ($_POST['created_minute'],true);
        $created = COM_applyFilter ($_POST['created']);

        $orderno = COM_applyFilter ($_POST['orderno']);

        $uuid=$_USER['uid'];
        $udatetime=COM_applyFilter ($_POST['udatetime']);//"";


    }else{
        if (empty($id)) {

            $id=0;

            $code ="";
            $title ="";
            $description="";
            $defaulttemplatesdirectory=null;
			$eyechatchingimage=null;
			$eyechatchingimage_del=null;
			
            $hits =0;
            $comments=0;

            $comment_expire_flag = 0;
            $w = mktime(0, 0, 0, date('m'),
                 date('d') + $_CONF['article_comment_close_days'], date('Y'));
            $comment_expire_year=date('Y', $w);
            $comment_expire_month=date('m', $w);
            $comment_expire_day=date('d', $w);
            $comment_expire_hour=0;
            $comment_expire_minute=0;

            $commentcode =0;

            $meta_description ="";
            $meta_keywords ="";

            $category = "";
            $additionfields=array();
            $additionfields_fnm=array();//@@@@@
            $additionfields_del=array();
            $additionfields = DATABOX_getadditiondatas(0,$pi_name);

            //
            $owner_id =$_USER['uid'];//@@@@@

            //$group_id =SEC_getFeatureGroup('databox.admin', $_USER['uid']);;
            $group_id =$_DATABOX_CONF['grp_id_default'];

            $array = array();
            SEC_setDefaultPermissions($array, $_DATABOX_CONF['default_perm']);
            $perm_owner = $array['perm_owner'];
            $perm_group = $array['perm_group'];
            $perm_anon = $array['perm_anon'];
            $perm_members = $array['perm_members'];

            //
            $draft_flag=$_DATABOX_CONF['admin_draft_default'];
            //編集日付
            $modified_month = date('m');
            $modified_day = date('d');
            $modified_year = date('Y');
            $modified_hour = date('H');
            $modified_minute = date('i');
            //作成日付
            $created=0;
            $created_month=0;
            $created_day = 0;
            $created_year = 0;
            $created_hour = 0;
            $created_minute = 0;
            //公開日
            $released_month=$modified_month;
            $released_day = $modified_day;
            $released_year = $modified_year;
            $released_hour = $modified_hour;
            $released_minute = $modified_minute;
            //公開終了日
            $expired_flag=0;
            $w = mktime(0, 0, 0, date('m'),
                 date('d') + $_CONF['article_comment_close_days'], date('Y'));
            $expired_year=date('Y', $w);
            $expired_month=date('m', $w);
            $expired_day=date('d', $w);
            $expired_hour=0;
            $expired_minute=0;

            $orderno ="";

            $uuid=0;
            $udatetime="";//"";

        }else{
            $sql = "SELECT ";

            $sql .= " *";
            $sql .= " ,unix_timestamp(modified) AS modified_u ";
            $sql .= " FROM ";
            $sql .= $_TABLES['DATABOX_base'];
            $sql .= " WHERE ";
            $sql .= " id = $id";
            $result = DB_query($sql);

            $A = DB_fetchArray($result);

            $code = COM_stripslashes($A['code']);
            $title=COM_stripslashes($A['title']);
            $page_title=COM_stripslashes($A['page_title']);
            $description=COM_stripslashes($A['description']);
            $defaulttemplatesdirectory=COM_stripslashes($A['defaulttemplatesdirectory']);
			$eyechatchiimage=COM_stripslashes($A['eyechatchimage']);

            $hits = COM_stripslashes($A['hits']);

            $comments = COM_stripslashes($A['comments']);
            $comment_expire = COM_stripslashes($A['comment_expire']);
            if ($comment_expire==="0000-00-00 00:00:00"){
                $comment_expire_flag=0;
                $w = mktime(0, 0, 0, date('m'),
                   date('d') + $_CONF['article_comment_close_days'], date('Y'));
                $comment_expire_year=date('Y', $w);
                $comment_expire_month=date('m', $w);
                $comment_expire_day=date('d', $w);
                $comment_expire_hour=0;
                $comment_expire_minute=0;
            }else{
                $comment_expire_flag=1;
                $w=strtotime($comment_expire);//COM_convertDate2Timestamp($comment_expire.":00");
                $comment_expire_year=date('Y', $w);
                $comment_expire_month=date('m', $w);
                $comment_expire_day=date('d', $w);
                $comment_expire_hour=date('H', $w);
                $comment_expire_minute=date('i', $w);
            }

            $commentcode = COM_stripslashes($A['commentcode']);

            $meta_description = COM_stripslashes($A['meta_description']);
            $meta_keywords = COM_stripslashes($A['meta_keywords']);

            $language_id = COM_stripslashes($A['language_id']);

            $owner_id = COM_stripslashes($A['owner_id']);
            $group_id = COM_stripslashes($A['group_id']);

            $perm_owner = COM_stripslashes($A['perm_owner']);
            $perm_group = COM_stripslashes($A['perm_group']);
            $perm_members = COM_stripslashes($A['perm_members']);
            $perm_anon = COM_stripslashes($A['perm_anon']);

            $category = databox_getdatas("category_id",$_TABLES['DATABOX_category'],"id = $id");

            //@@@@@
            $additionfields = DATABOX_getadditiondatas($id,$pi_name);
            $additionfields_fnm=array();//@@@@@
            $additionfields_del=array();

            $draft_flag=COM_stripslashes($A['draft_flag']);

            //編集日
            $modified = strtotime(COM_stripslashes($A['modified']));
            $modified_month = date('m', $modified);
            $modified_day = date('d', $modified);
            $modified_year = date('Y', $modified);
            $modified_hour = date('H', $modified);
            $modified_minute = date('i', $modified);
            //公開日
            $released = strtotime(COM_stripslashes($A['released']));
            $released_month = date('m', $released);
            $released_day = date('d', $released);
            $released_year = date('Y', $released);
            $released_hour = date('H', $released);
            $released_minute = date('i', $released);
            //公開終了日
            $expired = COM_stripslashes($A['expired']);
            if ($expired==="0000-00-00 00:00:00"){
                $expired_flag=0;
                $w = mktime(0, 0, 0, date('m'),
                   date('d') + $_CONF['article_comment_close_days'], date('Y'));
                $expired_year=date('Y', $w);
                $expired_month=date('m', $w);
                $expired_day=date('d', $w);
                $expired_hour=0;
                $expired_minute=0;
            }else{
                $expired_flag=1;
                $w=strtotime($expired);//COM_convertDate2Timestamp($comment_expire.":00");
                $expired_year=date('Y', $w);
                $expired_month=date('m', $w);
                $expired_day=date('d', $w);
                $expired_hour=date('H', $w);
                $expired_minute=date('i', $w);
            }

            //作成日付
            $created = COM_stripslashes($A['created']);
            $w = strtotime($created);
            $created_month = date('m', $w);
            $created_day = date('d', $w);
            $created_year = date('Y', $w);
            $created_hour = date('H', $w);
            $created_minute = date('i', $w);

            $orderno=COM_stripslashes($A['orderno']);

            $uuid = COM_stripslashes($A['uuid']);

            $udatetime=COM_stripslashes($A['udatetime']);

            if ($edt_flg==FALSE) {
                $delflg=true;
            }
        }
    }
    if ($mode==="copy"){
        $id=0;
        //作成日付
        $created=0;
        $created_month=0;
        $created_day = 0;
        $created_year = 0;
        $created_hour = 0;
        $created_minute = 0;
        //
        $delflg=false;

    }

    //-----
    $retval .= COM_startBlock ($LANG_DATABOX_ADMIN['edit'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    //template フォルダ
    $tmplfld=DATABOX_templatePath('admin','default',$pi_name);
    $templates = new Template($tmplfld);

    $templates->set_file('editor',"data_editor.thtml");

    $templates->set_file (array (
                'editor' => 'data_editor.thtml',
                'row'   => 'row.thtml',
                'col'   => "data_col_detail.thtml",
            ));

    //--
    if (($_CONF['meta_tags'] > 0) && ($_DATABOX_CONF['meta_tags'] > 0)) {
        $templates->set_var('hide_meta', '');
    } else {
        $templates->set_var('hide_meta', ' style="display:none;"');
    }

    $templates->set_var('about_thispage', $LANG_DATABOX_ADMIN['about_admin_data']);
    $templates->set_var('lang_must', $LANG_DATABOX_ADMIN['must']);

    $templates->set_var('site_url', $_CONF['site_url']);
    $templates->set_var('site_admin_url', $_CONF['site_admin_url']);
	
	$templates->set_var('lang_ref', $LANG_DATABOX_ADMIN['ref']);
	$templates->set_var('lang_view', $LANG_DATABOX_ADMIN['view']);

    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);
    $templates->set_var('gltoken_name', CSRF_TOKEN);
    $templates->set_var('gltoken', $token);
    $templates->set_var ( 'xhtml', XHTML );

    $templates->set_var('script', THIS_SCRIPT);

    $templates->set_var('dateformat', $_DATABOX_CONF['dateformat']);

    //ビューリンク@@@@@
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
    $view= COM_createLink($LANG_DATABOX['view'], $url);
    $templates->set_var('view', $view);

//
    $templates->set_var('lang_link_admin', $LANG_DATABOX_ADMIN['link_admin']);
    $templates->set_var('lang_link_admin_top', $LANG_DATABOX_ADMIN['link_admin_top']);
    $templates->set_var('lang_link_public', $LANG_DATABOX_ADMIN['link_public']);
    $templates->set_var('lang_link_list', $LANG_DATABOX_ADMIN['link_list']);
    $templates->set_var('lang_link_detail', $LANG_DATABOX_ADMIN['link_detail']);

    //id
    $templates->set_var('lang_id', $LANG_DATABOX_ADMIN['id']);
    //@@@@@ $templates->set_var('help_id', $LANG_DATABOX_ADMIN['help']);
    $templates->set_var('id', $id);

    //下書
    $templates->set_var('lang_draft', $LANG_DATABOX_ADMIN['draft']);
    if  ($draft_flag==1) {
        $templates->set_var('draft_flag', "checked=checked");
    }else{
        $templates->set_var('draft_flag', "");
    }

    //
    $templates->set_var('lang_field', $LANG_DATABOX_ADMIN['field']);
    $templates->set_var('lang_fields', $LANG_DATABOX_ADMIN['fields']);
    $templates->set_var('lang_content', $LANG_DATABOX_ADMIN['content']);
    $templates->set_var('lang_templatesetvar', $LANG_DATABOX_ADMIN['templatesetvar']);

    //基本項目
    $templates->set_var('lang_basicfields', $LANG_DATABOX_ADMIN['basicfields']);
    //コード＆タイトル＆説明＆テンプレートセット値
    $templates->set_var('lang_code', $LANG_DATABOX_ADMIN['code']);
    if ($_DATABOX_CONF['datacode']){
        $templates->set_var('lang_must_code', $LANG_DATABOX_ADMIN['must']);
    }else{
        $templates->set_var('lang_must_code', "");
    }
    $templates->set_var ('code', $code);
    $templates->set_var('lang_title', $LANG_DATABOX_ADMIN['title']);
    $templates->set_var ('title', $title);
    $templates->set_var('lang_page_title', $LANG_DATABOX_ADMIN['page_title']);
    $templates->set_var ('page_title', $page_title);
    $templates->set_var('lang_description', $LANG_DATABOX_ADMIN['description']);
    $templates->set_var ('description', $description);
    $templates->set_var('lang_defaulttemplatesdirectory', $LANG_DATABOX_ADMIN['defaulttemplatesdirectory']);
	$templates->set_var ('defaulttemplatesdirectory', $defaulttemplatesdirectory);
	$select_defaulttemplatesdirectory=fnctemplatesdirectory($pi_name,$defaulttemplatesdirectory);//@@@@@
    $templates->set_var ('select_defaulttemplatesdirectory', $select_defaulttemplatesdirectory);//@@@@@
	
	$templates->set_var('lang_eyechatchingimage', $LANG_DATABOX_ADMIN['eyechatchingimage']);
	$templates->set_var ('eyechatchingimage', $eyechatchingimage);
	$image_eyechatchingimage =DATABOX_imagehtml ("eyechatchingimage",$eyechatchingimage,$eyechatchingimage_del);
    $templates->set_var ('image_eyechatchingimage', $image_eyechatchingimage);//@@@@@

    //meta_description
    $templates->set_var('lang_meta_description', $LANG_DATABOX_ADMIN['meta_description']);
    $templates->set_var ('meta_description', $meta_description);

    //meta_keywords
    $templates->set_var('lang_meta_keywords', $LANG_DATABOX_ADMIN['meta_keywords']);
    $templates->set_var ('meta_keywords', $meta_keywords);

    //hits
    $templates->set_var('lang_hits', $LANG_DATABOX_ADMIN['hits']);
    $templates->set_var ('hits', $hits);

    //comments
    $templates->set_var('lang_comments', $LANG_DATABOX_ADMIN['comments']);
    $templates->set_var ('comments', $comments);

    //commentcode
    $templates->set_var('lang_commentcode', $LANG_DATABOX_ADMIN['commentcode']);
    $templates->set_var ('commentcode', $commentcode);
    $optionlist_commentcode=COM_optionList ($_TABLES['commentcodes'], 'code,name',$commentcode);
    $templates->set_var ('optionlist_commentcode', $optionlist_commentcode);

    //comment_expire
    $templates->set_var('lang_enabled', $LANG_DATABOX_ADMIN['enabled']);

    if ($comment_expire_flag===0){
        $templates->set_var('show_comment_expire', 'false');
        $templates->set_var('is_checked_comment_expire', '');

    }else{
        $templates->set_var('show_comment_expire', 'true');
        $templates->set_var('is_checked_comment_expire', 'checked="checked"');
    }

    $templates->set_var('lang_comment_expire', $LANG_DATABOX_ADMIN['comment_expire']);
    $w=COM_convertDate2Timestamp(
        $comment_expire_year."-".$comment_expire_month."-".$comment_expire_day
        , $comment_expire_hour.":".$comment_expire_minute."::00"
        );
    $datetime_comment_expire=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","comment_expire");
    $templates->set_var('datetime_comment_expire', $datetime_comment_expire);
	$dummy=DATABOX_getenableexpired('comment_expire',$comment_expire_flag,$pi_name);

    //編集日
    $templates->set_var ('lang_modified_autoupdate', $LANG_DATABOX_ADMIN['modified_autoupdate']);
    $templates->set_var ('lang_modified', $LANG_DATABOX_ADMIN['modified']);
    $w=COM_convertDate2Timestamp(
        $modified_year."-".$modified_month."-".$modified_day
        , $modified_hour.":".$modified_minute."::00"
        );
    $datetime_modified=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","modified");
    $templates->set_var ('datetime_modified', $datetime_modified);
    //公開日
    $templates->set_var ('lang_released', $LANG_DATABOX_ADMIN['released']);
    $w=COM_convertDate2Timestamp(
        $released_year."-".$released_month."-".$released_day
        , $released_hour.":".$released_minute."::00"
        );
    $datetime_released=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","released");
    $templates->set_var ('datetime_released', $datetime_released);
    //公開終了日
    $templates->set_var ('lang_expired', $LANG_DATABOX_ADMIN['expired']);
    //if ($expired=="0000-00-00 00:00:00"){
    if ($expired_flag==0){
        $templates->set_var('show_expired', 'false');
        $templates->set_var('is_checked_expired', '');

    }else{
        $templates->set_var('show_expired', 'true');
        $templates->set_var('is_checked_expired', 'checked="expired"');
    }
    $templates->set_var('lang_expired', $LANG_DATABOX_ADMIN['expired']);
    $w=COM_convertDate2Timestamp(
        $expired_year."-".$expired_month."-".$expired_day
        , $expired_hour.":".$expired_minute."::00"
        );
    $datetime_expired=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","expired");
	$templates->set_var('datetime_expired', $datetime_expired);
	$dummy=DATABOX_getenableexpired('expired',$expired_flag,$pi_name);
	
    //順序
    $templates->set_var('lang_orderno', $LANG_DATABOX_ADMIN['orderno']);
    $templates->set_var ('orderno', $orderno);

    //カテゴリ
    $templates->set_var('lang_category', $LANG_DATABOX_ADMIN['category']);
    $checklist_category=DATABOX_getcheckList ("category",$category);
    $templates->set_var('checklist_category', $checklist_category);

    //追加項目
    $templates->set_var('lang_additionfields', $LANG_DATABOX_ADMIN['additionfields']);
    $rt=DATABOX_getaddtionfieldsEdit
        ($additionfields,$addition_def,$templates,9999,$pi_name
            ,$additionfields_fnm,$additionfields_del);
    $rt=DATABOX_getaddtionfieldsJS($additionfields,$addition_def,9999,$pi_name);

    //保存日時
    $templates->set_var ('lang_udatetime', $LANG_DATABOX_ADMIN['udatetime']);
    $templates->set_var ('udatetime', $udatetime);
    $templates->set_var ('lang_uuid', $LANG_DATABOX_ADMIN['uuid']);
    $templates->set_var ('uuid', $uuid);
    //作成日付
    $templates->set_var ('lang_created', $LANG_DATABOX_ADMIN['created']);
    $templates->set_var ('created', $created);

    //アクセス権
    $templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $templates->set_var('lang_owner', $LANG_ACCESS['owner']);

    $owner_name = COM_getDisplayName($owner_id);
    $templates->set_var('owner_name', $owner_name);
    $templates->set_var('owner_id', $owner_id);
    $templates->set_var('lang_group', $LANG_ACCESS['group']);
    $templates->set_var('group_dropdown',SEC_getGroupDropdown ($group_id, 3));
    $templates->set_var('lang_permissions', $LANG_ACCESS['permissions']);
    $templates->set_var('lang_perm_key', $LANG_ACCESS['permissionskey']);
    $templates->set_var('permissions_editor'
                , SEC_getPermissionsHTML(
                         $perm_owner
                        ,$perm_group
                        ,$perm_members
                        ,$perm_anon));

    $templates->set_var('permissions_msg', $LANG_ACCESS['permmsg']);
    $templates->set_var('lang_permissions_msg', $LANG_ACCESS['permmsg']);


    // SAVE、CANCEL ボタン
    $templates->set_var('lang_save', $LANG_ADMIN['save']);
    $templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);
    $templates->set_var('lang_preview', $LANG_ADMIN['preview']);

    //delete_option
    if ($delflg){
        $delbutton = '<input type="submit" value="' . $LANG_ADMIN['delete']
                   . '" name="mode"%s>';
        $jsconfirm = ' onclick="return confirm(\'' . $MESSAGE[76] . '\');"';
        $templates->set_var ('delete_option',
                                  sprintf ($delbutton, $jsconfirm));
    }


    //
    $templates->parse('output', 'editor');
    $retval .= $templates->finish($templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));

    return $retval;
}

function fnctemplatesdirectory (
    $defaulttemplatesdirectory
){

    global $_CONF;
    global $_TABLES;
        //global $_USER ;

    global $_DATABOX_CONF;

    //
    $selection = '<select id="defaulttemplatesdirectory" name="defaulttemplatesdirectory">' . LB;

	if ($_DATABOX_CONF['templates']==="theme"){
        $fd1=$_CONF['path_layout'].$_DATABOX_CONF['themespath']."data/";
    }else if ($_DATABOX_CONF['templates']==="custom"){
        $fd1=$_CONF['path'] .'plugins/databox/custom/templates/data/';
    }else{
        $fd1=$_CONF['path'] .'plugins/databox/templates/data/';
    }

    if( is_dir( $fd1)){
        $fd = opendir( $fd1 );
        $dirs= array();
        $i = 1;
        while(( $dir = @readdir( $fd )) == TRUE )    {
            if( is_dir( $fd1 . $dir)
                    && $dir <> '.'
                    && $dir <> '..'
                    && $dir <> 'CVS'
                    && substr( $dir, 0 , 1 ) <> '.' ) {
                clearstatcache();
                $dirs[$i] = $dir;
                $i++;
            }
        }

        usort($dirs, 'strcasecmp');

        foreach ($dirs as $dir) {
            $selection .= '<option value="' . $dir . '"';
            if ($defaulttemplatesdirectory == $dir) {
                $selection .= ' selected="selected"';
            }
            $words = explode('_', $dir);
            $bwords = array();
            foreach ($words as $th) {
                if ((strtolower($th[0]) == $th[0]) &&
                    (strtolower($th[1]) == $th[1])) {
                    $bwords[] = ucfirst($th);
                } else {
                    $bwords[] = $th;
                }
            }
            $selection .= '>' . implode(' ', $bwords) . '</option>' . LB;
        }
    }else{
        $selection .= '<option value="default"';
        $selection .= ' selected="selected"';
        $selection .= '>Default</option>' . LB;
    }

    $selection .= '</select>';

    return $selection;

}

// kokokara
// +---------------------------------------------------------------------------+
// | 機能  保存                                                                |
// | 書式 fncSave ($edt_flg)                                                   |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:戻り画面＆メッセージ                                           |
// +---------------------------------------------------------------------------+
//20101207
function fncSave (
    $edt_flg
    ,$navbarMenu
    ,$menuno

)
{
    $pi_name="databox";

    global $_CONF;
    global $LANG_DATABOX_ADMIN;
    global $_TABLES;
    global $_USER;
    global $_DATABOX_CONF;

    global $_FILES;


    $addition_def=DATABOX_getadditiondef();

    $retval = '';

    // clean 'em up
    $id = COM_applyFilter($_POST['id'],true);

    $code=COM_applyFilter($_POST['code']);
    $code=addslashes (COM_checkHTML (COM_checkWords ($code)));

    $title = COM_applyFilter($_POST['title']);
    $title = addslashes (COM_checkHTML (COM_checkWords ($title)));

    $page_title = COM_applyFilter($_POST['page_title']);
    $page_title = addslashes (COM_checkHTML (COM_checkWords ($page_title)));

    $description=$_POST['description'];//COM_applyFilter($_POST['description']);
    $description=addslashes (COM_checkHTML (COM_checkWords ($description)));

    $defaulttemplatesdirectory=COM_applyFilter($_POST['defaulttemplatesdirectory']);
    $defaulttemplatesdirectory=addslashes (COM_checkHTML (COM_checkWords ($defaulttemplatesdirectory)));
	
    $eyechatchingimage=COM_applyFilter($_POST['eyechatchingimage']);
    $eyechatchingimage=addslashes (COM_checkHTML (COM_checkWords ($eyechatchingimage)));

    $draft_flag = COM_applyFilter ($_POST['draft_flag'],true);

//            $hits =0;
//            $comments=0;

    $comment_expire_flag = COM_applyFilter ($_POST['comment_expire_flag'],true);
    IF ($comment_expire_flag){
        $comment_expire_month = COM_applyFilter ($_POST['comment_expire_month'],true);
        $comment_expire_day = COM_applyFilter ($_POST['comment_expire_day'],true);
        $comment_expire_year = COM_applyFilter ($_POST['comment_expire_year'],true);
        $comment_expire_hour = COM_applyFilter ($_POST['comment_expire_hour'],true);
        $comment_expire_minute = COM_applyFilter ($_POST['comment_expire_minute'],true);
    }ELSE{
        $comment_expire_month = 0;
        $comment_expire_day = 0;
        $comment_expire_year = 0;
        $comment_expire_hour = 0;
        $comment_expire_minute = 0;
    }

    $commentcode = COM_applyFilter ($_POST['commentcode'],true);

    $meta_description = $_POST['meta_description'];
    $meta_description = addslashes (COM_checkHTML (COM_checkWords ($meta_description)));

    $meta_keywords = $_POST['meta_keywords'];
    $meta_keywords = addslashes (COM_checkHTML (COM_checkWords ($meta_keywords)));

    $category = $_POST['category'];

    //@@@@@
    $additionfields=$_POST['afield'];
    $additionfields_fnm=$_POST['afield_fnm'];
    $additionfields_del=$_POST['afield_del'];
    $dummy=DATABOX_cleanaddtiondatas
        ($additionfields,$addition_def,$additionfields_fnm,$additionfields_del);

    //
    $owner_id = COM_applyFilter ($_POST['owner_id'],true);

    $group_id = COM_applyFilter ($_POST['group_id'],true);

    //
    $array['perm_owner']=$_POST['perm_owner'];
    $array['perm_group']=$_POST['perm_group'];
    $array['perm_members']=$_POST['perm_members'];
    $array['perm_anon']=$_POST['perm_anon'];

    if (is_array($array['perm_owner']) || is_array($array['perm_group']) ||
            is_array($array['perm_members']) ||
            is_array($array['perm_anon'])) {

        list($perm_owner, $perm_group, $perm_members, $perm_anon)
            = SEC_getPermissionValues($array['perm_owner'], $array['perm_group'], $array['perm_members'], $array['perm_anon']);

    } else {
        $perm_owner   = $array['perm_owner'];
        $perm_group   = $array['perm_group'];
        $perm_members = $array['perm_members'];
        $perm_anon    = $array['perm_anon'];
    }



    //編集日付
    $modified_autoupdate = COM_applyFilter ($_POST['modified_autoupdate'],true);
    IF ($modified_autoupdate==1){
        //$udate = date('Ymd');
        $modified_month = date('m');
        $modified_day = date('d');
        $modified_year = date('Y');
        $modified_hour = date('H');
        $modified_minute = date('i');
    }else{
        $modified_month = COM_applyFilter ($_POST['modified_month'],true);
        $modified_day = COM_applyFilter ($_POST['modified_day'],true);
        $modified_year = COM_applyFilter ($_POST['modified_year'],true);
        $modified_hour = COM_applyFilter ($_POST['modified_hour'],true);
        $modified_minute = COM_applyFilter ($_POST['modified_minute'],true);
    }
    //公開日
    $released_month = COM_applyFilter ($_POST['released_month'],true);
    $released_day = COM_applyFilter ($_POST['released_day'],true);
    $released_year = COM_applyFilter ($_POST['released_year'],true);
    $released_hour = COM_applyFilter ($_POST['released_hour'],true);
    $released_minute = COM_applyFilter ($_POST['released_minute'],true);

    //公開終了日
    $expired_flag = COM_applyFilter ($_POST['expired_flag'],true);
    IF ($expired_flag){
        $expired_month = COM_applyFilter ($_POST['expired_month'],true);
        $expired_day = COM_applyFilter ($_POST['expired_day'],true);
        $expired_year = COM_applyFilter ($_POST['expired_year'],true);
        $expired_hour = COM_applyFilter ($_POST['expired_hour'],true);
        $expired_minute = COM_applyFilter ($_POST['expired_minute'],true);
    }ELSE{
        $expired_month = 0;
        $expired_day = 0;
        $expired_year = 0;
        $expired_hour = 0;
        $expired_minute = 0;
    }

    $created = COM_applyFilter ($_POST['created']);
    $orderno = mb_convert_kana($_POST['orderno'],"a");//全角英数字を半角英数字に変換する
    $orderno=COM_applyFilter($orderno,true);

    //$name = mb_convert_kana($name,"AKV");
    //A:半角英数字を全角英数字に変換する
    //K:半角カタカナを全角カタカナに変換する
    //V:濁点つきの文字を１文字に変換する (K、H と共に利用する）
    //$name = str_replace ("'", "’",$name);
    //$code = mb_convert_kana($code,"a");//全角英数字を半角英数字に変換する

    //-----
    $type=1;
    $uuid=$_USER['uid'];


    // CHECK　はじめ
    $err="";
    //id
    if ($id==0 ){
        //$err.=$LANG_DATABOX_ADMIN['err_uid']."<br/>".LB;
    }else{
        if (!is_numeric($id) ){
            $err.=$LANG_DATABOX_ADMIN['err_id']."<br/>".LB;
        }
    }
    //コード
    if ($code<>""){
         $cntsql="SELECT code FROM {$_TABLES['DATABOX_base']} ";
         $cntsql.=" WHERE ";
         $cntsql.=" code='{$code}' ";
         $cntsql.=" AND id<>'{$id}' ";
         $result = DB_query ($cntsql);
         $numrows = DB_numRows ($result);
         if ($numrows<>0 ) {
             $err.=$LANG_DATABOX_ADMIN['err_code_w']."<br/>".LB;
         }
    }

    //タイトル必須
    if (empty($title)){
        $err.=$LANG_DATABOX_ADMIN['err_title']."<br/>".LB;
    }
    //コード必須
    if ($_DATABOX_CONF['datacode']){
        if (empty($code)){
            $err.=$LANG_DATABOX_ADMIN['err_code']."<br/>".LB;
        }
    }

    //----追加項目チェック

    $err.=DATABOX_checkaddtiondatas
        ($additionfields,$addition_def,$pi_name,$additionfields_fnm,$additionfields_del);

    //編集日付
    $modified=$modified_year."-".$modified_month."-".$modified_day;
    if (checkdate($modified_month, $modified_day, $modified_year)==false) {
       $err.=$LANG_DATABOX_ADMIN['err_modified']."<br/>".LB;
    }
    $w=COM_convertDate2Timestamp(
        $modified_year."-".$modified_month."-".$modified_day
        , $modified_hour.":".$modified_minute."::00"
        );
    $modified=date("Y-m-d H:i:s",$w);

    //公開日
    $released=$released_year."-".$released_month."-".$released_day;
    if (checkdate($released_month, $released_day, $released_year)==false) {
       $err.=$LANG_DATABOX_ADMIN['err_released']."<br/>".LB;
    }
    $w=COM_convertDate2Timestamp(
        $released_year."-".$released_month."-".$released_day
        , $released_hour.":".$released_minute."::00"
        );
    $released=date("Y-m-d H:i:s",$w);


    //コメント受付終了日時
    IF ($comment_expire_flag){
        if (checkdate($comment_expire_month, $comment_expire_day, $comment_expire_year)==false) {

           $err.=$LANG_DATABOX_ADMIN['err_comment_expire']."<br/>".LB;
        }
        $w=COM_convertDate2Timestamp(
            $comment_expire_year."-".$comment_expire_month."-".$comment_expire_day
            , $comment_expire_hour.":".$comment_expire_minute."::00"
            );
        $comment_expire=date("Y-m-d H:i:s",$w);

    }else{
        $comment_expire='0000-00-00 00:00:00';
        //$comment_expire="";

    }

    //公開終了日
    IF ($expired_flag){
        if (checkdate($expired_month, $expired_day, $expired_year)==false) {

           $err.=$LANG_DATABOX_ADMIN['err_expired']."<br/>".LB;
        }
        $w=COM_convertDate2Timestamp(
            $expired_year."-".$expired_month."-".$expired_day
            , $expired_hour.":".$expired_minute."::00"
            );
        $expired=date("Y-m-d H:i:s",$w);
        if ($expired<$released) {
           $err.=$LANG_DATABOX_ADMIN['err_expired']."<br/>".LB;
        }


    }else{
        $expired='0000-00-00 00:00:00';
        //$expired="";
    }

    //errorのあるとき
    if ($err<>"") {
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
        $retval .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $retval .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
        $retval .= fncEdit($id, $edt_flg,3,$err);
        $retval .= DATABOX_siteFooter('DATABOX','_admin');

        return $retval;

    }
    // CHECK　おわり

    if ($id==0){
        $w=DB_getItem($_TABLES['DATABOX_base'],"max(id)","1=1");
        if ($w=="") {
            $w=0;
        }
        $id=$w+1;
        $created=date("Y-m-d H:i:s");
    }

    $hits=0;
    $comments=0;

    $fields="id";
    $values="$id";

    $fields.=",code";
    $values.=",'$code'";

    $fields.=",title";//
    $values.=",'$title'";

    $fields.=",page_title";//
    $values.=",'$page_title'";


    $fields.=",description";//
    $values.=",'$description'";

    $fields.=",defaulttemplatesdirectory";//
    $values.=",'$defaulttemplatesdirectory'";

    $fields.=",hits";//
    $values.=",$hits";

    $fields.=",comments";//
    $values.=",$comments";

    $fields.=",meta_description";//
    $values.=",'$meta_description'";

    $fields.=",meta_keywords";//
    $values.=",'$meta_keywords'";

    $fields.=",commentcode";//
    $values.=",$commentcode";

    $fields.=",comment_expire";//
    $values.=",'$comment_expire'";

    $fields.=",language_id";//
    $values.=",'$language_id'";

    $fields.=",owner_id";
    $values.=",$owner_id";

    $fields.=",group_id";
    $values.=",$group_id";

    $fields.=",perm_owner";
    $values.=",$perm_owner";

    $fields.=",perm_group";
    $values.=",$perm_group";

    $fields.=",perm_members";
    $values.=",$perm_members";

    $fields.=",perm_anon";
    $values.=",$perm_anon";

    $fields.=",modified";
    $values.=",'$modified'";
    $fields.=",created";
    $values.=",'$created'";

    $fields.=",expired";
    $values.=",'$expired'";

    $fields.=",released";
    $values.=",'$released'";

    $fields.=",orderno";//
    $values.=",$orderno";

    $fields.=",uuid";
    $values.=",$uuid";

    $fields.=",draft_flag";
    $values.=",$draft_flag";

    $fields.=",udatetime";
    $values.=",NOW( )";

    DB_save($_TABLES['DATABOX_base'],$fields,$values);

    //カテゴリ
    //$rt=DATABOX_savedatas("category_id",$_TABLES['DATABOX_category'],$id,$category);
    $rt=DATABOX_savecategorydatas($id,$category);

	//追加項目
	DATABOX_uploadaddtiondatas	
        ($additionfields,$addition_def,$pi_name,$id,$additionfields_fnm,$additionfields_del);

    $rt=DATABOX_saveaddtiondatas
        ($id,$additionfields,$addition_def,$pi_name);

    $rt=fncsendmail ('data',$id);


//exit;// ＠＠＠＠＠＠debug 用

//    if ($edt_flg){
//        $return_page=$_CONF['site_url'] . "/".THIS_SCRIPT;
//        $return_page.="?id=".$id;
//    }else{
//        $return_page=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?msg=1';
//    }

    if ($_DATABOX_CONF['aftersave_admin']==='no'){
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
        $retval .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $retval .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
        $retval .= COM_showMessage (1,'databox');
        $retval .= fncEdit($id, $edt_flg,"","");
        $retval .= DATABOX_siteFooter('DATABOX','_admin');

        return $retval;
    }else if ($_DATABOX_CONF['aftersave_admin']==='list'){
            $url = $_CONF['site_admin_url'] . "/plugins/$pi_name/data.php";
            $item_url=COM_buildURL($url);
            $target='item';

    }else{
        $item_url=COM_buildURL($_CONF['site_url'] . "/".THIS_SCRIPT."?id=".$id);
        $target=$_DATABOX_CONF['aftersave_admin'];
    }

    $return_page = PLG_afterSaveSwitch(
                    $target
                    ,$item_url
                    ,'databox'
                    , 1);

    echo $return_page;


}
// +---------------------------------------------------------------------------+
// | 機能  削除                                                                |
// | 書式 fncdelete ()                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:戻り画面＆メッセージ                                           |
// +---------------------------------------------------------------------------+
function fncdelete ()
{
    global $_CONF, $_TABLES;
    global $LANG_DATABOX_ADMIN;
	
	$pi_name="databox";
	
	$id = COM_applyFilter($_POST['id'],true);
    $addition_def=DATABOX_getadditiondef();//@@@@@
	$additionfields=$_POST['afield'];//@@@@@
	
    // CHECK
    $err="";
    if ($err<>"") {
        $page_title=$LANG_DATABOX_ADMIN['err'];
        $retval .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $retval .= COM_startBlock ($LANG_DATABOX_ADMIN['err'], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $err;
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= DATABOX_siteFooter('DATABOX','_admin');
        return $retval;
    }

	$rt=databox_deletedata ($id);

    $rt=fncsendmail ('data_delete',$id,$title);

    //exit;// @@@@@debug 用

    $return_page=$_CONF['site_admin_url'] . '/plugins/'.THIS_SCRIPT.'?msg=2';

    return COM_refresh ($return_page);


}



// +---------------------------------------------------------------------------+
// | 機能  DRAFT チェンジ更新                                                  |
// | 書式 fncchangeDraft ($seqno)                                              |
// +---------------------------------------------------------------------------+
// | 引数 $draft_flg :                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncchangeDraft ($id)
{
    global $_TABLES;
    global $_USER;

    $id = COM_applyFilter($id,true);
    $uuid=$_USER['uid'];

    $sql="UPDATE {$_TABLES['DATABOX_base']} set ";
    if (DB_getItem($_TABLES['DATABOX_base'],"draft_flag", "id=$id")) {
        $sql.=" draft_flag = '0'";
    } else {
        $sql.=" draft_flag = '1'";
    }
    $sql.=",uuid='$uuid' WHERE id=$id";

    DB_query($sql);
    return;

}
// +---------------------------------------------------------------------------+
// | 機能  DRAFT チェンジ更新                                                  |
// | 書式 fncchangeDraftAll ($flg)                                             |
// +---------------------------------------------------------------------------+
// | 引数 $draft_flg :                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncchangeDraftAll ($flg)
{
    global $_TABLES;
    global $_USER;

    if ($flg==0) {
        $nflg=1;
    }else{
        $nflg=0;
    }
    $uuid=$_USER['uid'];

    $sql="UPDATE {$_TABLES['DATABOX_base']} set ";
    $sql.="draft_flag = '$flg'";
    $sql.=",uuid='$uuid' WHERE draft_flag='$nflg'";
    DB_query($sql);
    return;
}

// +---------------------------------------------------------------------------+
// | 機能  エキスポート                                                        |
// | 書式 fncexport ()                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncexport ()
{
global $_CONF,$_TABLES;
global $LANG_DATABOX_ADMIN;
//require_once ($_CONF['path'].'plugins/databox/lib/comj_dltbldt.php');

// 項目の見出リスト
$fld = array ();


$fld['id'] = $LANG_DATABOX_ADMIN['id'];
$fld['code'] = $LANG_DATABOX_ADMIN['code'];
$fld['title'] = $LANG_DATABOX_ADMIN['title'];

$fld['page_title'] = $LANG_DATABOX_ADMIN['page_title'];
$fld['description'] = $LANG_DATABOX_ADMIN['description'];
$fld['hits'] = $LANG_DATABOX_ADMIN['hits'];
$fld['comments'] = $LANG_DATABOX_ADMIN['comments'];
$fld['meta_description'] = $LANG_DATABOX_ADMIN['meta_description'];
$fld['meta_keywords'] = $LANG_DATABOX_ADMIN['meta_keywords'];
$fld['commentcode'] = $LANG_DATABOX_ADMIN['commentcode'];
$fld['comment_expire'] = $LANG_DATABOX_ADMIN['comment_expire'];

// 準備中　$fld['language_id'] = $LANG_DATABOX_ADMIN['language_id'];
$fld['owner_id'] = $LANG_DATABOX_ADMIN['owner_id'];
$fld['group_id'] = $LANG_DATABOX_ADMIN['group_id'];
$fld['perm_owner'] = $LANG_DATABOX_ADMIN['perm_owner'];
$fld['perm_group'] = $LANG_DATABOX_ADMIN['perm_group'];
$fld['perm_members'] = $LANG_DATABOX_ADMIN['perm_members'];
$fld['perm_anon'] = $LANG_DATABOX_ADMIN['perm_anon'];

$fld['modified'] = $LANG_DATABOX_ADMIN['modified'];
$fld['created'] = $LANG_DATABOX_ADMIN['created'];
$fld['expired'] = $LANG_DATABOX_ADMIN['expired'];
$fld['released'] = $LANG_DATABOX_ADMIN['released'];

$fld['orderno'] = $LANG_DATABOX_ADMIN['orderno'];

$fld['draft_flag'] = $LANG_DATABOX_ADMIN['draft'];
$fld['udatetime'] = $LANG_DATABOX_ADMIN['udatetime'];
$fld['uuid'] = $LANG_DATABOX_ADMIN['uuid'];
//-----

//----------------------
$filenm="databox_data";
$tbl ="{$_TABLES['DATABOX_base']}";
$where = "";
$order = "id";
$addition=true;
$tbl_prefix="DATABOX";


$rt= DATABOX_dltbldt($filenm,$fld,$tbl,$where,$order,$tbl_prefix,$addition);


return $rt;
}
// +---------------------------------------------------------------------------+
// | 機能  インポート画面表示                                                  |
// | 書式 fncimport ()                                                         |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncimport ()
{
    global $_CONF;//, $LANG28;
    global $LANG_DATABOX_ADMIN;

    $tmpl = new Template ($_CONF['path'] . "plugins/".THIS_PLUGIN."/templates/admin/");
    $tmpl->set_file(array('import' => 'import.thtml'));

    $tmpl->set_var('site_admin_url', $_CONF['site_admin_url']);

    $tmpl->set_var('gltoken_name', CSRF_TOKEN);
    $tmpl->set_var('gltoken', SEC_createToken());
    $tmpl->set_var ( 'xhtml', XHTML );

    $tmpl->set_var('script', THIS_SCRIPT);

    $tmpl->set_var('importmsg', $LANG_DATABOX_ADMIN['importmsg']);
    $tmpl->set_var('importfile', $LANG_DATABOX_ADMIN['importfile']);
    $tmpl->set_var('submit', $LANG_DATABOX_ADMIN['submit']);

    $tmpl->parse ('output', 'import');
    $import = $tmpl->finish ($tmpl->get_var ('output'));

    $retval="";
    $retval .= COM_startBlock ($LANG_DATABOX_ADMIN['import'], '',
                            COM_getBlockTemplate ('_admin_block', 'header'));
    $retval .= $import;
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));


    return $retval;
}
// +---------------------------------------------------------------------------+
// | 機能  メール送信                                                          |
// | 書式 fncsendmail ()                                                       |
// +---------------------------------------------------------------------------+
// | 戻値 nomal:                                                               |
// +---------------------------------------------------------------------------+
function fncsendmail (
    $m=""
    ,$id=0
    ,$title=""
    )
{
    global $_CONF;
    global $_TABLES;
    global $LANG_DATABOX_MAIL;
    global $LANG_DATABOX_ADMIN;
    global $_USER ;
    global $_DATABOX_CONF ;

    $retval = '';

    $site_name=$_CONF['site_name'];
    $subject= $LANG_DATABOX_MAIL['subject_'.$m];
	$message=$LANG_DATABOX_MAIL['message_'.$m];
	
    $subject= sprintf($LANG_DATABOX_MAIL['subject_'.$m],$_USER['username']);
    $message=sprintf($LANG_DATABOX_MAIL['message_'.$m],$_USER['username'],$_USER['uid']);

    if ($m==="data_delete"){
        $msg= $LANG_DATABOX_ADMIN['id'].":".$id.LB;
        $msg.= $LANG_DATABOX_ADMIN['title'].":".$title.LB;
        //URL
        $url=$_CONF['site_url'] . "/databox/data.php";
        $url = COM_buildUrl( $url );

    }else{
        $sql = "SELECT ";

        $sql .= " *";

        $sql .= " FROM ";
        $sql .= $_TABLES['DATABOX_base'];
        $sql .= " WHERE ";
        $sql .= " id = $id";

        $result = DB_query ($sql);
        $numrows = DB_numRows ($result);

        if ($numrows > 0) {

            $A = DB_fetchArray ($result);

            //下書
            if ($A['draft_flag']==1) {
                $msg.=$LANG_DATABOX_ADMIN['draft'].LB;
            }

            //基本項目
            $msg.= $LANG_DATABOX_ADMIN['id'].":".$A['code'].LB;
            $msg.= $LANG_DATABOX_ADMIN['code'].":".$A['code'].LB;
            $msg.= $LANG_DATABOX_ADMIN['title'].":".$A['title'].LB;
            $msg.= $LANG_DATABOX_ADMIN['page_title'].":".$A['page_title'].LB;
            $msg.= $LANG_DATABOX_ADMIN['description'].":".$A['description'].LB;

            $msg.= $LANG_DATABOX_ADMIN['hits'].":".$A['hits'].LB;
            $msg.= $LANG_DATABOX_ADMIN['comments'].":".$A['comments'].LB;
            $msg.= $LANG_DATABOX_ADMIN['meta_description'].":".$A['meta_description'].LB;
            $msg.= $LANG_DATABOX_ADMIN['meta_keywords'].":".$A['meta_keywords'].LB;
            $msg.= $LANG_DATABOX_ADMIN['commentcode'].":".$A['commentcode'].LB;
            $msg.= $LANG_DATABOX_ADMIN['comment_expire'].":".$A['comment_expire'].LB;

            // 準備中　$msg.=  $LANG_DATABOX_ADMIN['language_id'].":".$A['language_id'].LB;
            $msg.= $LANG_DATABOX_ADMIN['owner_id'].":".$A['owner_id'].LB;
            $msg.= $LANG_DATABOX_ADMIN['group_id'].":".$A['group_id'].LB;
            $msg.= $LANG_DATABOX_ADMIN['perm_owner'].":".$A['perm_owner'].LB;
            $msg.= $LANG_DATABOX_ADMIN['perm_group'].":".$A['perm_group'].LB;
            $msg.= $LANG_DATABOX_ADMIN['perm_members'].":".$A['perm_members'].LB;
            $msg.= $LANG_DATABOX_ADMIN['perm_anon'].":".$A['perm_anon'].LB;

            $msg.= $LANG_DATABOX_ADMIN['modified'].":".$A['modified'].LB;
            $msg.= $LANG_DATABOX_ADMIN['created'].":".$A['created'].LB;
            $msg.= $LANG_DATABOX_ADMIN['expired'].":".$A['expired'].LB;
            $msg.= $LANG_DATABOX_ADMIN['released'].":".$A['released'].LB;

            $msg.= $LANG_DATABOX_ADMIN['orderno'].":".$A['orderno'].LB;

            $msg.= $LANG_DATABOX_ADMIN['draft'].":".$A['draft'].LB;
            $msg.= $LANG_DATABOX_ADMIN['udatetime'].":".$A['udatetime'].LB;
            $msg.= $LANG_DATABOX_ADMIN['uuid'].":".$A['uuid'].LB;

            //カテゴリ
            $msg.=DATABOX_getcategoriesText($id ,0,"DATABOX");

            //追加項目
            $group_id = stripslashes($A['group_id']);
            $owner_id = stripslashes($A['owner_id']);
            $chk_user=DATABOX_chkuser($group_id,$owner_id,"databox.admin");
            $addition_def=DATABOX_getadditiondef();
            $additionfields = DATABOX_getadditiondatas($id);
            $msg.=DATABOX_getaddtionfieldsText($additionfields,$addition_def,$chk_user);

            //タイムスタンプ　更新ユーザ
            $msg.= $LANG_DATABOX_ADMIN['udatetime'].":".$A['udatetime'].LB;
            $msg.= $LANG_DATABOX_ADMIN['uuid'].":".$A['uuid'].LB;


            //URL
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

        }
    }

    $message.=$msg.LB;
    $message.=$url.LB;
    $message.=$LANG_DATABOX_MAIL['sig'].LB;

    $mail_to=$_DATABOX_CONF['mail_to'];
    //--- to user
    if (array_search($_USER['email'],$mail_to)===false){
        $to=$_USER['email'];
        COM_mail ($to, $subject, $message);
    }
    //--- to admin
    $to=implode($mail_to,",");
    COM_mail ($to, $subject, $message);
    return $retval;
}

// +---------------------------------------------------------------------------+
// | MAIN                                                                      |
// +---------------------------------------------------------------------------+

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

if (isset ($_POST['draftChange'])) {
    $mode='draftChange';
}

//echo "mode=".$mode."<br>";
if ($mode=="" OR $mode=="edit" OR $mode=="new" OR $mode=="drafton" OR $mode=="draftoff"
    OR $mode=="export" OR $mode=="import"  OR $mode=="copy") {
}else{
    if (!SEC_checkToken()){
 //    if (SEC_checkToken()){//テスト用
        COM_accessLog("User {$_USER['username']} tried to illegally and failed CSRF checks.");
        echo COM_refresh($_CONF['site_admin_url'] . '/index.php');
        exit;
    }
}

//DRAFT ON OFF
if (isset ($_POST['draftChange'])) {
    fncchangeDraft ($_POST['draftChange']);
}

//DRAFT 一括ON OFF
if ($mode=="drafton") {
    fncchangeDraftAll (1);
}
if ($mode=="draftoff") {
    fncchangeDraftAll (0);
}


//
$menuno=2;
$display="";

//echo "mode=".$mode."<br>";
switch ($mode) {
    case 'export':// エキスポート
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['export'];
        $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $display=fncexport ();
        break;
    case 'exportform':// エキスポートフォーム表示
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['export'];
        $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
        $display .= fncMenu();
        //メッセージ表示
        if (!empty ($msg)) {
            $display.= COM_startBlock ($LANG_DATABOX_ADMIN['err'], '',
                               COM_getBlockTemplate ('_msg_block', 'header'))
                    . $LANG_DATABOX_ADMIN[$msg]
                    . COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        }
        $display=fncexportform();
        //$display .= fncimport();
        break;

    case 'new':// 新規登録
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['new'];
        $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $display .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
        $display .= fncEdit("", $edt_flg,$msg);
        $display .= DATABOX_siteFooter('DATABOX','_admin');

        break;

    case 'save':// 保存
        $display .= fncSave ($edt_flg,$navbarMenu,$menuno);
        break;
    case 'delete':// 削除
        $display .= fncdelete();
        break;
    case 'copy'://コピー
    case 'edit':// 編集
        if (!empty ($id) ) {
            $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
            $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
            if ($edt_flg==FALSE){
                $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
            }
            $display .= fncEdit($id, $edt_flg,$msg,"",$mode);
            $display .= DATABOX_siteFooter('DATABOX','_admin');

        }
        break;

    case 'import':// インポート
        $page_title=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['import'];
        $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);
        $display .= fncimport();
        $display .= DATABOX_siteFooter('DATABOX','_admin');

        break;


    default:// 初期表示、一覧表示

        $page_title=$LANG_DATABOX_ADMIN['piname'];
        $display .= DATABOX_siteHeader('DATABOX','_admin',$page_title);

        if (isset ($msg)) {
            $display .= COM_showMessage ($msg,'databox');
        }
        $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);

        $display .= fncList();
        $display .= DATABOX_siteFooter('DATABOX','_admin');


}



COM_output($display);

?>