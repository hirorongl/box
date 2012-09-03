<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | data maintenannce
// +---------------------------------------------------------------------------+
// $Id: data.php
// public_html/databox/mydata/data.php
// 20101208 tsuchitani AT ivywe DOT co DOT jp
// 20120416 fncsave hits

//@@@@@@追加予定　メールにカテゴリ

define ('THIS_SCRIPT', 'databox/mydata/data.php');
//define ('THIS_SCRIPT', 'databox/mydata/test.php');

include_once('databox_functions.php');

require_once ($_CONF['path'] . 'plugins/databox/lib/lib_datetimeedit.php');

if ($_DATABOX_CONF['allow_data_update']==1 ){
}else{
    if (SEC_hasRights ('databox.edit') ){
	}else{
		COM_accessLog("User {$_USER['username']} tried to data and failed ");
		echo COM_refresh($_CONF['site_url'] . '/index.php');
		exit;
	}
}

// +---------------------------------------------------------------------------+
// | 機能  一覧表示                                                            |
// | 書式 fncList()                                                            |
// +---------------------------------------------------------------------------+\
// | 戻値 nomal:一覧                                                           |
// +---------------------------------------------------------------------------+
function fncList()
{
    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $LANG09;
    global $LANG_DATABOX_ADMIN;
    global $LANG_DATABOX;
    global $_DATABOX_CONF;

    require_once( $_CONF['path_system'] . 'lib-admin.php' );

	$retval = '';
	
	//フィルタ
    if (!empty ($_GET['filter_val'])) {
        $filter_val = COM_applyFilter($_GET['filter_val']);
    } elseif (!empty ($_POST['filter_val'])) {
        $filter_val = COM_applyFilter($_POST['filter_val']);
    } else {
        $filter_val = $LANG09[9];
    }
    if  ($filter_val==$LANG09[9]){
        $exclude="";
    }else{
        $exclude=" AND t.fieldset_id={$filter_val}";
    }

    $filter = "{$LANG_DATABOX_ADMIN['fieldset']}:";
    $filter .="<select name='filter_val' style='width: 125px' onchange='this.form.submit()'>";
    $filter .="<option value='{$LANG09[9]}'";

    if  ($filter_val==$LANG09[9]){
        $filter .=" selected='selected'";
    }
    $filter .=" >{$LANG09[9]}</option>";
    $filter .= COM_optionList ($_TABLES['DATABOX_def_fieldset']
                , 'fieldset_id,name', $filter_val,0,"");

    $filter .="</select>";
	

    //MENU1:管理画面
    $url1=$_CONF['site_url'] . '/'.THIS_SCRIPT.'?mode=new';
    $url2=$_CONF['site_url'] . '/databox/index.php';

    if ($_DATABOX_CONF['allow_data_insert']
            OR SEC_hasRights('databox.submit')){
        $menu_arr[]=array('url' => $url1,'text' => $LANG_DATABOX_ADMIN["new"]);
    }
    $menu_arr[]=array('url' => $url2,'text' => $LANG_DATABOX['list']);
    $retval .= COM_startBlock($LANG_DATABOX_ADMIN['admin_list'], '',
                              COM_getBlockTemplate('_admin_block', 'header'));//@@@@@
    $retval .= ADMIN_createMenu(
        $menu_arr,
        $LANG_DATABOX_ADMIN['instructions'],
        plugin_geticon_databox()
    );


    //ヘッダ：編集～
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['orderno'], 'field' => 'orderno', 'sort' => true);
    $header_arr[]=array('text' => $LANG_ADMIN['edit'], 'field' => 'editid', 'sort' => false);

    if ($_DATABOX_CONF['allow_data_insert']
            OR SEC_hasRights('databox.submit')){
        $header_arr[]=array('text' => $LANG_ADMIN['copy'], 'field' => 'copy', 'sort' => false);
    }
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['id'], 'field' => 'id', 'sort' => true);
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['code'], 'field' => 'code', 'sort' => true);
	$header_arr[]=array('text' => $LANG_DATABOX_ADMIN['title'], 'field' => 'title', 'sort' => true);
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['fieldset'], 'field' => 'fieldset_name', 'sort' => true);

    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['udatetime'], 'field' => 'udatetime', 'sort' => true);
    $header_arr[]=array('text' => $LANG_DATABOX_ADMIN['draft'], 'field' => 'draft_flag', 'sort' => true);

    //
    $text_arr = array('has_menu' =>  true,
      'has_extras'   => true,
      'form_url' => $_CONF['site_url'] ."/".THIS_SCRIPT);

    //Query
    $sql = "SELECT ";
    $sql .= " id";
    $sql .= " ,title";
    $sql .= " ,code";
    $sql .= " ,draft_flag";
    $sql .= " ,modified";
    $sql .= " ,UNIX_TIMESTAMP(t.udatetime) AS udatetime";
    $sql .= " ,orderno";
    $sql .= " ,t2.name AS fieldset_name";
    $sql .= " ,t.fieldset_id";

    $sql .= " ,owner_id";
    $sql .= " ,group_id";
    $sql .= " ,perm_owner";
    $sql .= " ,perm_group";
    $sql .= " ,perm_members";
    $sql .= " ,perm_anon";

    $sql .= " FROM ";
    $sql .= " {$_TABLES['DATABOX_base']} AS t";
    $sql .= " ,{$_TABLES['DATABOX_def_fieldset']} AS t2";
    $sql .= " WHERE ";

    $sql .= " t.fieldset_id=t2.fieldset_id";
    //編集権のないデータ はのぞく
    $sql .= COM_getPermSql('AND',0,3);

    $query_arr = array(
        'table' => 'DATABOX_base',
        'sql' => $sql,
        'query_fields' => array('id','title','code','draft_flag','orderno','t2.name'),
        'default_filter' => $exclude);
    //デフォルトソート項目:
    $defsort_arr = array('field' => 'orderno', 'direction' => 'ASC');
    //List 取得
    $retval .= ADMIN_list(
        'databox'
        , "fncGetListField"
        , $header_arr
        , $text_arr
        , $query_arr
        , $defsort_arr
        , $filter
        );

    $retval .= COM_endBlock(COM_getBlockTemplate('_admin_block', 'footer'));

    return $retval;
}

