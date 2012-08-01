<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | DataBox Plugin 0.0.0 for Geeklog 1.8 and later                            |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// | Authors    : Tsuchi            - tsuchi AT geeklog DOT jp                 |
// | Authors    : Tetsuko Komma/Ivy - komma AT ivywe DOT co DOT jp             |
// +---------------------------------------------------------------------------+

###############################################################################
# plugins/databox/language/english.php

###############################################################################
## Admin menu
$LANG_DATABOX_admin_menu = array();
$LANG_DATABOX_admin_menu['1']= 'Informations';
$LANG_DATABOX_admin_menu['2']= 'Data';
$LANG_DATABOX_admin_menu['3']= 'Attributes';
$LANG_DATABOX_admin_menu['31']= 'Attributes Sets';
$LANG_DATABOX_admin_menu['4']= 'Categories';
$LANG_DATABOX_admin_menu['5']= 'Groups';
$LANG_DATABOX_admin_menu['6']= 'Backup and Restore';
//
$LANG_DATABOX_admin_menu['8']= 'Proversion';


## User画面
$LANG_DATABOX_user_menu = array();
$LANG_DATABOX_user_menu['2']= 'My Data';


###############################################################################
$LANG_DATABOX = array();
$LANG_DATABOX['list']="List";
$LANG_DATABOX['selectit']="None selected";

$LANG_DATABOX['data'] = 'Data';
$LANG_DATABOX['mydata'] = 'My Data';

$LANG_DATABOX['Norecentnew'] = 'New data is none.';
$LANG_DATABOX['nohit'] = 'No hits';
$LANG_DATABOX['nopermission'] = 'No Permissions';

$LANG_DATABOX['more'] = 'More';
$LANG_DATABOX['day'] = "{$_CONF['shortdate']}";

$LANG_DATABOX['home']="Home";
$LANG_DATABOX['view']="View";
$LANG_DATABOX['count']="Count";
$LANG_DATABOX['category_top']="Categories Top";
$LANG_DATABOX['field_top']="Attributes Top";
$LANG_DATABOX['search_link']="";

//$LANG_DATABOX['category_separater']="</li><li>";
$LANG_DATABOX['category_separater']="、";
$LANG_DATABOX['category_separater_text']="、";

$LANG_DATABOX['loginrequired'] = 'Login Required';

$LANG_DATABOX['lastmodified'] = '%B/%e/%Y Updated';
$LANG_DATABOX['lastcreated'] = '%B/%e/%Y Created';
$LANG_DATABOX['deny_msg'] =  'No data or no Permissions.';

###############################################################################
# admin/plugins/

$LANG_DATABOX_ADMIN['piname'] = 'DataBox';

# Admin start block title
$LANG_DATABOX_ADMIN['admin_list'] = 'DataBox';

$LANG_DATABOX_ADMIN['edit'] = 'Edit';
$LANG_DATABOX_ADMIN['ref'] = 'Refference';
$LANG_DATABOX_ADMIN['view'] = 'View';

$LANG_DATABOX_ADMIN['new'] = 'New';
$LANG_DATABOX_ADMIN['drafton'] = 'Draft On All';
$LANG_DATABOX_ADMIN['draftoff'] = 'Draft Off All';
$LANG_DATABOX_ADMIN['export'] = 'Export';
$LANG_DATABOX_ADMIN['import'] = 'Import';

$LANG_DATABOX_ADMIN['importfile'] = 'Path';
$LANG_DATABOX_ADMIN['importurl'] = 'URL';

$LANG_DATABOX_ADMIN['delete'] = 'Delete';
$LANG_DATABOX_ADMIN['deletemsg_user'] = "Delete all.<br {xhtml}>";

$LANG_DATABOX_ADMIN['idfrom'] = "From ID";
$LANG_DATABOX_ADMIN['idto'] = "To ID";

$LANG_DATABOX_ADMIN['mail1'] = 'Send';
$LANG_DATABOX_ADMIN['mail2'] = 'Setteing';

$LANG_DATABOX_ADMIN['submit'] = 'Submit';

//
$LANG_DATABOX_ADMIN['link_admin'] = 'Admin:';
$LANG_DATABOX_ADMIN['link_admin_top'] = 'Admin TOP';
$LANG_DATABOX_ADMIN['link_public'] = '|Public';
$LANG_DATABOX_ADMIN['link_list'] = 'List';
$LANG_DATABOX_ADMIN['link_detail'] = 'Detail';



