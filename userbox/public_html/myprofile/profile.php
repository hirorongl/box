<?php

/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | profile maintenannce
// +---------------------------------------------------------------------------+
// $Id: profile.php
// public_html/userbox/myprofile/profile.php
// 20101129 tsuchitani AT ivywe DOT co DOT jp

//@@@@@@追加予定　メールにカテゴリ
//--------------------------------
//@@@@@@追加予定（案）
//@@@@@@最後のログイン日時（表示）
//@@@@@@ユーザ名（変更）
//@@@@@@メールアドレス（変更）
//@@@@@@ホームページ（変更）
//@@@@@@グループ（変更）
//@@@@@@居住地（変更）
//@@@@@@写真（変更）
//@@@@@@署名（変更）
//@@@@@@自己紹介（変更）
//@@@@@@PGP鍵（変更）
//@@@@@@デイリーニュースを受信するかどうか？



define ('THIS_SCRIPT', 'userbox/myprofile/profile.php');
//define ('THIS_SCRIPT', 'userbox/myprofile/test.php');

include_once('userbox_functions.php');

require_once ($_CONF['path'] . 'plugins/userbox/lib/lib_datetimeedit.php');
require_once $_CONF['path_system'] . 'lib-user.php';

//ログイン要チェック

if (empty ($_USER['username'])) {
    $page_title= $LANG_PROFILE[4];
    $display .= DATABOX_siteHeader('USERBOX','',$page_title);
    $display .= SEC_loginRequiredForm();
    $display .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
    echo $display;
    exit;
}