// +---------------------------------------------------------------------------+
// | 一覧取得                                                                  |
// | 書式 plugin_getListField_databox                                          |
// +---------------------------------------------------------------------------+
function fncGetListField($fieldname, $fieldvalue, $A, $icon_arr)
{
    global $_CONF;
    global $LANG_ACCESS;
    global $_DATABOX_CONF;
    global $LANG_DATABOX_ADMIN;

    $retval = '';

        switch($fieldname) {
            //編集アイコン
            case 'editid':
                $url=$_CONF['site_url'] . "/".THIS_SCRIPT;
                $url.="?";
                $url.="mode=edit";
                $url.="&amp;id=".$A['id'];
                $retval = COM_createLink($icon_arr['edit'],$url);
                break;
            case 'copy':
                $url=$_CONF['site_url'] . "/".THIS_SCRIPT;
                $url.="?";
                $url.="mode=copy";
                $url.="&amp;id=".$A['id'];
                $retval = COM_createLink($icon_arr['copy'],$url);
                break;

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
                $retval .= "onclick=\"submit()\" value=\"{$A['draft_flag']}\" $switch disabled>";
                $retval .= "<input type=\"hidden\" name=\"draftChange\" ";
                $retval .= "value=\"{$A['id']}\">";
                $retval .= "</form>";
				break;
			case 'udatetime':
				$curtime = COM_getUserDateTimeFormat($A['udatetime']);
				$retval = $curtime[0];
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
// +---------------------------------------------------------------------------+
// | 戻値 nomal:編集画面                                                       |
// +---------------------------------------------------------------------------+
// update 20101207
function fncEdit(
    $id
    , $edt_flg,$msg = ''
    ,$errmsg=""
    ,$mode="edit"
)
{

    $pi_name="databox";

    global $_CONF;
    global $_TABLES;
    global $LANG_DATABOX_ADMIN;
    global $LANG_ADMIN;
    global $MESSAGE;
    global $LANG_ACCESS;
    global $_DATABOX_CONF;
    global $_USER;

    $retval = '';


    $delflg=false;


    $addition_def=DATABOX_getadditiondef();

    //メッセージ表示
    if (!empty ($msg)) {
        $retval .= COM_showMessage ($msg,$pi_name);
        $retval .= $errmsg;
        // clean 'em up
        $code=COM_applyFilter($_POST['code']);
        $title = COM_stripslashes($_POST['title']);
        $page_title = COM_applyFilter($_POST['page_title']);
        $description=$_POST['description'];//COM_applyFilter($_POST['description']);
        $defaulttemplatesdirectory = COM_applyFilter($_POST['defaulttemplatesdirectory']);//@@@@@@

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
            ($additionfields,$addition_def,$additionfields_fnm,$additionfields_del,false);
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
        $created = COM_applyFilter ($_POST['created']);
        $created_un = COM_applyFilter ($_POST['created_un']);

        $orderno = COM_applyFilter ($_POST['orderno']);

        $uuid=$_USER['uid'];
        $udatetime=COM_applyFilter ($_POST['udatetime']);//"";

        $fieldset_id=COM_applyFilter ($_POST['fieldset'],true);//"";

    }else{
        if (empty($id)) {
			$fieldset_id=COM_applyFilter ($_POST['fieldset'],true);//"";
			$fieldset_name=DB_getItem($_TABLES['DATABOX_def_fieldset'],"name","fieldset_id=".$fieldset_id);
			$fieldset_name=COM_stripslashes($fieldset_name);
			

            $id=0;

            $code ="";
            $title ="";
            $description="";
            $defaulttemplatesdirectory=null;

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

            $commentcode =-1;

            $meta_description ="";
            $meta_keywords ="";

            $category = "";
            $additionfields=array();
            $additionfields_fnm=array();//@@@@@
            $additionfields_del=array();
            $additionfields = DATABOX_getadditiondatas(0,$pi_name);

            //
            $owner_id =$_USER['uid'];
            $group_id =SEC_getFeatureGroup('databox.admin', $_USER['uid']);//??????

            $array = array();
            SEC_setDefaultPermissions($array, $_DATABOX_CONF['default_perm']);
            $perm_owner = $array['perm_owner'];
            $perm_group = $array['perm_group'];
            $perm_anon = $array['perm_anon'];
            $perm_members = $array['perm_members'];

            //
            $draft_flag=$_DATABOX_CONF['user_draft_default'];
            //編集日付
            $modified_month = date('m');
            $modified_day = date('d');
            $modified_year = date('Y');
            $modified_hour = date('H');
            $modified_minute = date('i');
            //作成日付
			$created=0;
			$created_un=0;
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

			$sql .= " t.*".LB;
			$sql .= " ,t2.name AS fieldset_name".LB;
			
			
			$sql .= " ,UNIX_TIMESTAMP(t.modified) AS modified_un".LB;
			$sql .= " ,UNIX_TIMESTAMP(t.released) AS released_un".LB;
			$sql .= " ,UNIX_TIMESTAMP(t.comment_expire) AS comment_expire_un".LB;
			$sql .= " ,UNIX_TIMESTAMP(t.expired) AS expired_un".LB;
			$sql .= " ,UNIX_TIMESTAMP(t.udatetime) AS udatetime_un".LB;
			$sql .= " ,UNIX_TIMESTAMP(t.created) AS created_un".LB;
			
			$sql .= " FROM ";
			$sql .= $_TABLES['DATABOX_base'] ." AS t ".LB;
			$sql .= ",".$_TABLES['DATABOX_def_fieldset'] ." AS t2 ".LB;
            $sql .= " WHERE ".LB;
			$sql .= " id = $id".LB;
			$sql .= " AND t.fieldset_id = t2.fieldset_id".LB;

            //編集権のないデータ はのぞく//@@@@@
            $sql .= COM_getPermSql('AND',0,3);


            $result = DB_query($sql);

            $A = DB_fetchArray($result);
            $fieldset_id = COM_stripslashes($A['fieldset_id']);
            $fieldset_name = COM_stripslashes($A['fieldset_name']);

            $code = COM_stripslashes($A['code']);
            $title=COM_stripslashes($A['title']);
            $page_title=COM_stripslashes($A['page_title']);
            $description=COM_stripslashes($A['description']);
            $defaulttemplatesdirectory=COM_stripslashes($A['defaulttemplatesdirectory']);

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
				$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['comment_expire_un']));
				$comment_expire = $wary[1];
                $comment_expire_year=date('Y', $comment_expire);
                $comment_expire_month=date('m', $comment_expire);
                $comment_expire_day=date('d', $comment_expire);
                $comment_expire_hour=date('H', $comment_expire);
                $comment_expire_minute=date('i', $comment_expire);
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

            $category = DATABOX_getdatas("category_id",$_TABLES['DATABOX_category'],"id = $id");

            //追加項目
            $additionfields = DATABOX_getadditiondatas($id,$pi_name);
            $additionfields_fnm=array();//@@@@@
            $additionfields_del=array();

            $draft_flag=COM_stripslashes($A['draft_flag']);

			//編集日
			$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['modified_un']));
			$modified = $wary[1];
            $modified_month = date('m', $modified);
            $modified_day = date('d', $modified);
            $modified_year = date('Y', $modified);
            $modified_hour = date('H', $modified);
            $modified_minute = date('i', $modified);
            //公開日
			$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['released_un']));
			$released = $wary[1];
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
				$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['expired_un']));
				$expired = $wary[1];
                $expired_year=date('Y', $expired);
                $expired_month=date('m', $expired);
                $expired_day=date('d', $expired);
                $expired_hour=date('H', $expired);
                $expired_minute=date('i', $expired);
           }

            //作成日付
			$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['created_un']));
			$created = $wary[0];
			$created_un = $wary[1];

            $orderno=COM_stripslashes($A['orderno']);

            $uuid = COM_stripslashes($A['uuid']);

			$wary = COM_getUserDateTimeFormat(COM_stripslashes($A['udatetime_un']));
			$udatetime = $wary[0];

            if ($_DATABOX_CONF['allow_data_delete']){
                if ($edt_flg==FALSE) {
                    $delflg=true;
                }
            }
        }
    }
    if ($mode==="copy"){
        $id=0;
        $draft_flag=$_DATABOX_CONF['user_draft_default'];

        //作成日付
        $created=0;
        //
        $delflg=false;

    }

    $chk_user=DATABOX_chkuser($group_id,$owner_id,"databox.admin");

    //-----
    $retval .= COM_startBlock ($LANG_DATABOX_ADMIN['edit'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    //template フォルダ
    $tmplfld=DATABOX_templatePath('mydata','default','databox');
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
	$templates->set_var('lang_view', $LANG_DATABOX_ADMIN['view']);

    $templates->set_var('dateformat', $_DATABOX_CONF['dateformat']);

    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);
    $templates->set_var('gltoken_name', CSRF_TOKEN);
    $templates->set_var('gltoken', $token);
    $templates->set_var ( 'xhtml', XHTML );

    $templates->set_var('script', THIS_SCRIPT);

    //
    $templates->set_var('lang_link_admin', $LANG_DATABOX_ADMIN['link_admin']);
    $templates->set_var('lang_link_admin_top', $LANG_DATABOX_ADMIN['link_admin_top']);
    $templates->set_var('lang_link_public', $LANG_DATABOX_ADMIN['link_public']);
    $templates->set_var('lang_link_list', $LANG_DATABOX_ADMIN['link_list']);
    $templates->set_var('lang_link_detail', $LANG_DATABOX_ADMIN['link_detail']);
	
	//field_id
    $templates->set_var('lang_fieldset', $LANG_DATABOX_ADMIN['fieldset']);
    $templates->set_var('fieldset_id', $fieldset_id);
    $templates->set_var('fieldset_name', $fieldset_name);

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

    //カテゴリ
    $templates->set_var('lang_category', $LANG_DATABOX_ADMIN['category']);
    $checklist_category=DATABOX_getcheckList ("category",$category);
    $templates->set_var('checklist_category', $checklist_category);

    //追加項目
    $templates->set_var('lang_additionfields', $LANG_DATABOX_ADMIN['additionfields']);
    $rt=DATABOX_getaddtionfieldsEdit
        ($additionfields,$addition_def,$templates,$chk_user,$pi_name
            ,$additionfields_fnm,$additionfields_del,$fieldset_id);
    $rt=DATABOX_getaddtionfieldsJS($additionfields,$addition_def,$chk_user,$pi_name);

    //保存日時
    $templates->set_var ('lang_udatetime', $LANG_DATABOX_ADMIN['udatetime']);
    $templates->set_var ('udatetime', $udatetime);
    $templates->set_var ('lang_uuid', $LANG_DATABOX_ADMIN['uuid']);
    $templates->set_var ('uuid', $uuid);
    //作成日付
    $templates->set_var ('lang_created', $LANG_DATABOX_ADMIN['created']);
    $templates->set_var ('created', $created);
    $templates->set_var ('created_un', $created_un);

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
    global $LANG_DATABOX_user_menu;

    $addition_def=DATABOX_getadditiondef();

    $retval = '';

    // clean 'em up
    $id = COM_applyFilter($_POST['id'],true);
    if ($id==0){
        $new_flg=true;
    }else{
        $new_flg=false;
    }
	$fieldset_id = COM_applyFilter ($_POST['fieldset'],true);
    $code = COM_applyFilter($_POST['code']);
    $code = addslashes (COM_checkHTML (COM_checkWords ($code)));

    $title = COM_stripslashes($_POST['title']);
    $title = addslashes (COM_checkHTML (COM_checkWords ($title)));

    $page_title = COM_applyFilter($_POST['page_title']);
    $page_title = addslashes (COM_checkHTML (COM_checkWords ($page_title)));

    $description=$_POST['description'];//COM_applyFilter($_POST['description']);
    $description=addslashes (COM_checkHTML (COM_checkWords ($description)));

    $category = $_POST['category'];

    //@@@@@
    $additionfields=$_POST['afield'];
    $additionfields_fnm=$_POST['afield_fnm'];
    $additionfields_del=$_POST['afield_del'];

    $additionfields=DATABOX_cleanaddtiondatas
        ($additionfields,$addition_def,$additionfields_fnm,$additionfields_del);


//            $hits =0;
//            $comments=0;

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

    //タイトル必須
    if (empty($title)){
        $err.=$LANG_DATABOX_ADMIN['err_title']."<br/>".LB;
    }

    //----追加項目チェック
    $err.=DATABOX_checkaddtiondatas
        ($additionfields,$addition_def,$pi_name,$additionfields_fnm,$additionfields_del);

    //errorのあるとき
    if ($err<>"") {
        $retval['title']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
        $retval['display']= fncEdit($id, $edt_flg,3,$err);

        return $retval;

    }
    // CHECK　おわり

    //-----
    // 新規登録時
    if ($new_flg){
       $w=DB_getItem($_TABLES['DATABOX_base'],"max(id)","1=1");
        if ($w=="") {
            $w=0;
        }
        $id=$w+1;
    }

    $fields=LB."id";
    $values=LB."$id";


    if ($new_flg){

        if  ($_DATABOX_CONF['datacode']){
            $code="000000".date(Ymdhis);

        }
        $created=date("Y-m-d H:i:s");
        $modified=$created;
        $released=$created;
        $commentcode =0;
        $comment_expire='0000-00-00 00:00:00';
        $expired='0000-00-00 00:00:00';
        //

        $defaulttemplatesdirectory=null;
        $draft_flag =$_DATABOX_CONF['user_draft_default'];

        //---
        $meta_description = "";
        $meta_keywords = "";
        $owner_id =$_USER['uid'];
        $group_id =SEC_getFeatureGroup('databox.admin', $_USER['uid']);


        $array = array();
        SEC_setDefaultPermissions($array, $_DATABOX_CONF['default_perm']);
        $perm_owner = $array['perm_owner'];
        $perm_group = $array['perm_group'];
        $perm_anon = $array['perm_anon'];
        $perm_members = $array['perm_members'];

        $draft_flag=$_DATABOX_CONF['user_draft_default'];

        //-----

        $fields.=",defaulttemplatesdirectory";//
        $values.=",'$defaulttemplatesdirectory'";


        $fields.=",draft_flag";
        $values.=",$draft_flag";

        $fields.=",meta_description";//
        $values.=",'$meta_description'";

        $fields.=",meta_keywords";//
        $values.=",'$meta_keywords'";

        $fields.=",commentcode";//
        $values.=",$commentcode";

        $fields.=",comment_expire";//
		if ($comment_expire=='0000-00-00 00:00:00'){
			$values.=",'$comment_expire'";
		}else{
			$values.=",FROM_UNIXTIME('$comment_expire')";
		}

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
		$values.=",FROM_UNIXTIME('$modified')";

		$fields.=",created";
		$values.=",FROM_UNIXTIME('$created')";

        $fields.=",expired";
		if ($expired=='0000-00-00 00:00:00'){
			$values.=",'$expired'";
		}else{
			$values.=",FROM_UNIXTIME('$expired')";
		}

        $fields.=",released";
		$values.=",FROM_UNIXTIME('$released')";

        $hits=0;
        $comments=0;

        $fields.=",code";
        $values.=",'$code'";

        $fields.=",title";//
        $values.=",'$title'";

        $fields.=",page_title";//
        $values.=",'$page_title'";

        $fields.=",description";//
        $values.=",'$description'";


//        $fields.=",hits";//
//        $values.=",$hits";

        $fields.=",comments";//
        $values.=",$comments";

		$fields.=",fieldset_id";//
		$values.=",$fieldset_id";

        $fields.=",uuid";
        $values.=",$uuid";

        if ($edt_flg){
            $return_page=$_CONF['site_url'] . "/".THIS_SCRIPT;
            $return_page.="?id=".$id;
        }else{
            $return_page=$_CONF['site_url'] . '/'.THIS_SCRIPT.'?msg=1';
        }

        DB_save($_TABLES['DATABOX_base'],$fields,$values);
    }else{
        $modified=date("Y-m-d H:i:s");
		
        $sql="UPDATE {$_TABLES['DATABOX_base']} set ";
        $sql.=" title = '$title'";
        $sql.=" ,page_title = '$page_title'";
        $sql.=" ,description = '$description'";
		
        $sql.=" ,modified = FROM_UNIXTIME('$modified')";
		
        $sql.=",uuid='$uuid' WHERE id=$id";

        DB_query($sql);

    }

    //カテゴリ
    //$rt=DATABOX_savedatas("category_id",$_TABLES['DATABOX_category'],$id,$category);
    $rt=DATABOX_savecategorydatas($id,$category);

	//追加項目
	DATABOX_uploadaddtiondatas	
        ($additionfields,$addition_def,$pi_name,$id,$additionfields_fnm,$additionfields_del);

    if ($new_flg){
        $rt=DATABOX_saveaddtiondatas($id,$additionfields,$addition_def,$pi_name);
    }else{
        $rt=DATABOX_saveaddtiondatas_update($id,$additionfields,$addition_def,$pi_name);
    }

    $rt=fncsendmail ('data',$id);

//@@@@@ exit;//@@@@@debug 用

    if ($_DATABOX_CONF['aftersave']==='no'){
        $retval['title']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
        $retval['display'] .= fncEdit($id, $edt_flg,1,$err);
        return $retval;

    }else if ($_DATABOX_CONF['aftersave']==='list'
          OR $_DATABOX_CONF['aftersave']==='admin' ){
            $url = $_CONF['site_url'] . "/databox/mydata/data.php";
            $item_url=COM_buildURL($url);
            $target='item';
    }else{
            $item_url=$_CONF['site_url'] . "/databox/data.php?id=".$id;
            $target=$_DATABOX_CONF['aftersave'];
    }

    $return_page = PLG_afterSaveSwitch(
                    $target
                    ,$item_url
                    ,$pi_name
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
    global $_CONF;
    global $_TABLES;
    global $LANG_DATABOX_ADMIN;
	
	$pi_name="databox";
    $id = COM_applyFilter($_POST['id'],true);
    $title=DB_getItem ($_TABLES['DATABOX_base'], 'title',"id = ".$id);
	
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

    //
	$rt=databox_deletedata ($id);

    $rt=fncsendmail ('data_delete',$id,$title);

    //exit;// debug 用

    $return_page=$_CONF['site_url'] . '/'.THIS_SCRIPT.'?msg=2';
    return COM_refresh ($return_page);



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
    $subject= sprintf($LANG_DATABOX_MAIL['subject_'.$m],$_USER['username']);
    $message=sprintf($LANG_DATABOX_MAIL['message_'.$m],$_USER['username'],$_USER['uid']);

    if ($m==="data_delete"){
        $msg= $LANG_DATABOX_ADMIN['id'].":".$id.LB;
        $msg.= $LANG_DATABOX_ADMIN['title'].":".$title.LB;
        //URL
        $url=$_CONF['site_url'] . "/databox/data.php";
        $url = COM_buildUrl( $url );
		$A['draft_flag']=0;
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
            $msg.= $LANG_DATABOX_ADMIN['code'].":".$A['code'].LB;
            $msg.= $LANG_DATABOX_ADMIN['title'].":".$A['title'].LB;
            $msg.= $LANG_DATABOX_ADMIN['page_title'].":".$A['page_title'].LB;
            $msg.= $LANG_DATABOX_ADMIN['description'].":".$A['description'].LB;

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
	
	if  (($_DATABOX_CONF['mail_to_draft']==0) AND ($A['draft_flag']==0)){
	}else{

		$message.=$msg.LB;
		$message.=$url.LB;
		$message.=$LANG_DATABOX_MAIL['sig'].LB;

		$mail_to=$_DATABOX_CONF['mail_to'];
		//--- to owner
		if  ($_DATABOX_CONF['mail_to_owner']==1){
			$owner_email=DB_getItem($_TABLES['users'],"email","uid=".$A['owner_id']);
			if (array_search($owner_email,$mail_to)===false){
				$to=$owner_email;
				COM_mail ($to, $subject, $message);
			}
		}
		//--- mail_to
		if  ($mail_to<>""){
			$to=implode($mail_to,",");
			COM_mail ($to, $subject, $message);
		}
	}

    return $retval;
}


function fncNew ()
{
	global $_CONF;
	global $LANG_DATABOX_ADMIN;
	global $LANG_ADMIN;
	
	$pi_name="databox";
	
    $retval = '';
	
	//-----
    $retval .= COM_startBlock ($LANG_DATABOX_ADMIN["new"], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));
	
    $tmplfld=DATABOX_templatePath('mydata','default',$pi_name);

    $templates = new Template($tmplfld);
    $templates->set_file('editor',"selectset.thtml");
	
    $templates->set_var('site_url', $_CONF['site_url']);
    $templates->set_var('site_admin_url', $_CONF['site_admin_url']);
	
    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);
    $templates->set_var('gltoken_name', CSRF_TOKEN);
    $templates->set_var('gltoken', $token);
    $templates->set_var ( 'xhtml', XHTML );

    $templates->set_var('script', THIS_SCRIPT);

	//fieldset_id
	$fieldset_id=0;
	$templates->set_var('lang_fieldset', $LANG_DATABOX_ADMIN['fieldset']);
	$list_fieldset=DATABOX_getoptionlist("fieldset",$fieldset_id,0,$pi_name,"",0 );
	$templates->set_var ('list_fieldset', $list_fieldset);
	
	$templates->set_var ('lang_inst_newdata', $LANG_DATABOX_ADMIN['inst_newdata']);
	
    $templates->set_var ('lang_new', $LANG_DATABOX_ADMIN['new']);
    $templates->set_var('lang_cancel', $LANG_ADMIN['cancel']);

	$templates->parse('output', 'editor');
    $retval .= $templates->finish($templates->get_var('output'));
    $retval .= COM_endBlock (COM_getBlockTemplate ('_admin_block', 'footer'));
	
	return $retval;
}


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
}else if (($mode == $LANG_DATABOX_ADMIN['new']) && !empty ($LANG_DATABOX_ADMIN['new'])) {
    $mode="newedit";
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

//
$menuno=2;
$display="";
$information = array();

//ログイン要否チェック
if (COM_isAnonUser()){
    $loginrequired=$_DATABOX_CONF['loginrequired'];
    $loginrequired=$_CONF['loginrequired'];

    if ($loginrequired>0) {
        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }

}



//echo "mode=".$mode."<br>";
switch ($mode) {

    case 'new':// 新規登録
        if ($_DATABOX_CONF['allow_data_insert']
                OR SEC_hasRights('databox.submit')){

            $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['new'];
            $display .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
            $display .= fncNew();
            break;
        }
    case 'newedit':// 新規登録
        if ($_DATABOX_CONF['allow_data_insert']
                OR SEC_hasRights('databox.submit')){

            $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['new'];
            $display .=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
            $display .= fncEdit("", $edt_flg,$msg);
            break;
        }
    case 'save':// 保存
		$display.=ppNavbarjp($navbarMenu,$LANG_ASSIST_admin_menu[$menuno]);
        $retval= fncSave ($edt_flg ,$navbarMenu ,$menuno);
        $information['pagetitle']=$retval['title'];
		$display.=$retval['display'];
		break;

    case 'delete':// 削除
        $display .= fncdelete();
        break;
    case 'copy'://コピー
        if ($_DATABOX_CONF['allow_data_insert']
                OR SEC_hasRights('databox.submit')){
        }else{
            $id="";
            $display.=$rt;
        }
    case 'edit':// 編集
        if ($id<>""  ) {
            $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'].$LANG_DATABOX_ADMIN['edit'];
            if ($edt_flg==FALSE){
                $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);
            }
            $rt=databox_chk_loaddata($id);
            if ($rt==="OK"){
                $display .= fncEdit($id, $edt_flg,$msg,"",$mode);
            }else{
                $display.=$rt;
            }
        }
        break;

    default:// 初期表示、一覧表示

        $information['pagetitle']=$LANG_DATABOX_ADMIN['piname'];
        if (isset ($msg)) {
            $display .= COM_showMessage ($msg,'databox');
        }
        $display.=ppNavbarjp($navbarMenu,$LANG_DATABOX_admin_menu[$menuno]);

        $display .= fncList();


}

$display=DATABOX_displaypage($pi_name,'_admin',$display,$information);


COM_output($display);

?>