//
$LANG_DATABOX_ADMIN['id'] = 'ID';
$LANG_DATABOX_ADMIN['help_id'] ="
";

$LANG_DATABOX_ADMIN['seq'] = 'SEQ';

$LANG_DATABOX_ADMIN['tag'] = 'TAG';
$LANG_DATABOX_ADMIN['value'] = 'VALUE';

$LANG_DATABOX_ADMIN['code']='Code';

$LANG_DATABOX_ADMIN['title']='Title';
$LANG_DATABOX_ADMIN['page_title']='PageTitle';

$LANG_DATABOX_ADMIN['description']='説明';
$LANG_DATABOX_ADMIN['defaulttemplatesdirectory']='TemplatesPath';

$LANG_DATABOX_ADMIN['category']='Category';

$LANG_DATABOX_ADMIN['meta_description']='説明文 メタタグ';

$LANG_DATABOX_ADMIN['meta_keywords']='キーワード メタタグ';

$LANG_DATABOX_ADMIN['hits']='閲覧数';

$LANG_DATABOX_ADMIN['comments']='コメント数';

$LANG_DATABOX_ADMIN['commentcode']='コメント';

$LANG_DATABOX_ADMIN['comment_expire']='コメント停止日時';

$LANG_DATABOX_ADMIN['group']='Group';
$LANG_DATABOX_ADMIN['parent']='親';

$LANG_DATABOX_ADMIN['fieldset']='AddributesSets';
$LANG_DATABOX_ADMIN['fieldset_id']="AddributesSetsID";
$LANG_DATABOX_ADMIN['fieldsetfields']="Addributesリスト";
$LANG_DATABOX_ADMIN['fieldlist']="追加AddributesList";
$LANG_DATABOX_ADMIN['fieldsetlist']='AddributesSetsList';

$LANG_DATABOX_ADMIN['allow_display']='Display制限(一般画面)';
$LANG_DATABOX_ADMIN['allow_edit']='編集制限(User用編集画面)';

$LANG_DATABOX_ADMIN['type']=' Type';

$LANG_DATABOX_ADMIN['size']='Size( text )';
$LANG_DATABOX_ADMIN['maxlength']='maxlength( text )';
$LANG_DATABOX_ADMIN['rows']='rows(Multi line text )';
$LANG_DATABOX_ADMIN['br']='BR(Radio button)';

//
$LANG_DATABOX_ADMIN['language_id']="言語ID";
$LANG_DATABOX_ADMIN['owner_id']="OwnerID";
$LANG_DATABOX_ADMIN['group_id']="GroupID";
$LANG_DATABOX_ADMIN['perm_owner']="Permission(Owner)";
$LANG_DATABOX_ADMIN['perm_group']="Permission(Group)";;
$LANG_DATABOX_ADMIN['perm_members']="Permission(メンバ)";
$LANG_DATABOX_ADMIN['perm_anon']="Permission(Guest)";
//

$LANG_DATABOX_ADMIN['selection']='選択肢';
$LANG_DATABOX_ADMIN['selectlist']='既定リスト';
$LANG_DATABOX_ADMIN['checkrequried']='必須チェック';

$LANG_DATABOX_ADMIN['draft'] = 'Draft';//'下書';
$LANG_DATABOX_ADMIN['uid'] = 'UserID';
$LANG_DATABOX_ADMIN['modified'] = '編集日付';
$LANG_DATABOX_ADMIN['created'] = '作成日付';
$LANG_DATABOX_ADMIN['released'] = '公開日';
$LANG_DATABOX_ADMIN['expired'] = '公開終了日';

$LANG_DATABOX_ADMIN['udatetime'] = 'タイムスタンプ';
$LANG_DATABOX_ADMIN['uuid'] = '更新User';

//@@@@@-->
$LANG_DATABOX_ADMIN['inpreparation'] = '(準備中)';
$LANG_DATABOX_ADMIN['xml_def'] = 'XML定義';
$LANG_DATABOX_ADMIN['init'] = '初期化';
$LANG_DATABOX_ADMIN['list'] = 'List';
$LANG_DATABOX_ADMIN['dataclear'] = 'Dataクリア';
$LANG_DATABOX_ADMIN['allclear'] = 'ALL クリア';

