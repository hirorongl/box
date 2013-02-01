<?php
//* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | UserBox Plugin 0.0.0 for Geeklog 1.7.0                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// | Authors    : Tsuchi            - tsuchi AT geeklog DOT jp                 |
// | Authors    : Tetsuko Komma/Ivy - komma AT ivywe DOT co DOT jp             |
// +---------------------------------------------------------------------------+

###############################################################################
# plugins/USERBOX/language/japanese_utf-8.php
# もし万一エンコードの種類が　UTF-8でない場合は、utf-8に変換してください。
# Last Update 20121101

###############################################################################
## 管理画面 menu
$LANG_USERBOX_admin_menu = array();
$LANG_USERBOX_admin_menu['1']= '情報';
$LANG_USERBOX_admin_menu['2']= 'プロフィール';
$LANG_USERBOX_admin_menu['3']= 'アトリビュート';
$LANG_USERBOX_admin_menu['31']= '属性セット';
$LANG_USERBOX_admin_menu['4']= 'カテゴリ';
$LANG_USERBOX_admin_menu['5']= 'グループ';
$LANG_USERBOX_admin_menu['6']= 'バックアップ＆リストア';

//
$LANG_USERBOX_admin_menu['8']= 'XML';


## ユーザ画面
$LANG_USERBOX_user_menu = array();
$LANG_USERBOX_user_menu['2']= 'マイプロフィール';
$LANG_USERBOX_user_menu['7']= 'マイグループ';

$LANG_USERBOX_user_menu['1']= 'プロフィール確認';

###############################################################################
$LANG_USERBOX_MSG = array();
$LANG_USERBOX_MSG['alluser'] = "";
$LANG_USERBOX_MSG['draftuser'] = 
 "<a href=\"{$_CONF['site_url']}/userbox/myprofile/profile.php\">"
."プロフィールを編集してください。</a>";
$LANG_USERBOX_MSG['descriptionempty'] = 
 "<a href=\"{$_CONF['site_url']}/userbox/myprofile/profile.php\">"
."プロフィールを編集してください。</a>";

###############################################################################
$LANG_USERBOX = array();
$LANG_USERBOX['list']="一覧";
$LANG_USERBOX['countlist']="別件数一覧";
$LANG_USERBOX['selectit']="指定なし";
$LANG_USERBOX['selectall']="すべて";
$LANG_USERBOX['byconfig']="コンフィギュレーション設定による";

$LANG_USERBOX['profile'] = 'プロフィール表示';
$LANG_USERBOX['myprofile'] = 'マイプロフィール';

$LANG_USERBOX['Norecentnew'] = '新しいプロフィールはありません';
$LANG_USERBOX['nohit'] = '表示可能なプロフィールはありません';
$LANG_USERBOX['nopermission'] = '閲覧できません';

$LANG_USERBOX['more'] = 'もっとみる';
$LANG_USERBOX['day'] = "{$_CONF['shortdate']}";

$LANG_USERBOX['home']="HOME";
$LANG_USERBOX['view']="表示";
$LANG_USERBOX['count']="件数";
$LANG_USERBOX['category_top']="カテゴリ別件数一覧";
$LANG_USERBOX['attribute_top']="アトリビュート別件数一覧";

$LANG_USERBOX['search_link']="";

//$LANG_USERBOX['category_separater']="</li><li>";
$LANG_USERBOX['category_separater']="、";

$LANG_USERBOX['category_separater_text']="、";

$LANG_USERBOX['loginrequired'] = '（ログインしてください）';

$LANG_USERBOX['lastmodified'] = '%Y年%B%e日更新';
$LANG_USERBOX['lastcreated'] = '%Y年%B%e日追加';

$LANG_USERBOX['deny_msg'] =  'このデータへアクセスできません。(このデータは移動したか削除されているか、あるいはアクセス権がありません。)';

###############################################################################
# admin/plugins/

$LANG_USERBOX_ADMIN['piname'] = 'UserBox';

# 管理画面　start block title
$LANG_USERBOX_ADMIN['admin_list'] = 'USERBOX';

$LANG_USERBOX_ADMIN['edit'] = '編集';
$LANG_USERBOX_ADMIN['ref'] = '参考';
$LANG_USERBOX_ADMIN['view'] = '表示確認';