if ($_USERBOX_CONF['allow_profile_update']==1 ){
}else{
    if (SEC_hasRights ('userbox.edit') ){
	}else{
		COM_accessLog("User {$_USER['username']} tried to profile and failed ");
		echo COM_refresh($_CONF['site_url'] . '/index.php');
		exit;
	}
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
// 20101118
function fncEdit(
    $id
    ,$edt_flg
    ,$msg = ''
    ,$errmsg=""
    ,$mode="edit"
)
{

    $pi_name="userbox";

    global $_CONF;
    global $_TABLES;
    global $LANG_ADMIN;
    global $MESSAGE;
    global $LANG_ACCESS;
    global $_USER;
    global $LANG28;

    global $_USERBOX_CONF;
    global $LANG_USERBOX_ADMIN;

    $retval = '';

    $delflg=false;

    $addition_def=DATABOX_getadditiondef($pi_name);

    //メッセージ表示
    if (!empty ($msg)) {
        $retval .= COM_showMessage ($msg,$pi_name);
        $retval .= $errmsg;
        // clean 'em up
        $code=COM_applyFilter($_POST['code']);
        $title = COM_applyFilter($_POST['title']);
        $username=COM_applyFilter($_POST['username']);//@@@@@
        $fullname = COM_applyFilter($_POST['fullname']);//@@@@@

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
        $language_id = COM_applyFilter ($_POST['language_id']);

        $category = $_POST['category'];

        $additionfields=$_POST['afield'];
        $additionfields_fnm=$_POST['afield_fnm'];//@@@@@
        $additionfields_del=$_POST['afield_del'];
        $additionfields=DATABOX_cleanaddtiondatas
			($additionfields,$addition_def,$additionfields_fnm,$additionfields_del	);

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
        $sql = "SELECT ";
        $sql .= " t.*";
			
		$sql .= " ,UNIX_TIMESTAMP(t.modified) AS modified_un".LB;
		$sql .= " ,UNIX_TIMESTAMP(t.released) AS released_un".LB;
		$sql .= " ,UNIX_TIMESTAMP(t.comment_expire) AS comment_expire_un".LB;
		$sql .= " ,UNIX_TIMESTAMP(t.expired) AS expired_un".LB;
		$sql .= " ,UNIX_TIMESTAMP(t.udatetime) AS udatetime_un".LB;
		$sql .= " ,UNIX_TIMESTAMP(t.created) AS created_un".LB;

        $sql .= " ,t1.username";
        $sql .= " ,t1.fullname";

        $sql .= " ,unix_timestamp(modified) AS modified_u ";
        $sql .= " FROM ";
        $sql .= $_TABLES['USERBOX_base'] ." AS t";
        $sql .= ",".$_TABLES['users'] ." AS t1";

        $sql .= " WHERE ";
        $sql .= " t.id = $id";
        $sql .= " AND t.id = t1.uid";

        $result = DB_query($sql);

        $A = DB_fetchArray($result);

        $code = COM_stripslashes($A['code']);
        $title=COM_stripslashes($A['title']);
        $username = COM_stripslashes($A['username']);//@@@@@
        $fullname=COM_stripslashes($A['fullname']);//@@@@@

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

        $category = DATABOX_getdatas("category_id",$_TABLES['USERBOX_category'],"id = $id");

        //追加項目
        $additionfields = DATABOX_getadditiondatas($id,$pi_name);

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

         if ($_CONF['allow_account_delete']){
             if ($edt_flg==FALSE) {
                 $delflg=true;
             }
        }
    }


    $chk_user=DATABOX_chkuser($group_id,$owner_id,"userbox.admin");

    //-----
    $retval .= COM_startBlock ($LANG_USERBOX_ADMIN['edit'], '',
                               COM_getBlockTemplate ('_admin_block', 'header'));

    //template フォルダ
    $tmplfld=DATABOX_templatePath('myprofile','default',$pi_name);
    $templates = new Template($tmplfld);

    $templates->set_file (array (
                'editor' => 'profile_editor.thtml',
                'row'   => 'row.thtml',
                'col'   => "profile_col_detail.thtml",
            ));

    //--
    if (($_CONF['meta_tags'] > 0) && ($_USERBOX_CONF['meta_tags'] > 0)) {
        $templates->set_var('hide_meta', '');
    } else {
        $templates->set_var('hide_meta', ' style="display:none;"');
    }
    $templates->set_var('maxlength_description', $_USERBOX_CONF['maxlength_description']);

    $templates->set_var('about_thispage', $LANG_USERBOX_ADMIN['about_myprofile_profile']);
    $templates->set_var('lang_must', $LANG_USERBOX_ADMIN['must']);
    $templates->set_var('site_url', $_CONF['site_url']);
    $templates->set_var('site_admin_url', $_CONF['site_admin_url']);

    $token = SEC_createToken();
    $retval .= SEC_getTokenExpiryNotice($token);
    $templates->set_var('gltoken_name', CSRF_TOKEN);
    $templates->set_var('gltoken', $token);
    $templates->set_var ( 'xhtml', XHTML );

    $templates->set_var('script', THIS_SCRIPT);

    $templates->set_var('dateformat', $_USERBOX_CONF['dateformat']);

    //
    $templates->set_var('lang_link_admin', $LANG_USERBOX_ADMIN['link_admin']);
    $templates->set_var('lang_link_admin_top', $LANG_USERBOX_ADMIN['link_admin_top']);
    $templates->set_var('lang_link_public', $LANG_USERBOX_ADMIN['link_public']);
    $templates->set_var('lang_link_list', $LANG_USERBOX_ADMIN['link_list']);
    $templates->set_var('lang_link_detail', $LANG_USERBOX_ADMIN['link_detail']);

    //id
    $templates->set_var('lang_id', $LANG_USERBOX_ADMIN['id']);
    //@@@@@ $templates->set_var('help_id', $LANG_USERBOX_ADMIN['help']);
    $templates->set_var('id', $id);



//$LANG28 = array(
//    2 => 'ユーザID',
//    3 => 'ユーザ名', username
//    4 => '氏名', fullname
    $templates->set_var('lang_uid', $LANG28['2']);
    $templates->set_var('lang_username', $LANG28['3']);
    $templates->set_var ('username', $username);
    $templates->set_var('lang_fullname', $LANG28['4']);
    $templates->set_var ('fullname', $fullname);


    //下書
    $templates->set_var('lang_draft', $LANG_USERBOX_ADMIN['draft']);
    if  ($draft_flag==1) {
        $templates->set_var('draft_flag', "checked=checked");
    }else{
        $templates->set_var('draft_flag', "");
    }

    //
    $templates->set_var('lang_field', $LANG_USERBOX_ADMIN['field']);
    $templates->set_var('lang_fields', $LANG_USERBOX_ADMIN['fields']);
    $templates->set_var('lang_content', $LANG_USERBOX_ADMIN['content']);
    $templates->set_var('lang_templatesetvar', $LANG_USERBOX_ADMIN['templatesetvar']);

    //基本項目
    $templates->set_var('lang_basicfields', $LANG_USERBOX_ADMIN['basicfields']);
    //コード＆タイトル＆説明＆テンプレートセット値
    $templates->set_var('lang_code', $LANG_USERBOX_ADMIN['code']);
    if ($_USERBOX_CONF['datacode']){
        $templates->set_var('lang_must_code', $LANG_USERBOX_ADMIN['must']);
    }else{
        $templates->set_var('lang_must_code', "");
    }
    $templates->set_var ('code', $code);
    $templates->set_var('lang_title', $LANG_USERBOX_ADMIN['title']);
    $templates->set_var ('title', $title);
    $templates->set_var('lang_page_title', $LANG_USERBOX_ADMIN['page_title']);
    $templates->set_var ('page_title', $page_title);
    $templates->set_var('lang_description', $LANG_USERBOX_ADMIN['description']);
    $templates->set_var ('description', $description);
    $templates->set_var('lang_defaulttemplatesdirectory', $LANG_USERBOX_ADMIN['defaulttemplatesdirectory']);
    $templates->set_var ('defaulttemplatesdirectory', $defaulttemplatesdirectory);
    //meta_description
    $templates->set_var('lang_meta_description', $LANG_USERBOX_ADMIN['meta_description']);
    $templates->set_var ('meta_description', $meta_description);
	
	//language_id
    if (is_array($_CONF['languages'])) {
        $templates->set_var('hide_language_id', '');
		$select_language_id=DATABOX_getoptionlist("language_id",$language_id,0,$pi_name,"",0 );
    } else {
        $templates->set_var('hide_language_id', ' style="display:none;"');
		$select_language_id="";
    }
    $templates->set_var('lang_language_id', $LANG_USERBOX_ADMIN['language_id']);
	$templates->set_var ('language_id', $language_id);
    $templates->set_var ('select_language_id', $select_language_id);//@@@@@

    //meta_keywords
    $templates->set_var('lang_meta_keywords', $LANG_USERBOX_ADMIN['meta_keywords']);
    $templates->set_var ('meta_keywords', $meta_keywords);

    //hits
    $templates->set_var('lang_hits', $LANG_USERBOX_ADMIN['hits']);
    $templates->set_var ('hits', $hits);

    //comments
    $templates->set_var('lang_comments', $LANG_USERBOX_ADMIN['comments']);
    $templates->set_var ('comments', $comments);

    //commentcode
    $templates->set_var('lang_commentcode', $LANG_USERBOX_ADMIN['commentcode']);
    $templates->set_var ('commentcode', $commentcode);
    $optionlist_commentcode=COM_optionList ($_TABLES['commentcodes'], 'code,name',$commentcode);
    $templates->set_var ('optionlist_commentcode', $optionlist_commentcode);

    //comment_expire
    $templates->set_var('lang_enabled', $LANG_USERBOX_ADMIN['enabled']);

    if ($comment_expire_flag===0){
        $templates->set_var('show_comment_expire', 'false');
        $templates->set_var('is_checked_comment_expire', '');

    }else{
        $templates->set_var('show_comment_expire', 'true');
        $templates->set_var('is_checked_comment_expire', 'checked="checked"');
    }

    $templates->set_var('lang_comment_expire', $LANG_USERBOX_ADMIN['comment_expire']);
    $w=COM_convertDate2Timestamp(
        $comment_expire_year."-".$comment_expire_month."-".$comment_expire_day
        , $comment_expire_hour.":".$comment_expire_minute."::00"
        );
    $datetime_comment_expire=LIB_datetimeedit($w,"LANG_USERBOX_ADMIN","comment_expire");
    $templates->set_var('datetime_comment_expire', $datetime_comment_expire);

    //編集日
    $templates->set_var ('lang_modified_autoupdate', $LANG_USERBOX_ADMIN['modified_autoupdate']);
    $templates->set_var ('lang_modified', $LANG_USERBOX_ADMIN['modified']);
    $w=COM_convertDate2Timestamp(
        $modified_year."-".$modified_month."-".$modified_day
        , $modified_hour.":".$modified_minute."::00"
        );
    $datetime_modified=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","modified");
    $templates->set_var ('datetime_modified', $datetime_modified);
    //公開日
    $templates->set_var ('lang_released', $LANG_USERBOX_ADMIN['released']);
    $w=COM_convertDate2Timestamp(
        $released_year."-".$released_month."-".$released_day
        , $released_hour.":".$released_minute."::00"
        );
    $datetime_released=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","released");
    $templates->set_var ('datetime_released', $datetime_released);
    //公開終了日
    $templates->set_var ('lang_expired', $LANG_USERBOX_ADMIN['expired']);
    //if ($expired=="0000-00-00 00:00:00"){
    if ($expired_flag==0){
        $templates->set_var('show_expired', 'false');
        $templates->set_var('is_checked_expired', '');

    }else{
        $templates->set_var('show_expired', 'true');
        $templates->set_var('is_checked_expired', 'checked="expired"');
    }
    $templates->set_var('lang_expired', $LANG_USERBOX_ADMIN['expired']);
    $w=COM_convertDate2Timestamp(
        $expired_year."-".$expired_month."-".$expired_day
        , $expired_hour.":".$expired_minute."::00"
        );
    $datetime_expired=LIB_datetimeedit($w,"LANG_DATABOX_ADMIN","expired");
    $templates->set_var('datetime_expired', $datetime_expired);

    //カテゴリ
    $templates->set_var('lang_category', $LANG_USERBOX_ADMIN['category']);
    $checklist_category=DATABOX_getcheckList ("category",$category,$pi_name);
    $templates->set_var('checklist_category', $checklist_category);

    //追加項目
    $templates->set_var('lang_additionfields', $LANG_USERBOX_ADMIN['additionfields']);
    $rt=DATABOX_getaddtionfieldsEdit
        ($additionfields,$addition_def,$templates,$chk_user,$pi_name
        ,$additionfields_fnm,$additionfields_del);

    $rt=DATABOX_getaddtionfieldsJS($additionfields,$addition_def,9999,$pi_name);

    //保存日時
    $templates->set_var ('lang_udatetime', $LANG_USERBOX_ADMIN['udatetime']);
    $templates->set_var ('udatetime', $udatetime);
    $templates->set_var ('lang_uuid', $LANG_USERBOX_ADMIN['uuid']);
    $templates->set_var ('uuid', $uuid);
    //作成日付
    $templates->set_var ('lang_created', $LANG_USERBOX_ADMIN['created']);
    $templates->set_var ('created', $created);

    //アクセス権
    $templates->set_var('lang_accessrights',$LANG_ACCESS['accessrights']);
    $templates->set_var('lang_owner', $LANG_ACCESS['owner']);
    $templates->set_var ('created_un', $created_un);

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
//20110417
function fncSave (
    $edt_flg
    ,$navbarMenu
    ,$menuno
)
{

    $pi_name="userbox";

    global $_CONF;
    global $_TABLES;
    global $_USER;

    global $_USERBOX_CONF;
    global $LANG_USERBOX_ADMIN;
    global $LANG_USERBOX_user_menu;

    $addition_def=DATABOX_getadditiondef($pi_name);

    $retval = '';

    // clean 'em up
    $id = COM_applyFilter($_POST['id'],true);
    if ($id==0){
        $new_flg=true;
    }else{
        $new_flg=false;
    }

    $code = COM_applyFilter($_POST['code'],true);
    $code = addslashes (COM_checkHTML (COM_checkWords ($code)));

    $title = COM_applyFilter($_POST['title']);
    $title = addslashes (COM_checkHTML (COM_checkWords ($title)));

    $username = COM_applyFilter($_POST['username']);
    $username = addslashes (COM_checkHTML (COM_checkWords ($username)));
    $fullname = COM_applyFilter($_POST['fullname']);
    $fullname = addslashes (COM_checkHTML (COM_checkWords ($fullname)));

    $page_title = COM_applyFilter($_POST['page_title']);
    $page_title = addslashes (COM_checkHTML (COM_checkWords ($page_title)));

    $description=$_POST['description'];//COM_applyFilter($_POST['description']);
    $description=addslashes (COM_checkHTML (COM_checkWords ($description)));

	$language_id=COM_applyFilter($_POST['language_id']);
    $language_id=addslashes (COM_checkHTML (COM_checkWords ($language_id)));
	
    $category = $_POST['category'];

    //@@@@@
    $additionfields=$_POST['afield'];
    $additionfields_fnm=$_POST['afield_fnm'];
    $additionfields_del=$_POST['afield_del'];

	$additionfields=DATABOX_cleanaddtiondatas
		($additionfields,$addition_def,$additionfields_fnm,$additionfields_del);

    //-----
    $type=1;
    $uuid=$_USER['uid'];


    // CHECK　はじめ
    $err="";
    //id
    if ($id==0 ){
        //$err.=$LANG_USERBOX_ADMIN['err_uid']."<br/>".LB;
    }else{
        if (!is_numeric($id) ){
            $err.=$LANG_USERBOX_ADMIN['err_id']."<br/>".LB;
        }
	}
	
	//説明必須
	if ($_USERBOX_CONF['descriptionemptycheck']==1){
		if (empty($description)){
			$err.=$LANG_USERBOX_ADMIN['err_description']."<br/>".LB;
		}
	}
	//文字数制限チェック
	if (mb_strlen($description, 'UTF-8')>$_USERBOX_CONF['maxlength_description']) {
		$err.=$LANG_USERBOX_ADMIN['description']
				.$_USERBOX_CONF['maxlength_description']
				.$LANG_USERBOX_ADMIN['err_maxlength']."<br/>".LB;
	}

    //----追加項目チェック
    $err.=databox_checkaddtiondatas
        ($additionfields,$addition_def,$pi_name,$additionfields_fnm,$additionfields_del);


    //errorのあるとき
    if ($err<>"") {
        $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['edit'];
        $retval .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
        $retval .=ppNavbarjp($navbarMenu,$LANG_USERBOX_user_menu[$menuno]);
        $retval .= fncEdit($id, $edt_flg,3,$err);
        $retval .= DATABOX_siteFooter($pi_name,'_admin');

        return $retval;

    }
    // CHECK　おわり

    //-----
    // 新規登録時
    if ($new_flg){
       $w=DB_getItem($_TABLES['USERBOX_base'],"max(id)","1=1");
        if ($w=="") {
            $w=0;
        }
        $id=$w+1;
    }

    $fields=LB."id";
    $values=LB."$id";


    if ($new_flg){

        if  ($_USERBOX_CONF['datacode']){
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

        //---
        $meta_description = "";
        $meta_keywords = "";
        $owner_id =$_USER['uid'];
        $group_id =SEC_getFeatureGroup('userbox.admin', $_USER['uid']);


        $array = array();
        SEC_setDefaultPermissions($array, $_USERBOX_CONF['default_perm']);
        $perm_owner = $array['perm_owner'];
        $perm_group = $array['perm_group'];
        $perm_anon = $array['perm_anon'];
        $perm_members = $array['perm_members'];

        $draft_flag=$_USERBOX_CONF['user_draft_default'];

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

        $comments=0;

        $fields.=",page_title";//
        $values.=",'$page_title'";

        $fields.=",description";//
        $values.=",'$description'";

        $fields.=",comments";//
        $values.=",$comments";


        $fields.=",uuid";
        $values.=",$uuid";


//        if ($edt_flg){
//            $return_page=$_CONF['site_url'] . "/".THIS_SCRIPT;
//            $return_page.="?id=".$id;
//        }else{
//            $return_page=$_CONF['site_url'] . '/'.THIS_SCRIPT.'?msg=1';
//        }

        DB_save($_TABLES['USERBOX_base'],$fields,$values);
    }else{

        $sql="UPDATE {$_TABLES['USERBOX_base']} set ";
        $sql.=" page_title = '$page_title'";
        $sql.=" ,description = '$description'";
        $sql.=" ,language_id = '$language_id'";

        $sql.=",uuid='$uuid' WHERE id=$id";

        DB_query($sql);


        $sql="UPDATE ".$_TABLES['users'] ." SET ";

        $sql.=" fullname ='".$fullname."'";

        $sql.=" WHERE uid=".$id ;
        DB_query($sql);

    }

    //カテゴリ
    $rt=DATABOX_savecategorydatas($id,$category,$pi_name);

	//追加項目@@@@@
	DATABOX_uploadaddtiondatas	
        ($additionfields,$addition_def,$pi_name,$id,$additionfields_fnm,$additionfields_del);
    $rt=DATABOX_saveaddtiondatas_update($id,$additionfields,$addition_def,$pi_name);

    //user (コアのテーブル)
    $sql="UPDATE ".$_TABLES['users'] ." SET ";

    $sql.=" fullname ='".$fullname."'";

    $sql.=" WHERE uid=".$id ;
    DB_query($sql);




    $rt=fncsendmail ('data',$id);

    //exit;// debug 用

    if ($_USERBOX_CONF['aftersave']==='no'){
        $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['edit'];
        $retval .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
        $retval .=ppNavbarjp($navbarMenu,$LANG_USERBOX_user_menu[$menuno]);
        $retval .= fncEdit($id, $edt_flg,1,$err);
        $retval .= DATABOX_siteFooter($pi_name,'_admin');

        return $retval;


    }else if ($_USERBOX_CONF['aftersave']==='list'
          OR $_USERBOX_CONF['aftersave']==='admin' ){
            $item_url=COM_buildURL($_CONF['site_url'] . "/userbox/profile.php?m=id&id=".$id);
            $target='item';
    }else{
            $item_url=COM_buildURL($_CONF['site_url'] . "/userbox/profile.php?m=id&id=".$id);
            $target=$_USERBOX_CONF['aftersave'];
    }

// $return_page="";

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
    global $_USER;
	
	$pi_name="userbox";
	
    $id = COM_applyFilter($_POST['id'],true);
    $username=DB_getItem($_TABLES['users'],"username","uid={$id}");
    $email=DB_getItem($_TABLES['users'],"email","uid={$id}");
	
    // CHECK
    $err="";
    if ($err<>"") {
        $page_title=$LANG_DATABOX_ADMIN['err'];
        $retval .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
        $retval .= COM_startBlock ($LANG_USERBOX_ADMIN['err'], '',
                            COM_getBlockTemplate ('_msg_block', 'header'));
        $retval .= $err;
        $retval .= COM_endBlock (COM_getBlockTemplate ('_msg_block', 'footer'));
        $retval .= DATABOX_siteFooter($pi_name,'_admin');
        return $retval;
    }



    if (!USER_deleteAccount ($id)) {
        $return_page =$_CONF['site_url'] . '/index.php';
    }

    $return_page=$_CONF['site_url'] . '/index.php?msg=57';

    $rt=fncsendmail ('data_delete',$id,$username,$email);

    //exit;// debug 用

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
    ,$username=""
    ,$email=""
    )
{

    $pi_name="userbox";

    global $_CONF;
    global $_TABLES;
    global $LANG_USERBOX_MAIL;
    global $LANG_USERBOX_ADMIN;
    global $_USER ;
    global $_USERBOX_CONF ;
    global $LANG28;

    $retval = '';

    $site_name=$_CONF['site_name'];
    $subject= $LANG_USERBOX_MAIL['subject_'.$m];
    $message=$LANG_USERBOX_MAIL['message_'.$m];

    if ($m==="data_delete"){
        $msg.=$LANG28['2'].":".$id.LB;
        $msg.=$LANG28['3'].":".$username.LB;
        //URL
        $url=$_CONF['site_url'] . "/userbox/profile.php";
        $url = COM_buildUrl( $url );


    }else{
        $sql = "SELECT ";

        $sql .= " t1.*";
        $sql .= " ,t2.uid";
        $sql .= " ,t2.username";
        $sql .= " ,t2.fullname";
        $sql .= " ,t2.email";

        $sql .= " FROM ";
        $sql .= $_TABLES['USERBOX_base']." AS t1";
        $sql .= ",".$_TABLES['users']." AS t2";

        $sql .= " WHERE ";
        $sql .= " t1.id = $id";
        $sql .= " AND t1.id = t2.uid";

        $result = DB_query ($sql);
        $numrows = DB_numRows ($result);

        if ($numrows > 0) {

			$A = DB_fetchArray ($result);
			$A = array_map('stripslashes', $A);

            $email=$A['email'];

            //下書
            if ($A['draft_flag']==1) {
                $msg.=$LANG_USERBOX_ADMIN['draft'].LB;
            }
            //コア
            $msg.=$LANG28['2'].":".$A['uid'].LB;
            $msg.=$LANG28['3'].":".$A['username'].LB;
            $msg.=$LANG28['4'].":".$A['fullname'].LB;

            //基本項目
            $msg.= $LANG_USERBOX_ADMIN['page_title'].":".$A['page_title'].LB;
            $msg.= $LANG_USERBOX_ADMIN['description'].":".$A['description'].LB;

            //カテゴリ
            $msg.=DATABOX_getcategoriesText($id ,0,$pi_name);

            //追加項目
            $group_id = stripslashes($A['group_id']);
            $owner_id = stripslashes($A['owner_id']);
            $chk_user=DATABOX_chkuser($group_id,$owner_id,"userbox.admin");
            $addition_def=DATABOX_getadditiondef($pi_name);
            $additionfields = DATABOX_getadditiondatas($id,$pi_name);
            $msg.=DATABOX_getaddtionfieldsText($additionfields,$addition_def,$chk_user,$pi_name);

            //タイムスタンプ　更新ユーザ
            $msg.= $LANG_USERBOX_ADMIN['udatetime'].":".$A['udatetime'].LB;
            $msg.= $LANG_USERBOX_ADMIN['uuid'].":".$A['uuid'].LB;


            //URL
            $url=$_CONF['site_url'] . "/profile/profile.php";
            $url.="?";
            if ($_USERBOX_CONF['datacode']){
                $url.="m=code";
                $url.="&code=".$A['username'];
            }else{
                $url.="m=id";
                $url.="&id=".$A['id'];
            }
            $url = COM_buildUrl( $url );

        }
    }

    $message.=$msg.LB;
    $message.=$url.LB;
    $message.=$LANG_USERBOX_MAIL['sig'].LB;

    $mail_to=$_USERBOX_CONF['mail_to'];
    //--- to user
    if (array_search($email,$mail_to)===false){
        $to=$email;
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
//############################
$pi_name    = 'userbox';
//############################
$id=$_USER['uid'];


// 引数
if (isset ($_REQUEST['mode'])) {
    $mode = COM_applyFilter ($_REQUEST['mode'], false);
}
$msg = '';
if (isset ($_REQUEST['msg'])) {
    $msg = COM_applyFilter ($_REQUEST['msg'], true);
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
    OR $mode=="export" OR $mode=="import"  OR $mode=="copy" OR $mode=="desc") {
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

//echo "mode=".$mode."<br>";
switch ($mode) {

    case 'delete':// 削除
        $display .= fncdelete();
        break;

    case 'save':// 保存
        $display .= fncSave ($edt_flg,$navbarMenu,$menuno);
        break;

    default:// 初期表示、一覧表示
        if (!empty ($id) ) {
            $page_title=$LANG_USERBOX_ADMIN['piname'].$LANG_USERBOX_ADMIN['edit'];
            $display .= DATABOX_siteHeader($pi_name,'_admin',$page_title);
            if ($edt_flg==FALSE){
                $display.=ppNavbarjp($navbarMenu,$LANG_USERBOX_user_menu[$menuno]);
            }
            $display .= fncEdit($id, $edt_flg,$msg,"",$mode);
            $display .= DATABOX_siteFooter($pi_name,'_admin');

        }

}



echo $display;

?>