$LANG_DATABOX_ADMIN['path'] = 'Absoluteパス';
$LANG_DATABOX_ADMIN['url'] = 'URL';

$LANG_DATABOX_ADMIN['default'] = 'Default';
$LANG_DATABOX_ADMIN['importmsg'] = '
Absoluteパス(フォルダ、File)またはURL 指定してください。<{XHTML}br>
フォルダ指定 時は、フォルダ下 xmlFile Importします。<{XHTML}br>
logs/databox_xmlimport.log にログが記録されます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['exportmsg'] = '
Absoluteパス(フォルダ) 指定してください。<{XHTML}br>
logs/databox_xmlimport.log にログが記録されます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['initmsg'] = '
proversion  初期化します。「List」 内容はDeleteされます。
';
$LANG_DATABOX_ADMIN['dataclearmsg'] = '
Backupはとりましたか？<{XHTML}br>
Data クリアします。<{XHTML}br>
UploadされたFileもDeleteされます。<{XHTML}br>
追加Addributes、Category、GroupDeleteされません。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['allclearmsg'] = '
Backupはとりましたか？<{XHTML}br>
マスタおよびData クリアします。<{XHTML}br>
UploadされたFileもDeleteされます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['backupmsg'] = 
"{$_CONF['backup_path']}"."databox/に<{XHTML}br>"
.'DataBox  DataベースData Backupします。<{XHTML}br>
UploadFileは別途Backupしてください。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['restoremsg'] = 
"{$_CONF['backup_path']}"."databox/にある"
.'File名 指定してください。(省略時databox.xml)<{XHTML}br>
DataBox  DataベースData リストアします。<{XHTML}br>
UploadFileは別途もどしてください。<{XHTML}br>
';
//<---

$LANG_DATABOX_ADMIN['yy'] = '年';
$LANG_DATABOX_ADMIN['mm'] = '月';
$LANG_DATABOX_ADMIN['dd'] = '日';

$LANG_DATABOX_ADMIN['must'] = '* Required';

$LANG_DATABOX_ADMIN['enabled'] = 'Enabled';
$LANG_DATABOX_ADMIN['modified_autoupdate'] = 'Auto upddated';

$LANG_DATABOX_ADMIN['additionfields'] = 'Add Addributes';
$LANG_DATABOX_ADMIN['basicfields'] = 'Basic Addributes';

$LANG_DATABOX_ADMIN['category_id'] = 'Category ID';
$LANG_DATABOX_ADMIN['field_id'] = 'Add Addributes ID';
$LANG_DATABOX_ADMIN['name'] = 'Name';
$LANG_DATABOX_ADMIN['templatesetvar'] = 'Theme Variable';
$LANG_DATABOX_ADMIN['templatesetvars'] = '  Theme Variable';
$LANG_DATABOX_ADMIN['parent_id'] = 'Parent ID';
$LANG_DATABOX_ADMIN['parent_flg'] = 'Parent Group？';

$LANG_DATABOX_ADMIN['orderno'] = 'Order';

$LANG_DATABOX_ADMIN['field'] = 'Attribute';
$LANG_DATABOX_ADMIN['fields'] = 'Attribute';
$LANG_DATABOX_ADMIN['content'] = 'Contents';

$LANG_DATABOX_ADMIN['byusingid'] = 'Use ID';
$LANG_DATABOX_ADMIN['byusingcode'] = 'Use Code';
$LANG_DATABOX_ADMIN['byusingtemplatesetvar'] = 'Use ThemeVariable';

$LANG_DATABOX_ADMIN['withlink'] = 'With Link';

$LANG_DATABOX_ADMIN['number'] ="Number";
$LANG_DATABOX_ADMIN['endmessage'] = "Finished";
//help
$LANG_DATABOX_ADMIN['delete_help_field'] = 'Data is Delete too!';
$LANG_DATABOX_ADMIN['delete_help_group'] = 'There are data. Can not delete group.';
$LANG_DATABOX_ADMIN['delete_help_category'] = 'There are data. Can not delete category and parent.';
$LANG_DATABOX_ADMIN['delete_help_fieldset'] = 'There are data. Can not delete attribute';