$LANG_USERBOX_ADMIN['new'] = '新規登録';
$LANG_USERBOX_ADMIN['drafton'] = 'ドラフト一括オン';//'下書一括オン';
$LANG_USERBOX_ADMIN['draftoff'] = 'ドラフト一括オフ';//'下書一括オフ';
$LANG_USERBOX_ADMIN['export'] = 'エクスポート';
$LANG_USERBOX_ADMIN['import'] = 'インポート';

$LANG_USERBOX_ADMIN['delete'] = '削除';
$LANG_USERBOX_ADMIN['deletemsg_user'] = "データを一括削除します。<br{xhtml}>";

$LANG_USERBOX_ADMIN['idfrom'] = "開始ID";
$LANG_USERBOX_ADMIN['idto'] = "終了ID";

$LANG_USERBOX_ADMIN['mail1'] = '送信実行';
$LANG_USERBOX_ADMIN['mail2'] = '送信設定';


$LANG_USERBOX_ADMIN['submit'] = '実行';

//
$LANG_USERBOX_ADMIN['link_admin'] = '管理画面：';
$LANG_USERBOX_ADMIN['link_admin_top'] = '一覧管理画面TOPへ';
$LANG_USERBOX_ADMIN['link_public'] = '｜表示画面：';
$LANG_USERBOX_ADMIN['link_list'] = '一覧ページへ';
$LANG_USERBOX_ADMIN['link_detail'] = '詳細ページへ';

//
$LANG_USERBOX_ADMIN['id'] = 'ID';
$LANG_USERBOX_ADMIN['help_id'] ="
";

$LANG_USERBOX_ADMIN['code']='コード';

$LANG_USERBOX_ADMIN['title']='タイトル';
$LANG_USERBOX_ADMIN['page_title']='ページタイトル';

$LANG_USERBOX_ADMIN['description']='説明';
$LANG_USERBOX_ADMIN['defaulttemplatesdirectory']='テンプレートディレクトリ';
$LANG_USERBOX_ADMIN['layout']='レイアウト';

$LANG_USERBOX_ADMIN['category']='カテゴリ';

$LANG_USERBOX_ADMIN['meta_description']='説明文のメタタグ';

$LANG_USERBOX_ADMIN['meta_keywords']='キーワードのメタタグ';

$LANG_USERBOX_ADMIN['hits']='閲覧数';

$LANG_USERBOX_ADMIN['comments']='コメント数';

$LANG_USERBOX_ADMIN['commentcode']='コメント';

$LANG_USERBOX_ADMIN['comment_expire']='コメント停止日時';

$LANG_USERBOX_ADMIN['group']='グループ';
$LANG_USERBOX_ADMIN['parent']='親';
$LANG_USERBOX_ADMIN['fieldset']='属性セット';
$LANG_USERBOX_ADMIN['fieldset_id']="属性セットID";
$LANG_USERBOX_ADMIN['fieldsetfields']="属性リスト";
$LANG_USERBOX_ADMIN['fieldlist']="アトリビュート一覧";
$LANG_USERBOX_ADMIN['fieldsetgroups']="カテゴリグループリスト";
$LANG_USERBOX_ADMIN['grouplist']="カテゴリグループ一覧";
$LANG_USERBOX_ADMIN['fieldsetlist']='属性セット一覧';

$LANG_USERBOX_ADMIN['changeset']='属性セット変更';
$LANG_USERBOX_ADMIN['inst_changeset0']='属性セットが登録されていないデータの属性セットを変更します。<{XHTML}br>';
$LANG_USERBOX_ADMIN['inst_changesetx']='の属性セットを変更します。<{XHTML}br>';

$LANG_DATABOX_ADMIN['inst_changeset'] = 
'変更する属性セットを選択してください。<{XHTML}br>
';

$LANG_USERBOX_ADMIN['allow_display']='表示制限(一般画面)';
$LANG_USERBOX_ADMIN['allow_edit']='編集制限(ユーザ用編集画面)';


$LANG_USERBOX_ADMIN['type']='タイプ';

$LANG_USERBOX_ADMIN['size']='size（テキスト）';
$LANG_USERBOX_ADMIN['maxlength']='maxlength（テキスト）';
$LANG_USERBOX_ADMIN['rows']='rows（複数行テキスト）';
$LANG_USERBOX_ADMIN['br']='改行する（ラジオボタン）';