//xmlimport_help
$LANG_DATABOX_xmlimport['help']=
"<br{KHTML}>"
."(注！)<br{KHTML}>"
."assist DataBoxPlugin XMLBatchImportPathは、同一 場所 登録しておいてください  <br{KHTML}>"
."<br{KHTML}>"
."assist Plugin xmlImport 実行します <br{KHTML}>"
."maps:item_10 はCodeに相当内容 登録しておいてください <br{KHTML}>"
."同一Codeが既に登録済 場合は、Delete 後追加します <br{KHTML}>"
."<br{KHTML}>"
."DataBox Plugin xmlImport 実行します <br{KHTML}>"
."同一Codeが既に登録済 場合は、Delete 後追加します <br{KHTML}>"
."各々 処理が済んだら、XMLFileはDeleteします <br{KHTML}>"
."(権限によりDeleteできない場合があります) <br{KHTML}>"
."<br{KHTML}>"
."実行内容はdatabox_xmlimport.log に 記録されます<br{KHTML}>"

;
$LANG_DATABOX_ADMIN['jobend'] = '処理終了しました<br{KHTML}>';
$LANG_DATABOX_ADMIN['cnt_ok'] = '成功: %d 件<br{KHTML}>';
$LANG_DATABOX_ADMIN['cnt_ng'] = 'エラー: %d 件<br{KHTML}>';

//backup&restore
$LANG_DATABOX_ADMIN['config'] = 'Configuration';

$LANG_DATABOX_ADMIN['config_backup'] = 'Backup実行';
$LANG_DATABOX_ADMIN['config_backup_help'] = 'BackupFile 作成します';

$LANG_DATABOX_ADMIN['config_init'] = '初期化実行';
$LANG_DATABOX_ADMIN['config_init_help'] = '初期値に戻します ';

$LANG_DATABOX_ADMIN['config_restore'] = 'リストア実行';
$LANG_DATABOX_ADMIN['config_restore_help'] = 'BackupFile 内容に戻します ';

$LANG_DATABOX_ADMIN['config_update'] = '更新';
$LANG_DATABOX_ADMIN['config_update_help'] = '最新 仕様に更新します ';

$LANG_DATABOX_ADMIN['document'] = 'ドキュメント';
$LANG_DATABOX_ADMIN['configuration'] = 'ConfigurationSetting';
$LANG_DATABOX_ADMIN['autotags'] = 'Autotags';
$LANG_DATABOX_ADMIN['online'] = 'オンライン';

//Admin：こ Pageについて
$LANG_DATABOX_ADMIN['about_admin_information'] = 'Autotagsについて';
$LANG_DATABOX_ADMIN['about_admin_data'] = 'Data 管理';
$LANG_DATABOX_ADMIN['about_admin_category'] = 'Category 管理';
$LANG_DATABOX_ADMIN['about_admin_field'] = '追加Addributes 管理';
$LANG_DATABOX_ADMIN['about_admin_group'] = 'Group 管理';
$LANG_DATABOX_ADMIN['about_admin_fieldset'] = 'AddributesSets 管理';
$LANG_DATABOX_ADMIN['about_admin_backuprestore'] = 'Backup 作成とリストア<br{KHTML}><br{KHTML}>';


$LANG_DATABOX_ADMIN['about_admin_view'] = '一般LoginUserからみたPageはこ ようになります';

$LANG_DATABOX_ADMIN['inst_fieldsetfields'] = 
'Addributes 編集は、追加Addributes名 クリックして「追加」または「Delete」ボタン クリックしてください。<{XHTML}br>
追加Addributesが選択されているときは右側だけにDisplayされます。<{XHTML}br>
編集が終わったら、「Save」ボタン クリックしてください。<{XHTML}br>
Adminに戻ります。';

$LANG_DATABOX_ADMIN['inst_newdata'] = 
'Select Addributes Sets for Creat Data<{XHTML}br>
';

//ERR
$LANG_DATABOX_ADMIN['err'] = 'Error';
$LANG_DATABOX_ADMIN['err_empty'] = 'Fileがありません';

$LANG_DATABOX_ADMIN['err_invalid'] = 'Dataがありません';
$LANG_DATABOX_ADMIN['err_permission_denied'] = 'Not permitted.';