//
$LANG_USERBOX_ADMIN['language_id']="言語ID";
$LANG_USERBOX_ADMIN['owner_id']="所有者ID";
$LANG_USERBOX_ADMIN['group_id']="グループID";
$LANG_USERBOX_ADMIN['perm_owner']="パーミッション（所有者）";
$LANG_USERBOX_ADMIN['perm_group']="パーミッション（グループ）";;
$LANG_USERBOX_ADMIN['perm_members']="パーミッション（メンバ）";
$LANG_USERBOX_ADMIN['perm_anon']="パーミッション（ゲスト）";
//

//@@@@@
$LANG_USERBOX_ADMIN['selection']='選択肢';
$LANG_USERBOX_ADMIN['selectlist']='既定リスト';
$LANG_USERBOX_ADMIN['checkrequried']='必須チェック';


$LANG_USERBOX_ADMIN['draft'] = 'ドラフト';//'下書';
$LANG_USERBOX_ADMIN['uid'] = 'ユーザID';
$LANG_USERBOX_ADMIN['modified'] = '編集日付';
$LANG_USERBOX_ADMIN['created'] = '作成日付';
$LANG_USERBOX_ADMIN['released'] = '公開日';
$LANG_USERBOX_ADMIN['expired'] = '公開終了日';

$LANG_USERBOX_ADMIN['udatetime'] = 'タイムスタンプ';
$LANG_USERBOX_ADMIN['uuid'] = '更新ユーザ';

$LANG_USERBOX_ADMIN['yy'] = '年';
$LANG_USERBOX_ADMIN['mm'] = '月';
$LANG_USERBOX_ADMIN['dd'] = '日';

$LANG_USERBOX_ADMIN['must'] = '*必須';

$LANG_USERBOX_ADMIN['enabled'] = '有効';
$LANG_USERBOX_ADMIN['modified_autoupdate'] = '自動更新する';

$LANG_USERBOX_ADMIN['additionfields'] = 'アトリビュート';
$LANG_USERBOX_ADMIN['basicfields'] = '基本';


$LANG_USERBOX_ADMIN['category_id'] = 'カテゴリID';
$LANG_USERBOX_ADMIN['field_id'] = 'アトリビュートID';
$LANG_USERBOX_ADMIN['name'] = '名称';
$LANG_USERBOX_ADMIN['templatesetvar'] = 'テーマ変数';
$LANG_USERBOX_ADMIN['templatesetvars'] = 'テーマ変数';
$LANG_USERBOX_ADMIN['group_id'] = 'グループID';
$LANG_USERBOX_ADMIN['parent_id'] = '親ID';
$LANG_USERBOX_ADMIN['parent_flg'] = '親グループ？';
$LANG_USERBOX_ADMIN['input_type'] = '入力タイプ';


$LANG_USERBOX_ADMIN['orderno'] = '表示位置';

$LANG_USERBOX_ADMIN['field'] = 'フィールド';
$LANG_USERBOX_ADMIN['fields'] = 'フィールド';
$LANG_USERBOX_ADMIN['content'] = 'コンテンツ';

$LANG_USERBOX_ADMIN['byusingid'] = 'IDを使用する';
$LANG_USERBOX_ADMIN['byusingcode'] = 'コードを使用する';
$LANG_USERBOX_ADMIN['byusingtemplatesetvar'] = '登録したテーマ変数を使用する';

$LANG_USERBOX_ADMIN['withlink'] = 'リンク付';

//help
$LANG_USERBOX_ADMIN['delete_help_field'] = '削除するとデータも削除されます！';
$LANG_USERBOX_ADMIN['delete_help_group'] = '登録されているデータがあります。削除できません。';
$LANG_USERBOX_ADMIN['delete_help_category'] = '登録されているデータがあります。削除できません。親の変更もできません。';

//backup&restore
$LANG_USERBOX_ADMIN['config'] = 'コンフィギュレーション';

$LANG_USERBOX_ADMIN['config_backup'] = 'バックアップ実行';
$LANG_USERBOX_ADMIN['config_backup_help'] = 'バックアップファイルを作成します';

$LANG_USERBOX_ADMIN['config_init'] = '初期化実行';
$LANG_USERBOX_ADMIN['config_init_help'] = '初期値に戻します ';

$LANG_USERBOX_ADMIN['config_restore'] = 'リストア実行';
$LANG_USERBOX_ADMIN['config_restore_help'] = 'バックアップファイルの内容に戻します ';

$LANG_USERBOX_ADMIN['config_update'] = '更新';
$LANG_USERBOX_ADMIN['config_update_help'] = '最新の仕様に更新します ';

//
$LANG_USERBOX_ADMIN['document'] = 'ドキュメント';
$LANG_USERBOX_ADMIN['configuration'] = 'コンフィギュレーション設定';
$LANG_USERBOX_ADMIN['autotags'] = '自動タグ';
$LANG_USERBOX_ADMIN['online'] = 'オンライン';


//管理画面：このページについて
$LANG_USERBOX_ADMIN['about_admin_information'] = '自動タグについて';
$LANG_USERBOX_ADMIN['about_admin_profile'] = 'プロフィールの管理';
$LANG_USERBOX_ADMIN['about_admin_category'] = 'カテゴリの管理';
$LANG_USERBOX_ADMIN['about_admin_field'] = 'アトリビュートの管理';
$LANG_USERBOX_ADMIN['about_admin_group'] = 'グループの管理';
$LANG_USERBOX_ADMIN['about_admin_backuprestore'] = 'バックアップの作成とリストア';
$LANG_USERBOX_ADMIN['about_admin_view'] = '一般ログインユーザからみたページはこのようになります';

$LANG_USERBOX_ADMIN['about_myprofile_view'] = '一般ログインユーザからみたあなたのページはこのようになります';
$LANG_USERBOX_ADMIN['about_myprofile_profile'] = 'あなたのプロフィールの管理';
$LANG_USERBOX_ADMIN['about_myprofile_securitygroup'] = 'あなたの所属するグループの管理';

//ERR
$LANG_USERBOX_ADMIN['err'] = 'エラー';
$LANG_USERBOX_ADMIN['err_empty'] = 'ファイルがありません';

$LANG_USERBOX_ADMIN['err_profile'] = 'プロフィールを登録してください';

$LANG_USERBOX_ADMIN['err_id'] = 'IDが不正です';
$LANG_USERBOX_ADMIN['err_name'] = '名前が不正です';
$LANG_USERBOX_ADMIN['err_templatesetvar'] = 'テーマ変数が不正です';
$LANG_USERBOX_ADMIN['err_templatesetvar_w'] = 'テーマ変数はすでに使用されています';
$LANG_USERBOX_ADMIN['err_code_w'] = 'このコードはすでに登録されています';
$LANG_USERBOX_ADMIN['err_code'] = 'コードが入力されていません';
$LANG_USERBOX_ADMIN['err_title'] = 'タイトルが入力されていません';

$LANG_USERBOX_ADMIN['err_description'] = '説明を入力してください';

$LANG_USERBOX_ADMIN['err_selection'] = '選択肢が入力されていません';

$LANG_USERBOX_ADMIN['err_modified'] = '編集日付が不正です';
$LANG_USERBOX_ADMIN['err_created'] = '作成日付が不正です';
$LANG_USERBOX_ADMIN['err_released'] = '公開日が不正です';
$LANG_USERBOX_ADMIN['err_expired'] = '公開終了日が不正です';

$LANG_USERBOX_ADMIN['err_checkrequried'] = ' 必ず入力してください';

$LANG_USERBOX_ADMIN['err_date'] = '日付が不正です';//@@@@@

$LANG_USERBOX_ADMIN['err_size'] = 'サイズが不正です';//@@@@@
$LANG_USERBOX_ADMIN['err_type'] = 'タイプが不正です';//@@@@@

$LANG_USERBOX_ADMIN['err_url'] = 'このURLは有効なアドレスではないようです';
$LANG_USERBOX_ADMIN['err_maxlength'] = '文字以内で入力してください';

$LANG_USERBOX_ADMIN['err_backup_file_not_exist'] = 'バックアップファイルがありません';
$LANG_USERBOX_ADMIN['err_backup_file_non_rewritable'] = 'バックアップファイル書換できません';
$LANG_USERBOX_ADMIN['err_group_not_exist'] = '対象グループがありません';