$LANG_DATABOX_ADMIN['err_id'] = 'IDis not invalid';
$LANG_DATABOX_ADMIN['err_name'] = 'Name is not invalid';
$LANG_DATABOX_ADMIN['err_templatesetvar'] = 'Theme variableis not invalid';
$LANG_DATABOX_ADMIN['err_templatesetvar_w'] = 'Theme variable is already used';
$LANG_DATABOX_ADMIN['err_code_w'] = 'こ Codeはすでに登録されています';
$LANG_DATABOX_ADMIN['err_code'] = 'Codeが入力されていません';
$LANG_DATABOX_ADMIN['err_title'] = 'Titleが入力されていません';

$LANG_DATABOX_ADMIN['err_selection'] = 'No selected';

$LANG_DATABOX_ADMIN['err_modified'] = 'Edit date is not invalid.';
$LANG_DATABOX_ADMIN['err_created'] = 'Created date is not invalid.';
$LANG_DATABOX_ADMIN['err_released'] = 'Published date is not invalid.';
$LANG_DATABOX_ADMIN['err_expired'] = 'Publish date is not invalid.';

$LANG_DATABOX_ADMIN['err_checkrequried'] = 'Check Required,';

$LANG_DATABOX_ADMIN['err_date'] = 'Date is not invalid.';//@@@@@

$LANG_DATABOX_ADMIN['err_size'] = 'Size is not invalid.';//@@@@@
$LANG_DATABOX_ADMIN['err_type'] = ' Type is not invalid.';//@@@@@

$LANG_DATABOX_ADMIN['err_field_w'] = 'This attribute is already registed';
$LANG_DATABOX_ADMIN['err_tag_w'] = 'This tag is already registed.';

$LANG_DATABOX_ADMIN['err_url'] = 'This URL is not invalid address';

$LANG_DATABOX_ADMIN['err_backup_file_not_exist'] = 'ConfigurationBackupFileがありません<br{KHTML}>';
$LANG_DATABOX_ADMIN['err_backup_file_non_rewritable'] = 'ConfigurationBackupFile書換できません<br{KHTML}>';

###############################################################################
$LANG_DATABOX_ORDER['random']="Random Order";
$LANG_DATABOX_ORDER['date']="Date Order";
$LANG_DATABOX_ORDER['orderno']="Display Order";
$LANG_DATABOX_ORDER['code']="Code Order";
$LANG_DATABOX_ORDER['title']="Title Order";
$LANG_DATABOX_ORDER['description']="Description Order";
$LANG_DATABOX_ORDER['id']="ID order";
$LANG_DATABOX_ORDER['order']="Order";

###############################################################################
##
$LANG_DATABOX_XML['base:code']=$LANG_DATABOX_ADMIN['code'];
$LANG_DATABOX_XML['base:title']=$LANG_DATABOX_ADMIN['title'];



###############################################################################
$LANG_DATABOX_MAIL['subject_data'] =
"【{$_CONF['site_name']}】Data更新 by %s";

$LANG_DATABOX_MAIL['message_data']=
"%sさん(user no.%s)によって、Dataが更新されました。".LB.LB;







$LANG_DATABOX_MAIL['subject_category'] =
"【{$_CONF['site_name']}】Category更新 by {$_USER['username']}.";

$LANG_DATABOX_MAIL['message_category']=
"Category was edited by {$_USER['username']}(user no.{$_USER['uid']}).".LB.LB;

$LANG_DATABOX_MAIL['subject_group'] =
"[{$_CONF['site_name']}] Group was edited by {$_USER['username']}.";

$LANG_DATABOX_MAIL['message_group']=
"Group was edited by {$_USER['username']}(user no.{$_USER['uid']}).".LB.LB;

$LANG_DATABOX_MAIL['subject_fieldset'] =
"【{$_CONF['site_name']}】Addributes sets was edted by {$_USER['username']}";

$LANG_DATABOX_MAIL['message_fieldset']=
"Addributes sets was updated by {$_USER['username']}(user no.{$_USER['uid']}).".LB.LB;

#
$LANG_DATABOX_MAIL['sig'] = LB
."------------------------------------".LB
."{$_CONF['site_name']}".LB
."{$_CONF['site_url']}".LB
."This is automaticaly sended.".LB
."------------------------------------".LB
;

$LANG_DATABOX_MAIL['subject_data_delete'] =
"【{$_CONF['site_name']}】DataDelete by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_data_delete']=
"Data was removed by {$_USER['username']}(user no.{$_USER['uid']}).".LB;


$LANG_DATABOX_MAIL['subject_category_delete'] =
"【{$_CONF['site_name']}】CategoryDelete by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_category_delete']=
"Category was removed by {$_USER['username']}(user no.{$_USER['uid']}).".LB;

$LANG_DATABOX_MAIL['subject_group_delete'] =
"【{$_CONF['site_name']}】GroupDelete by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_group_delete']=
"Group was removed by {$_USER['username']}(user no.{$_USER['uid']}).".LB;

$LANG_DATABOX_MAIL['subject_fieldset_delete'] =
"【{$_CONF['site_name']}】Addributes sets removed by {$_USER['username']}.";
$LANG_DATABOX_MAIL['message_fieldset_delete']=
"Addributes set was removed by {$_USER['username']}(user no.{$_USER['uid']}).".LB;

###############################################################################
#
$LANG_DATABOX_NOYES = array(
    0 => 'No',
    1 => 'Yes'
);

$LANG_DATABOX_ALLOW_DISPLAY = array();
$LANG_DATABOX_ALLOW_DISPLAY[0] ='Display(order)';
$LANG_DATABOX_ALLOW_DISPLAY[1] ='Login User Display';
$LANG_DATABOX_ALLOW_DISPLAY[2] ='Owner, Group and admin can be displayed.';
$LANG_DATABOX_ALLOW_DISPLAY[3] ='Owner, admin can be display';
$LANG_DATABOX_ALLOW_DISPLAY[4] ='admin can be display';
$LANG_DATABOX_ALLOW_DISPLAY[5] = 'Not Display';

$LANG_DATABOX_ALLOW_EDIT = array();
$LANG_DATABOX_ALLOW_EDIT[0] = 'Edit';
$LANG_DATABOX_ALLOW_EDIT[2] = 'Only Owner,Group,and admin can edit.';
$LANG_DATABOX_ALLOW_EDIT[3] = 'Owner and admin can edit.';
$LANG_DATABOX_ALLOW_EDIT[4] = 'Display Disabled';
$LANG_DATABOX_ALLOW_EDIT[5] = 'Display';


//TYPE (内容 変更Disabled)
$LANG_DATABOX_TYPE = array();
$LANG_DATABOX_TYPE[0] = '1 Line Text Attribute';
$LANG_DATABOX_TYPE[1] = 'Multi Line Text Attribute(HTML OK)';
$LANG_DATABOX_TYPE[10] = 'Multi Line Text Attribute(HTML NG)';

$LANG_DATABOX_TYPE[2] = 'No/Yes';
$LANG_DATABOX_TYPE[3] = 'Date (Date Picker)';
$LANG_DATABOX_TYPE[4] = 'Time (In preparation)';
$LANG_DATABOX_TYPE[5] = 'Mail Address';
$LANG_DATABOX_TYPE[6] = 'url';
$LANG_DATABOX_TYPE[7] = 'Option List';
$LANG_DATABOX_TYPE[8] = 'Radio Button List';
$LANG_DATABOX_TYPE[9] = 'Definition List (In preparation)';

$LANG_DATABOX_TYPE[11] = 'Image(DB Save)';
$LANG_DATABOX_TYPE[12] = 'Image(File Save)';
$LANG_DATABOX_TYPE[13] = 'File(In Preparation )';

###############################################################################
#
$LANG_DATABOX_SEARCH['type'] = 'DataBox';

$LANG_DATABOX_SEARCH['results_databox'] = 'DataBox Search Results';

$LANG_DATABOX_SEARCH['title'] =  'Title';
$LANG_DATABOX_SEARCH['udate'] =  'Update';

###############################################################################
# COM_showMessage()
$PLG_databox_MESSAGE1  = 'Saved';
$PLG_databox_MESSAGE2  = 'Deleted';
$PLG_databox_MESSAGE3  = 'Check Problem.';

// Messages for the plugin upgrade
$PLG_databox_MESSAGE3002 = $LANG32[9];

###############################################################################
#
$LANG_DATABOX_autotag_desc['databox']="
[databox:count]他 <br{xhtml}>	
More, see Databox Plugin documents.
<a href=\"{$_CONF['site_admin_url']}/plugins/databox/docs/japanese/autotags.html\">*</a>
";

###############################################################################
# configuration
// Localization of the Admin Configuration UI
$LANG_configsections['databox']['label'] = 'DataBox';
$LANG_configsections['databox']['title'] = 'DataBox Setting';