###############################################################################
//$LANG28 = array(
//    2 => 'ユーザID',
//    3 => 'ユーザ名', username
//    4 => '氏名', fullname

$LANG_USERBOX_ORDER['random']="ランダム";
$LANG_USERBOX_ORDER['date']="日付順";
$LANG_USERBOX_ORDER['orderno']="表示位置順";
$LANG_USERBOX_ORDER['username']=$LANG28[3]."順";
$LANG_USERBOX_ORDER['fullname']=$LANG28[4]."順";
$LANG_USERBOX_ORDER['description']="説明順";
$LANG_USERBOX_ORDER['id']="登録順";
$LANG_USERBOX_ORDER['released']="公開日順";
$LANG_USERBOX_ORDER['order']="順";


###############################################################################
$LANG_USERBOX_MAIL['subject_regist1'] =
"【{$_CONF['site_name']}】ユーザ登録 by {$_USER['username']}";

$LANG_USERBOX_MAIL['message_regist1']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、登録されました。".LB.LB;

$LANG_USERBOX_MAIL['subject_regist2'] =
"【{$_CONF['site_name']}】ユーザ登録";

$LANG_USERBOX_MAIL['message_regist2']=
"ユーザ登録されました。".LB.LB;


$LANG_USERBOX_MAIL['subject_data'] =
"【{$_CONF['site_name']}】データ更新 by {$_USER['username']}";

$LANG_USERBOX_MAIL['message_data']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、データが更新されました。".LB.LB;

$LANG_USERBOX_MAIL['subject_category'] =
"【{$_CONF['site_name']}】カテゴリ更新 by {$_USER['username']}";

$LANG_USERBOX_MAIL['message_category']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、カテゴリが更新されました。".LB.LB;

$LANG_USERBOX_MAIL['subject_group'] =
"【{$_CONF['site_name']}】グループ更新 by {$_USER['username']}";

$LANG_USERBOX_MAIL['message_group']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、グループが更新されました。".LB.LB;

#
$LANG_USERBOX_MAIL['sig'] = LB
."------------------------------------".LB
."{$_CONF['site_name']}".LB
."{$_CONF['site_url']}".LB
."このメールは自動送信されたものです。".LB
."------------------------------------".LB
;