//----------
$LANG_configsubgroups['databox']['sg_main'] = 'Main';
//--(0)

$LANG_tab['databox'][tab_main] = 'MainSetting';
$LANG_fs['databox'][fs_main] = 'DataBox MainSetting';
$LANG_confignames['databox']['perpage'] = 'Date Number by Page';
$LANG_confignames['databox']['loginrequired'] = 'Login Required';
$LANG_confignames['databox']['hidemenu'] = 'Hide Menu';

$LANG_confignames['databox']['categorycode'] = 'Use Category Code ';
$LANG_confignames['databox']['datacode'] = 'Use Data Code';
$LANG_confignames['databox']['groupcode'] = 'Use Group Code';
$LANG_confignames['databox']['top'] = 'topにDisplayProgram';
$LANG_confignames['databox']['templates'] = 'Templates Public';
$LANG_confignames['databox']['templates_admin'] = 'Templates Admin';

$LANG_confignames['databox']['themespath'] = 'Theme Template Path';
$LANG_confignames['databox']['delete_data'] = 'Delete by Owner Deleted';
$LANG_confignames['databox']['datefield'] = 'Date field';

$LANG_confignames['databox']['meta_tags'] = 'Use Meta';

$LANG_confignames['databox']['layout'] = 'Layout Public';
$LANG_confignames['databox']['layout_admin'] = 'Layout Admin';
//----------------------
$LANG_confignames['databox']['mail_to'] = 'Notify Address';
$LANG_confignames['databox']['allow_data_update'] = 'Permit User Update Data';
$LANG_confignames['databox']['allow_data_delete'] = 'Permit User Delete Data';
$LANG_confignames['databox']['allow_data_insert'] = 'Permit User Insert Data';
$LANG_confignames['databox']['admin_draft_default'] = 'Admin Create New Draft Default';
$LANG_confignames['databox']['user_draft_default'] = 'User Create New as Draft Default';

$LANG_confignames['databox']['dateformat'] = 'Date Format with Date Picker';

$LANG_confignames['databox']['aftersave'] = 'After Save for Public';
$LANG_confignames['databox']['aftersave_admin'] = 'After Save for Admin';

$LANG_confignames['databox']['grp_id_default'] = 'Group Default';

$LANG_confignames['databox']['default_img_url'] = 'DefaultImageURL';

//--(1)
$LANG_tab['databox'][tab_whatsnew] = 'New Information Block';
$LANG_fs['databox'][fs_whatsnew] = 'New Information Block';
$LANG_confignames['databox']['whatsnew_interval'] = 'New  Period';
$LANG_confignames['databox']['hide_whatsnew'] = 'No New Page Display';
$LANG_confignames['databox']['title_trim_length'] = 'Title of Max Length';




//---(2)
$LANG_tab['databox'][tab_search] = 'Search';
$LANG_fs['databox'][fs_search] = 'Search Results';
$LANG_confignames['databox']['include_search'] = 'Data Search';
$LANG_confignames['databox']['additionsearch'] = 'Attributes number for Search';

//---(3)
$LANG_tab['databox'][tab_permissions] = 'Permission';
$LANG_fs['databox'][fs_permissions] = 'Data Permission Default([0]Owner [1]Group [2]Member [3]Guest)';
$LANG_confignames['databox']['default_permissions'] = 'Permission';

//---(4)
$LANG_tab['databox'][tab_autotag] = 'Autotags';
$LANG_fs['databox'][fs_autotag] = 'Autotags';
$LANG_confignames['databox']['intervalday']="Display Period(Day)";
$LANG_confignames['databox']['limitcnt']="Display Number";//@@@@@
$LANG_confignames['databox']['newmarkday']="New Mark Display Period(Day)";//@@@@@
$LANG_confignames['databox']['categories']="Default Category";//@@@@@!!!!
$LANG_confignames['databox']['new_img']="New Mark";//@@@@@
$LANG_confignames['databox']['rss_img']="RSS Mark";//@@@@@

//---(５)
$LANG_tab['databox']['tab_file'] = 'Upload File';
$LANG_fs['databox']['fs_file'] = 'Upload File';
$LANG_confignames['databox']['imgfile_size'] = 'Image File(DB) MaxSize';
$LANG_confignames['databox']['imgfile_type'] = 'Image File(DB)  Type';

$LANG_confignames['databox']['imgfile_size2'] = 'Image File Max Size';
$LANG_confignames['databox']['imgfile_type2'] = 'Image File Type';
$LANG_confignames['databox']['imgfile_frd'] = 'Image Save URL';
$LANG_confignames['databox']['imgfile_thumb_frd'] = 'Thumbnail Image Save URL';

$LANG_confignames['databox']['imgfile_thumb_ok'] = 'Use Thumbnail ';
$LANG_confignames['databox']['imgfile_thumb_w'] = 'Thumbnail Size(w)';
$LANG_confignames['databox']['imgfile_thumb_h'] = 'Thumbnail Size(h)';
$LANG_confignames['databox']['imgfile_thumb_w2'] = 'Original Image Size(w2)';
$LANG_confignames['databox']['imgfile_thumb_h2'] = 'Original Image Size(h2)';
$LANG_confignames['databox']['imgfile_smallw'] = 'Display Image Max Width';



$LANG_confignames['databox']['file_path'] = 'File Save  Absolute Address';
$LANG_confignames['databox']['file_size'] = 'File Size';
$LANG_confignames['databox']['file_type'] = 'File Type';


//---(６)
$LANG_tab['databox']['tab_autotag_permissions'] = 'Autotags Permission';
$LANG_fs['databox']['fs_autotag_permissions'] = 'Autotags Permission ([0]Owner [1]Group [2]Member [3]Guest)';
$LANG_confignames['databox']['autotag_permissions_databox'] = '[databox: ] Permission';

//---(９)
$LANG_tab['databox']['tab_xml'] = 'ProfesionalVersion';
$LANG_fs['databox']['fs_xml'] = '(Profesional Version)';
$LANG_confignames['databox']['path_xml'] = 'XML Batch Import Path';
$LANG_confignames['databox']['path_xml_out'] = 'XML Export Path';





// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['databox'][0] =array('Yes' => 1, 'No' => 0);
$LANG_configselects['databox'][1] =array('Yes' => TRUE, 'No' => FALSE);
$LANG_configselects['databox'][12] =array('AccessDisabled' => 0, 'Display' => 2, 'Display・編集' => 3);
$LANG_configselects['databox'][13] =array('AccessDisabled' => 0, 'Use' => 2);

$LANG_configselects['databox'][5] =array(
    'Hide' => 'hide'
    , 'Display By Modified Date' => 'modified'
    , 'Display By Created Date' => 'created');

//$LANG_configselects['databox'][17] =array('Access Denyed' => 0, 'Display' => 2, 'Display・編集' => 3);

$LANG_configselects['databox'][20] =array(
    'Standard' => 'standard'
    , 'Custom' => 'custom'
    , 'Theme' => 'theme');

//@@@@@
$LANG_configselects['databox'][21] =array(
     'By Modified Date' => 'modified'
    , 'By Created Date' => 'created');

$LANG_configselects['databox'][22] =array(
    'Standard' => 'standard'
    , 'Left and Right Blocks' => 'leftrightblocks'
    , 'Blank Page' => 'blankpage'
    , 'No Block' => 'noblocks'
    , 'Left Block' => 'leftblocks'
    , 'Right Block' => 'rightblocks'

    );

$LANG_configselects['databox'][23] =array(
    'Yes' => 3
    ,'List and Detail' => 2
    ,'Only Detaile' => 1
    , 'No' => 0
    );


$LANG_configselects['databox'][9] =array(
    'Same Page Display' => 'no'
    ,'Page Display' => 'item'
    , 'List Display' => 'list'
    , 'Home Display' => 'home'
    , 'AdminTop Display' => 'admin'
    , 'PluginTop Display' => 'plugin'

        );

//
$LANG_configselects['databox'][24] =array();
    $sql = LB;
    $sql .= "SELECT ".LB;
    $sql .= " grp_id".LB;
    $sql .= ",grp_name".LB;
    $sql .= " FROM {$_TABLES['groups']}".LB;
    $sql .= " ORDER BY grp_name".LB;
    $result = DB_query( $sql );
    $nrows = DB_numRows( $result );

    for( $i = 0; $i < $nrows; $i++ )    {
        $A = DB_fetchArray( $result, true );
        $grp_name=$A['grp_name'];
        $grp_id=$A['grp_id'];
        $LANG_configselects['databox'][24][$grp_name]=$grp_id;
    }

?>