$LANG_USERBOX_MAIL['subject_data_delete'] =
"【{$_CONF['site_name']}】データ削除 by {$_USER['username']}";
$LANG_USERBOX_MAIL['message_data_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、データが削除されました。".LB;


$LANG_USERBOX_MAIL['subject_category_delete'] =
"【{$_CONF['site_name']}】カテゴリ削除 by {$_USER['username']}";
$LANG_USERBOX_MAIL['message_category_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、カテゴリが削除されました。".LB;

$LANG_USERBOX_MAIL['subject_group_delete'] =
"【{$_CONF['site_name']}】グループ削除 by {$_USER['username']}";
$LANG_USERBOX_MAIL['message_group_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、グループが削除されました。".LB;

###############################################################################
#
$LANG_USERBOX_NOYES = array(
    0 => 'いいえ',
    1 => 'はい'
);
$LANG_USERBOX_INPUTTYPE = array(
    0 => 'チェックボックス',
    1 => 'マルチセレクトリスト'
);
$LANG_USERBOX_ALLOW_DISPLAY = array();
$LANG_USERBOX_ALLOW_DISPLAY[0] ='表示する（orderに指定可能　一覧表示可能）';
$LANG_USERBOX_ALLOW_DISPLAY[1] ='ログインユーザのみ表示する（一覧表示可能）';
$LANG_USERBOX_ALLOW_DISPLAY[2] ='グループ(所有者含)とadmin権のある人のみ表示';
$LANG_USERBOX_ALLOW_DISPLAY[3] ='所有者とadmin権のある人のみ表示';
$LANG_USERBOX_ALLOW_DISPLAY[4] ='admin権のある人のみ表示';
$LANG_USERBOX_ALLOW_DISPLAY[5] = '表示しない';

$LANG_USERBOX_ALLOW_EDIT = array();
$LANG_USERBOX_ALLOW_EDIT[0] = '編集可';
$LANG_USERBOX_ALLOW_EDIT[2] = 'グループ(所有者含)とadmin権のある人のみ編集可';
$LANG_USERBOX_ALLOW_EDIT[3] = '所有者とadmin権のある人のみ編集可';
$LANG_USERBOX_ALLOW_EDIT[4] = '編集不可表示のみ';
$LANG_USERBOX_ALLOW_EDIT[5] = '編集表示しない';


//TYPE （内容の変更不可）
$LANG_USERBOX_TYPE = array();
$LANG_USERBOX_TYPE[0] = '一行テキストフィールド';
$LANG_USERBOX_TYPE[1] = '複数行テキストフィールド(HTML OK)';
$LANG_USERBOX_TYPE[10] = '複数行テキストフィールド(HTML NG)';

$LANG_USERBOX_TYPE[2] = 'いいえ/はい';
$LANG_USERBOX_TYPE[3] = '日付　（date picker対応）';
$LANG_USERBOX_TYPE[4] = '日時　（準備中）';
$LANG_USERBOX_TYPE[5] = 'メールアドレス';
$LANG_USERBOX_TYPE[6] = 'url';
$LANG_USERBOX_TYPE[7] = 'オプションリスト';
$LANG_USERBOX_TYPE[8] = 'ラジオボタンリスト';
$LANG_USERBOX_TYPE[9] = '既定リスト　（準備中）';
$LANG_USERBOX_TYPE[14] = 'マルチセレクトリスト　（準備中）';

$LANG_USERBOX_TYPE[11] = '画像（DB保存）';
$LANG_USERBOX_TYPE[12] = '画像（ファイル保存）';
$LANG_USERBOX_TYPE[13] = '添付ファイル（準備中）';


###############################################################################
#
$LANG_USERBOX_SEARCH['type'] = 'UserBox';

$LANG_USERBOX_SEARCH['results_userbox'] = 'UserBoxの検索結果';

$LANG_USERBOX_SEARCH['title'] =  'ユーザ名';
$LANG_USERBOX_SEARCH['udate'] =  '更新日';

###############################################################################
# COM_showMessage()
$PLG_userbox_MESSAGE1  = '保存されました。';
$PLG_userbox_MESSAGE2  = '削除されました。';
$PLG_userbox_MESSAGE3  = '問題を確認してください。';

// Messages for the plugin upgrade
$PLG_userbox_MESSAGE3002 = $LANG32[9];











###############################################################################
#
$LANG_USERBOX_autotag_desc['userbox']="
[userbox:count]他 <br{xhtml}>	
詳細は、userboxプラグインのドキュメントを参照してください。
<a href=\"{$_CONF['site_admin_url']}/plugins/userbox/docs/japanese/autotags.html\">*</a>
";


###############################################################################
# configuration
// Localization of the Admin Configuration UI
$LANG_configsections['userbox']['label'] = 'UserBox';
$LANG_configsections['userbox']['title'] = 'UserBoxの設定';

//----------
$LANG_configsubgroups['userbox']['sg_main'] = 'メイン';
//--(0)
$LANG_tab['userbox'][tab_main] = 'メイン設定';
$LANG_fs['userbox'][fs_main] = 'UserBoxのメイン設定';
$LANG_confignames['userbox']['perpage'] = 'ページあたりのデータ数';
$LANG_confignames['userbox']['loginrequired'] = 'ログイン要求する';
$LANG_confignames['userbox']['hidemenu'] = 'メニューに表示しない';

$LANG_confignames['userbox']['categorycode'] = 'カテゴリ　コードを使用する';
$LANG_confignames['userbox']['datacode'] = 'データ　コードを使用する';
$LANG_confignames['userbox']['groupcode'] = 'グループ　コードを使用する';
$LANG_confignames['userbox']['top'] = 'topに表示するプログラム';
$LANG_confignames['userbox']['templates'] = 'テンプレート　一般画面';
$LANG_confignames['userbox']['templates_admin'] = 'テンプレート 管理画面';

$LANG_confignames['userbox']['themespath'] = 'テーマテンプレートパス';
$LANG_confignames['userbox']['delete_data'] = '所有者の削除と共に削除する';
$LANG_confignames['userbox']['datefield'] = '使用する日付';

$LANG_confignames['userbox']['meta_tags'] = 'メタタグを使用する';

$LANG_confignames['userbox']['layout'] = 'レイアウト 一般画面';
$LANG_confignames['userbox']['layout_admin'] = 'レイアウト管理画面';
$LANG_confignames['userbox']['mail_to'] = '更新通知先メールアドレス';
$LANG_confignames['userbox']['mail_to_owner'] = 'ユーザに更新を通知する';
$LANG_confignames['userbox']['mail_to_draft'] = '下書データの更新を通知する';

$LANG_confignames['userbox']['user_draft_default'] = 'ユーザ新規登録のドラフトのデフォルト';
$LANG_confignames['userbox']['dateformat'] = '日付書式　datepicker用';

$LANG_confignames['userbox']['aftersave'] = '保存後の画面遷移 一般画面';
$LANG_confignames['userbox']['aftersave_admin'] = '保存後の画面遷移 管理画面';

$LANG_confignames['userbox']['grp_id_default'] = 'グループのデフォルト';

$LANG_confignames['userbox']['allow_profile_update'] = 'ユーザにプロフィールの更新を許可する';
$LANG_confignames['userbox']['allow_group_update'] = 'ユーザにマイグループの更新を許可する';
$LANG_confignames['userbox']['allow_loggedinusers'] = 'ログインユーザを登録する';
$LANG_confignames['userbox']['default_img_url'] = 'デフォルト画像URL';
$LANG_confignames['userbox']['descriptionemptycheck'] = '説明未登録チェック';

$LANG_confignames['userbox']['maxlength_description'] = '入力制限文字数　説明';
$LANG_confignames['userbox']['maxlength_meta_description'] = '入力制限文字数　説明文のメタタグ';
$LANG_confignames['userbox']['maxlength_meta_keywords'] = '入力制限文字数　キーワードのメタタグ';

//--(1)
$LANG_tab['userbox'][tab_whatsnew] = '新着情報ブロック';
$LANG_fs['userbox'][fs_whatsnew] = '新着情報ブロック';
$LANG_confignames['userbox']['whatsnew_interval'] = '新着の期間';
$LANG_confignames['userbox']['hide_whatsnew'] = '新着ページを表示しない';
$LANG_confignames['userbox']['title_trim_length'] = 'タイトル最大長';

//---(2)
$LANG_tab['userbox'][tab_search] = '検索';

$LANG_fs['userbox'][fs_search] = '検索結果';
$LANG_confignames['userbox']['include_search'] = 'データを検索する';
$LANG_confignames['userbox']['additionsearch'] = '検索対象にする追加属性の数';

//---(3)
$LANG_tab['userbox'][tab_permissions] = 'パーミッション';
$LANG_fs['userbox'][fs_permissions] = 'データのパーミッションのデフォルト（[0]所有者 [1]グループ [2]メンバー [3]ゲスト）';
$LANG_confignames['userbox']['default_permissions'] = 'パーミッション';

//---(4)
$LANG_tab['userbox'][tab_autotag] = '自動タグ';
$LANG_fs['userbox'][fs_autotag] = '自動タグ';
$LANG_confignames['userbox']['intervalday']="表示期間（日）";
$LANG_confignames['userbox']['limitcnt']="表示件数";//@@@@@
$LANG_confignames['userbox']['newmarkday']="新着マーク表示期間（日）";//@@@@@
$LANG_confignames['userbox']['categories']="デフォルトカテゴリ";//@@@@@!!!!
$LANG_confignames['userbox']['new_img']="新着マーク";//@@@@@
$LANG_confignames['userbox']['rss_img']="RSSマーク";//@@@@@

//---(５)
$LANG_tab['userbox']['tab_file'] = 'アップロードファイル';

$LANG_fs['userbox']['fs_file'] = 'アップロードファイル';
$LANG_confignames['userbox']['imgfile_size'] = 'イメージファイルの最大サイズ';
$LANG_confignames['userbox']['imgfile_type'] = 'イメージファイルのタイプ';
$LANG_confignames['userbox']['imgfile_size2'] = 'イメージファイル(外部)の最大サイズ';
$LANG_confignames['userbox']['imgfile_type2'] = 'イメージファイル(外部)のタイプ';
$LANG_confignames['userbox']['imgfile_frd'] = '画像保存URL';
$LANG_confignames['userbox']['imgfile_thumb_frd'] = 'サムネイル画像保存URL';

$LANG_confignames['userbox']['imgfile_thumb_ok'] = 'サムネイルを使用する？';
$LANG_confignames['userbox']['imgfile_thumb_w'] = 'サムネイルを作成する大きさ（w）';
$LANG_confignames['userbox']['imgfile_thumb_h'] = 'サムネイルを作成する大きさ（h）';
$LANG_confignames['userbox']['imgfile_thumb_w2'] = 'サムネイルリンク先画像の大きさ（w2）';
$LANG_confignames['userbox']['imgfile_thumb_h2'] = 'サムネイルリンク先画像の大きさ（h2）';
$LANG_confignames['userbox']['imgfile_smallw'] = '表示する画像の最大横幅';

$LANG_confignames['userbox']['file_path'] = 'ファイル保存  絶対アドレス';
$LANG_confignames['userbox']['file_size'] = 'ファイルサイズ';
$LANG_confignames['userbox']['file_type'] = 'ファイルタイプ';
//---(６)
$LANG_tab['userbox']['tab_autotag_permissions'] = '自動タグのパーミッション';
$LANG_fs['userbox']['fs_autotag_permissions'] = '自動タグのパーミッション （[0]所有者 [1]グループ [2]メンバー [3]ゲスト）';
$LANG_confignames['userbox']['autotag_permissions_userbox'] = '[userbox: ] パーミッション';

//---(９)
$LANG_tab['userbox']['tab_xml'] = 'profesional版';
$LANG_fs['userbox']['fs_xml'] = 'XML　（profesional版）';
$LANG_confignames['userbox']['path_xml'] = 'XML一括インポートディレクトリ';
$LANG_confignames['userbox']['path_xml_out'] = 'XMLエクスポートディレクトリ';

// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['userbox'][0] =array('はい' => 1, 'いいえ' => 0);
$LANG_configselects['userbox'][1] =array('はい' => TRUE, 'いいえ' => FALSE);
$LANG_configselects['userbox'][12] =array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3);
$LANG_configselects['userbox'][13] =array('アクセス不可' => 0, '利用する' => 2);
$LANG_configselects['userbox'][5] =array(
    '表示しない' => 'hide'
    , '編集日付によって表示する' => 'modified'
	, '作成日付によって表示する' => 'created'
	, '公開日によって表示する' => 'released'
);

//$LANG_configselects['userbox'][17] =array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3);

$LANG_configselects['userbox'][20] =array(
    '標準' => 'standard'
    , 'カスタム' => 'custom'
    , 'テーマ' => 'theme');

//@@@@@
$LANG_configselects['userbox'][21] =array(
     '編集日付による' => 'modified'
	, '作成日付による' => 'created'
	, '公開日による' => 'released'
);

$LANG_configselects['userbox'][22] =array(
    'ヘッダ・フッタ・左ブロックあり（右ブロックはテーマ設定による）' => 'standard'
    , 'ヘッダ・フッタ・左右ブロックあり' => 'leftrightblocks'
    , '全画面表示（ヘッダ・フッタ・ブロックなし）' => 'blankpage'
    , 'ヘッダ・フッタあり（ブロックなし）' => 'noblocks'
    , 'ヘッダ・フッタ・左ブロックあり（右ブロックなし）' => 'leftblocks'
    , 'ヘッダ・フッタ・右ブロックあり（左ブロックなし）' => 'rightblocks'
    );

$LANG_configselects['userbox'][23] =array(
    'はい' => 3
    ,'一覧と詳細' => 2
    ,'詳細のみ' => 1
    , 'いいえ' => 0
    );


$LANG_configselects['userbox'][9] =array(
    '画面遷移なし' => 'no'
    , 'ページを表示する' => 'item'
    , 'リストを表示する' => 'list'
    , 'ホームを表示する' => 'home'
    , '管理画面トップを表示する' => 'admin'
    , 'プラグイントップを表示する' => 'plugin'
        );
$LANG_configselects['userbox'][25] =array(
    '画面遷移なし' => 'no'
    , 'ページを表示する' => 'item'
    , 'リストを表示する' => 'list'
    , 'ホームを表示する' => 'home'
    , 'プラグイントップを表示する' => 'plugin'
        );

//
$LANG_configselects['userbox'][24] =array();
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
        $LANG_configselects['userbox'][24][$grp_name]=$grp_id;
    }

?>