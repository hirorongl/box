<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// | DataBox Plugin 0.0.0 for Geeklog 1.8.0                                    |
// +---------------------------------------------------------------------------+
// | Copyright (C) 2010 by the following authors:                              |
// | Authors    : Tsuchi            - tsuchi AT geeklog DOT jp                 |
// | Authors    : Tetsuko Komma/Ivy - komma AT ivywe DOT co DOT jp             |
// +---------------------------------------------------------------------------+

###############################################################################
# plugins/databox/language/japanese_utf-8.php
# もし万一エンコードの種類が　UTF-8でない場合は、utf-8に変換してください。
# Last Update 20120730

###############################################################################
## 管理画面 menu
$LANG_DATABOX_admin_menu = array();
$LANG_DATABOX_admin_menu['1']= '情報';
$LANG_DATABOX_admin_menu['2']= 'データ';
$LANG_DATABOX_admin_menu['3']= '追加属性';
$LANG_DATABOX_admin_menu['31']= '属性セット';
$LANG_DATABOX_admin_menu['4']= 'カテゴリ';
$LANG_DATABOX_admin_menu['5']= 'グループ';
$LANG_DATABOX_admin_menu['6']= 'バックアップ＆リストア';
//
$LANG_DATABOX_admin_menu['8']= 'Proversion';


## ユーザ画面
$LANG_DATABOX_user_menu = array();
$LANG_DATABOX_user_menu['2']= 'マイデータ';


###############################################################################
$LANG_DATABOX = array();
$LANG_DATABOX['list']="一覧";
$LANG_DATABOX['selectit']="指定なし";

$LANG_DATABOX['data'] = 'データ表示';
$LANG_DATABOX['mydata'] = 'マイデータ';

$LANG_DATABOX['Norecentnew'] = '新しいデータはありません';
$LANG_DATABOX['nohit'] = '該当データはありません';
$LANG_DATABOX['nopermission'] = '閲覧できません';

$LANG_DATABOX['more'] = 'もっとみる';
$LANG_DATABOX['day'] = "{$_CONF['shortdate']}";

$LANG_DATABOX['home']="HOME";
$LANG_DATABOX['view']="表示";
$LANG_DATABOX['count']="件数";
$LANG_DATABOX['category_top']="カテゴリ別件数一覧";
$LANG_DATABOX['field_top']="属性別件数一覧";
$LANG_DATABOX['search_link']="";

//$LANG_DATABOX['category_separater']="</li><li>";
$LANG_DATABOX['category_separater']="、";
$LANG_DATABOX['category_separater_text']="、";

$LANG_DATABOX['loginrequired'] = '（ログインしてください）';

$LANG_DATABOX['lastmodified'] = '%Y年%B%e日更新';
$LANG_DATABOX['lastcreated'] = '%Y年%B%e日追加';
$LANG_DATABOX['deny_msg'] =  'このデータへアクセスできません。(このデータは移動したか削除されているか、あるいはアクセス権がありません。)';

###############################################################################
# admin/plugins/

$LANG_DATABOX_ADMIN['piname'] = 'DataBox';

# 管理画面　start block title
$LANG_DATABOX_ADMIN['admin_list'] = 'DataBox';

$LANG_DATABOX_ADMIN['edit'] = '編集';
$LANG_DATABOX_ADMIN['ref'] = '参考';
$LANG_DATABOX_ADMIN['view'] = '表示確認';

$LANG_DATABOX_ADMIN['new'] = '新規登録';
$LANG_DATABOX_ADMIN['drafton'] = 'ドラフト一括オン';//'下書一括オン';
$LANG_DATABOX_ADMIN['draftoff'] = 'ドラフト一括オフ';//'下書一括オフ';
$LANG_DATABOX_ADMIN['export'] = 'エクスポート';
$LANG_DATABOX_ADMIN['import'] = 'インポート';

$LANG_DATABOX_ADMIN['importfile'] = 'パス';
$LANG_DATABOX_ADMIN['importurl'] = 'URL';

$LANG_DATABOX_ADMIN['delete'] = '削除';
$LANG_DATABOX_ADMIN['deletemsg_user'] = "データを一括削除します。<br {xhtml}>";

$LANG_DATABOX_ADMIN['idfrom'] = "開始ID";
$LANG_DATABOX_ADMIN['idto'] = "終了ID";

$LANG_DATABOX_ADMIN['mail1'] = '送信実行';
$LANG_DATABOX_ADMIN['mail2'] = '送信設定';

$LANG_DATABOX_ADMIN['submit'] = '実行';

//
$LANG_DATABOX_ADMIN['link_admin'] = '管理画面：';
$LANG_DATABOX_ADMIN['link_admin_top'] = '一覧管理画面TOPへ';
$LANG_DATABOX_ADMIN['link_public'] = '｜表示画面：';
$LANG_DATABOX_ADMIN['link_list'] = '一覧ページへ';
$LANG_DATABOX_ADMIN['link_detail'] = '詳細ページへ';



//
$LANG_DATABOX_ADMIN['id'] = 'ID';
$LANG_DATABOX_ADMIN['help_id'] ="
";

$LANG_DATABOX_ADMIN['seq'] = 'SEQ';

$LANG_DATABOX_ADMIN['tag'] = 'TAG';
$LANG_DATABOX_ADMIN['value'] = 'VALUE';

$LANG_DATABOX_ADMIN['code']='コード';

$LANG_DATABOX_ADMIN['title']='タイトル';
$LANG_DATABOX_ADMIN['page_title']='ページタイトル';

$LANG_DATABOX_ADMIN['description']='説明';
$LANG_DATABOX_ADMIN['defaulttemplatesdirectory']='テンプレートディレクトリ';

$LANG_DATABOX_ADMIN['category']='カテゴリ';

$LANG_DATABOX_ADMIN['meta_description']='説明文のメタタグ';

$LANG_DATABOX_ADMIN['meta_keywords']='キーワードのメタタグ';

$LANG_DATABOX_ADMIN['hits']='閲覧数';

$LANG_DATABOX_ADMIN['comments']='コメント数';

$LANG_DATABOX_ADMIN['commentcode']='コメント';

$LANG_DATABOX_ADMIN['comment_expire']='コメント停止日時';

$LANG_DATABOX_ADMIN['group']='グループ';
$LANG_DATABOX_ADMIN['parent']='親';

$LANG_DATABOX_ADMIN['fieldset']='属性セット';
$LANG_DATABOX_ADMIN['fieldset_id']="属性セットID";
$LANG_DATABOX_ADMIN['fieldsetfields']="属性リスト";
$LANG_DATABOX_ADMIN['fieldlist']="追加属性一覧";
$LANG_DATABOX_ADMIN['fieldsetlist']='属性セット一覧';

$LANG_DATABOX_ADMIN['changeset']='属性セット変更';
$LANG_DATABOX_ADMIN['inst_changeset0']='属性セットが登録されていないデータの属性セットを変更します。<{XHTML}br>';
$LANG_DATABOX_ADMIN['inst_changesetx']='の属性セットを変更します。<{XHTML}br>';

$LANG_DATABOX_ADMIN['inst_changeset'] = 
'変更する属性セットを選択してください。<{XHTML}br>
';


$LANG_DATABOX_ADMIN['allow_display']='表示制限(一般画面)';
$LANG_DATABOX_ADMIN['allow_edit']='編集制限(ユーザ用編集画面)';

$LANG_DATABOX_ADMIN['type']='タイプ';

$LANG_DATABOX_ADMIN['size']='size（テキスト）';
$LANG_DATABOX_ADMIN['maxlength']='maxlength（テキスト）';
$LANG_DATABOX_ADMIN['rows']='rows（複数行テキスト）';
$LANG_DATABOX_ADMIN['br']='改行する（ラジオボタン）';

//
$LANG_DATABOX_ADMIN['language_id']="言語ID";
$LANG_DATABOX_ADMIN['owner_id']="所有者ID";
$LANG_DATABOX_ADMIN['group_id']="グループID";
$LANG_DATABOX_ADMIN['perm_owner']="パーミッション（所有者）";
$LANG_DATABOX_ADMIN['perm_group']="パーミッション（グループ）";;
$LANG_DATABOX_ADMIN['perm_members']="パーミッション（メンバ）";
$LANG_DATABOX_ADMIN['perm_anon']="パーミッション（ゲスト）";
//

$LANG_DATABOX_ADMIN['selection']='選択肢';
$LANG_DATABOX_ADMIN['selectlist']='既定リスト';
$LANG_DATABOX_ADMIN['checkrequried']='必須チェック';

$LANG_DATABOX_ADMIN['draft'] = 'ドラフト';//'下書';
$LANG_DATABOX_ADMIN['uid'] = 'ユーザID';
$LANG_DATABOX_ADMIN['modified'] = '編集日付';
$LANG_DATABOX_ADMIN['created'] = '作成日付';
$LANG_DATABOX_ADMIN['released'] = '公開日';
$LANG_DATABOX_ADMIN['expired'] = '公開終了日';

$LANG_DATABOX_ADMIN['udatetime'] = 'タイムスタンプ';
$LANG_DATABOX_ADMIN['uuid'] = '更新ユーザ';

//@@@@@-->
$LANG_DATABOX_ADMIN['inpreparation'] = '(準備中)';
$LANG_DATABOX_ADMIN['xml_def'] = 'XML定義';
$LANG_DATABOX_ADMIN['init'] = '初期化';
$LANG_DATABOX_ADMIN['list'] = '一覧';
$LANG_DATABOX_ADMIN['dataclear'] = 'データクリア';
$LANG_DATABOX_ADMIN['allclear'] = 'ALL クリア';

$LANG_DATABOX_ADMIN['path'] = '絶対パス';
$LANG_DATABOX_ADMIN['url'] = 'URL';

$LANG_DATABOX_ADMIN['default'] = 'デフォルト';
$LANG_DATABOX_ADMIN['importmsg'] = '
絶対パス（フォルダ、ファイル）またはURLを指定してください。<{XHTML}br>
フォルダ指定の時は、フォルダ下のxmlファイルをインポートします。<{XHTML}br>
logs/databox_xmlimport.log　にログが記録されます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['exportmsg'] = '
絶対パス（フォルダ）を指定してください。<{XHTML}br>
logs/databox_xmlimport.log　にログが記録されます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['initmsg'] = '
proversion を初期化します。「一覧」の内容は削除されます。
';
$LANG_DATABOX_ADMIN['dataclearmsg'] = '
バックアップはとりましたか？<{XHTML}br>
データをクリアします。<{XHTML}br>
アップロードされたファイルも削除されます。<{XHTML}br>
追加属性、カテゴリ、グループ削除されません。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['allclearmsg'] = '
バックアップはとりましたか？<{XHTML}br>
マスタおよびデータをクリアします。<{XHTML}br>
アップロードされたファイルも削除されます。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['backupmsg'] = 
"{$_CONF['backup_path']}"."databox/に<{XHTML}br>"
.'DataBox のデータベースデータをバックアップします。<{XHTML}br>
アップロードファイルは別途バックアップしてください。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['restoremsg'] = 
"{$_CONF['backup_path']}"."databox/にある"
.'ファイル名を指定してください。（省略時databox.xml）<{XHTML}br>
DataBox のデータベースデータをリストアします。<{XHTML}br>
アップロードファイルは別途もどしてください。<{XHTML}br>
';
$LANG_DATABOX_ADMIN['restoremsgPHP'] = 
"{$_CONF['backup_path']}"."databox/にある"
.'ファイル名を指定してください。（省略時databox.xml）<{XHTML}br>
phpMyAdmin でエキスポートしたDataBox のデータベースデータをリストアします。<{XHTML}br>
phpMyAdmin XML Dump version 3.3.8用<{XHTML}br>
接頭子が異なる場合は、あらかじめ変換しておいてください。<{XHTML}br>
アップロードファイルは別途もどしてください。<{XHTML}br>
';
//<---

$LANG_DATABOX_ADMIN['yy'] = '年';
$LANG_DATABOX_ADMIN['mm'] = '月';
$LANG_DATABOX_ADMIN['dd'] = '日';

$LANG_DATABOX_ADMIN['must'] = '*必須';

$LANG_DATABOX_ADMIN['enabled'] = '有効';
$LANG_DATABOX_ADMIN['modified_autoupdate'] = '自動更新する';

$LANG_DATABOX_ADMIN['additionfields'] = '追加属性';
$LANG_DATABOX_ADMIN['basicfields'] = '基本属性';

$LANG_DATABOX_ADMIN['category_id'] = 'カテゴリID';
$LANG_DATABOX_ADMIN['field_id'] = '追加属性ID';
$LANG_DATABOX_ADMIN['name'] = '名称';
$LANG_DATABOX_ADMIN['templatesetvar'] = 'テーマ変数';
$LANG_DATABOX_ADMIN['templatesetvars'] = '  テーマ変数';
$LANG_DATABOX_ADMIN['parent_id'] = '親ID';
$LANG_DATABOX_ADMIN['parent_flg'] = '親グループ？';

$LANG_DATABOX_ADMIN['orderno'] = '表示位置';

$LANG_DATABOX_ADMIN['field'] = 'フィールド';
$LANG_DATABOX_ADMIN['fields'] = 'フィールド';
$LANG_DATABOX_ADMIN['content'] = 'コンテンツ';

$LANG_DATABOX_ADMIN['byusingid'] = 'IDを使用する';
$LANG_DATABOX_ADMIN['byusingcode'] = 'コードを使用する';
$LANG_DATABOX_ADMIN['byusingtemplatesetvar'] = '登録したテーマ変数を使用する';

$LANG_DATABOX_ADMIN['withlink'] = 'リンク付';

$LANG_DATABOX_ADMIN['number'] ="件";
$LANG_DATABOX_ADMIN['endmessage'] = "処理終了しました";
//help
$LANG_DATABOX_ADMIN['delete_help_field'] = '削除するとデータも削除されます！';
$LANG_DATABOX_ADMIN['delete_help_group'] = '登録されているデータがあります。削除できません。';
$LANG_DATABOX_ADMIN['delete_help_category'] = '登録されているデータがあります。削除できません。親の変更もできません。';
$LANG_DATABOX_ADMIN['delete_help_fieldset'] = '登録されているデータがあります。削除できません。';

//xmlimport_help
$LANG_DATABOX_xmlimport['help']=
"<br{KHTML}>"
."(注！)<br{KHTML}>"
."assist DataBoxプラグインのXML一括インポートディレクトリは、同一の場所を登録しておいてください  <br{KHTML}>"
."<br{KHTML}>"
."assist プラグインのxmlインポートを実行します <br{KHTML}>"
."maps:item_10 はコードに相当する内容を登録しておいてください <br{KHTML}>"
."同一コードが既に登録済の場合は、削除の後追加します <br{KHTML}>"
."<br{KHTML}>"
."DataBox プラグインのxmlインポートを実行します <br{KHTML}>"
."同一コードが既に登録済の場合は、削除の後追加します <br{KHTML}>"
."各々の処理が済んだら、XMLファイルは削除します <br{KHTML}>"
."(権限により削除できない場合があります） <br{KHTML}>"
."<br{KHTML}>"
."実行内容はdatabox_xmlimport.log に 記録されます<br{KHTML}>"

;
$LANG_DATABOX_ADMIN['jobend'] = '処理終了しました<br{KHTML}>';
$LANG_DATABOX_ADMIN['cnt_ok'] = '成功: %d 件<br{KHTML}>';
$LANG_DATABOX_ADMIN['cnt_ng'] = 'エラー: %d 件<br{KHTML}>';

//backup&restore
$LANG_DATABOX_ADMIN['config'] = 'コンフィギュレーション';

$LANG_DATABOX_ADMIN['config_backup'] = 'バックアップ実行';
$LANG_DATABOX_ADMIN['config_backup_help'] = 'バックアップファイルを作成します';

$LANG_DATABOX_ADMIN['config_init'] = '初期化実行';
$LANG_DATABOX_ADMIN['config_init_help'] = '初期値に戻します ';

$LANG_DATABOX_ADMIN['config_restore'] = 'リストア実行';
$LANG_DATABOX_ADMIN['config_restore_help'] = 'バックアップファイルの内容に戻します ';

$LANG_DATABOX_ADMIN['config_update'] = '更新';
$LANG_DATABOX_ADMIN['config_update_help'] = '最新の仕様に更新します ';

$LANG_DATABOX_ADMIN['document'] = 'ドキュメント';
$LANG_DATABOX_ADMIN['configuration'] = 'コンフィギュレーション設定';
$LANG_DATABOX_ADMIN['autotags'] = '自動タグ';
$LANG_DATABOX_ADMIN['online'] = 'オンライン';

//管理画面：このページについて
$LANG_DATABOX_ADMIN['about_admin_information'] = '自動タグについて';
$LANG_DATABOX_ADMIN['about_admin_data'] = 'データの管理';
$LANG_DATABOX_ADMIN['about_admin_category'] = 'カテゴリの管理';
$LANG_DATABOX_ADMIN['about_admin_field'] = '追加属性の管理';
$LANG_DATABOX_ADMIN['about_admin_group'] = 'グループの管理';
$LANG_DATABOX_ADMIN['about_admin_fieldset'] = '属性セットの管理';
$LANG_DATABOX_ADMIN['about_admin_backuprestore'] = 'バックアップの作成とリストア<br{KHTML}><br{KHTML}>';


$LANG_DATABOX_ADMIN['about_admin_view'] = '一般ログインユーザからみたページはこのようになります';

$LANG_DATABOX_ADMIN['inst_fieldsetfields'] = 
'属性の編集は、追加属性名をクリックして「追加」または「削除」ボタンをクリックしてください。<{XHTML}br>
追加属性が選択されているときは右側だけに表示されます。<{XHTML}br>
編集が終わったら、「保存」ボタンをクリックしてください。<{XHTML}br>
管理画面に戻ります。';

$LANG_DATABOX_ADMIN['inst_newdata'] = 
'新規登録するデータの属性セットを選択してください。<{XHTML}br>
';


//ERR
$LANG_DATABOX_ADMIN['err'] = 'エラー';
$LANG_DATABOX_ADMIN['err_empty'] = 'ファイルがありません';

$LANG_DATABOX_ADMIN['err_invalid'] = 'データがありません';
$LANG_DATABOX_ADMIN['err_permission_denied'] = '許可されていません';

$LANG_DATABOX_ADMIN['err_id'] = 'IDが不正です';
$LANG_DATABOX_ADMIN['err_name'] = '名前が不正です';
$LANG_DATABOX_ADMIN['err_templatesetvar'] = 'テーマ変数が不正です';
$LANG_DATABOX_ADMIN['err_templatesetvar_w'] = 'テーマ変数はすでに使用されています';
$LANG_DATABOX_ADMIN['err_code_w'] = 'このコードはすでに登録されています';
$LANG_DATABOX_ADMIN['err_code'] = 'コードが入力されていません';
$LANG_DATABOX_ADMIN['err_title'] = 'タイトルが入力されていません';

$LANG_DATABOX_ADMIN['err_selection'] = '選択肢が入力されていません';

$LANG_DATABOX_ADMIN['err_modified'] = '編集日付が不正です';
$LANG_DATABOX_ADMIN['err_created'] = '作成日付が不正です';
$LANG_DATABOX_ADMIN['err_released'] = '公開日が不正です';
$LANG_DATABOX_ADMIN['err_expired'] = '公開終了日が不正です';

$LANG_DATABOX_ADMIN['err_checkrequried'] = ' 必ず入力してください';

$LANG_DATABOX_ADMIN['err_date'] = '日付が不正です';//@@@@@

$LANG_DATABOX_ADMIN['err_size'] = 'サイズが不正です';//@@@@@
$LANG_DATABOX_ADMIN['err_type'] = 'タイプが不正です';//@@@@@

$LANG_DATABOX_ADMIN['err_field_w'] = '当フィールドはすでに登録されています';
$LANG_DATABOX_ADMIN['err_tag_w'] = '当タグはすでに登録されています';

$LANG_DATABOX_ADMIN['err_url'] = 'このURLは有効なアドレスではないようです';

$LANG_DATABOX_ADMIN['err_backup_file_not_exist'] = 'コンフィギュレーションバックアップファイルがありません<br{KHTML}>';
$LANG_DATABOX_ADMIN['err_backup_file_non_rewritable'] = 'コンフィギュレーションバックアップファイル書換できません<br{KHTML}>';

$LANG_DATABOX_ADMIN['err_not_exist'] = '存在しません';

###############################################################################
$LANG_DATABOX_ORDER['random']="ランダム";
$LANG_DATABOX_ORDER['date']="日付順";
$LANG_DATABOX_ORDER['orderno']="表示位置順";
$LANG_DATABOX_ORDER['code']="コード順";
$LANG_DATABOX_ORDER['title']="タイトル順";
$LANG_DATABOX_ORDER['description']="説明順";
$LANG_DATABOX_ORDER['id']="登録順";
$LANG_DATABOX_ORDER['order']="順";

###############################################################################
##
$LANG_DATABOX_XML['base:code']=$LANG_DATABOX_ADMIN['code'];
$LANG_DATABOX_XML['base:title']=$LANG_DATABOX_ADMIN['title'];



###############################################################################
$LANG_DATABOX_MAIL['subject_data'] =
"【{$_CONF['site_name']}】データ更新 by %s";

$LANG_DATABOX_MAIL['message_data']=
"%sさん(user no.%s)によって、データが更新されました。".LB.LB;







$LANG_DATABOX_MAIL['subject_category'] =
"【{$_CONF['site_name']}】カテゴリ更新 by {$_USER['username']}";

$LANG_DATABOX_MAIL['message_category']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、カテゴリが更新されました。".LB.LB;

$LANG_DATABOX_MAIL['subject_group'] =
"【{$_CONF['site_name']}】グループ更新 by {$_USER['username']}";

$LANG_DATABOX_MAIL['message_group']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、グループが更新されました。".LB.LB;

$LANG_DATABOX_MAIL['subject_fieldset'] =
"【{$_CONF['site_name']}】属性セット更新 by {$_USER['username']}";

$LANG_DATABOX_MAIL['message_fieldset']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、属性セットが更新されました。".LB.LB;

#
$LANG_DATABOX_MAIL['sig'] = LB
."------------------------------------".LB
."{$_CONF['site_name']}".LB
."{$_CONF['site_url']}".LB
."このメールは自動送信されたものです。".LB
."------------------------------------".LB
;

$LANG_DATABOX_MAIL['subject_data_delete'] =
"【{$_CONF['site_name']}】データ削除 by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_data_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、データが削除されました。".LB;


$LANG_DATABOX_MAIL['subject_category_delete'] =
"【{$_CONF['site_name']}】カテゴリ削除 by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_category_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、カテゴリが削除されました。".LB;

$LANG_DATABOX_MAIL['subject_group_delete'] =
"【{$_CONF['site_name']}】グループ削除 by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_group_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、グループが削除されました。".LB;

$LANG_DATABOX_MAIL['subject_fieldset_delete'] =
"【{$_CONF['site_name']}】属性セット削除 by {$_USER['username']}";
$LANG_DATABOX_MAIL['message_fieldset_delete']=
"{$_USER['username']}さん(user no.{$_USER['uid']})によって、属性セットが削除されました。".LB;

###############################################################################
#
$LANG_DATABOX_NOYES = array(
    0 => 'いいえ',
    1 => 'はい'
);

$LANG_DATABOX_ALLOW_DISPLAY = array();
$LANG_DATABOX_ALLOW_DISPLAY[0] ='表示する（orderに指定可能）';
$LANG_DATABOX_ALLOW_DISPLAY[1] ='ログインユーザのみ表示する';
$LANG_DATABOX_ALLOW_DISPLAY[2] ='グループ(所有者含)とadmin権のある人のみ表示';
$LANG_DATABOX_ALLOW_DISPLAY[3] ='所有者とadmin権のある人のみ表示';
$LANG_DATABOX_ALLOW_DISPLAY[4] ='admin権のある人のみ表示';
$LANG_DATABOX_ALLOW_DISPLAY[5] = '表示しない';

$LANG_DATABOX_ALLOW_EDIT = array();
$LANG_DATABOX_ALLOW_EDIT[0] = '編集可';
$LANG_DATABOX_ALLOW_EDIT[2] = 'グループ(所有者含)とadmin権のある人のみ編集可';
$LANG_DATABOX_ALLOW_EDIT[3] = '所有者とadmin権のある人のみ編集可';
$LANG_DATABOX_ALLOW_EDIT[4] = '編集不可表示のみ';
$LANG_DATABOX_ALLOW_EDIT[5] = '編集表示しない';


//TYPE （内容の変更不可）
$LANG_DATABOX_TYPE = array();
$LANG_DATABOX_TYPE[0] = '一行テキストフィールド';
$LANG_DATABOX_TYPE[1] = '複数行テキストフィールド(HTML OK)';
$LANG_DATABOX_TYPE[10] = '複数行テキストフィールド(HTML NG)';

$LANG_DATABOX_TYPE[2] = 'いいえ/はい';
$LANG_DATABOX_TYPE[3] = '日付　（date picker対応）';
$LANG_DATABOX_TYPE[4] = '日時　（準備中）';
$LANG_DATABOX_TYPE[5] = 'メールアドレス';
$LANG_DATABOX_TYPE[6] = 'url';
$LANG_DATABOX_TYPE[7] = 'オプションリスト';
$LANG_DATABOX_TYPE[8] = 'ラジオボタンリスト';
$LANG_DATABOX_TYPE[9] = '既定リスト　（準備中）';

$LANG_DATABOX_TYPE[11] = '画像（DB保存）';
$LANG_DATABOX_TYPE[12] = '画像（ファイル保存）';
$LANG_DATABOX_TYPE[13] = '添付ファイル（準備中）';

###############################################################################
#
$LANG_DATABOX_SEARCH['type'] = 'DataBox';

$LANG_DATABOX_SEARCH['results_databox'] = 'DataBoxの検索結果';

$LANG_DATABOX_SEARCH['title'] =  'タイトル';
$LANG_DATABOX_SEARCH['udate'] =  '更新日';

###############################################################################
# COM_showMessage()
$PLG_databox_MESSAGE1  = '保存されました。';
$PLG_databox_MESSAGE2  = '削除されました。';
$PLG_databox_MESSAGE3  = '問題を確認してください。';

// Messages for the plugin upgrade
$PLG_databox_MESSAGE3002 = $LANG32[9];

###############################################################################
#
$LANG_DATABOX_autotag_desc['databox']="
[databox:count]他 <br{xhtml}>	
詳細は、databoxプラグインのドキュメントを参照してください。
<a href=\"{$_CONF['site_admin_url']}/plugins/databox/docs/japanese/autotags.html\">*</a>
";

###############################################################################
# configuration
// Localization of the Admin Configuration UI
$LANG_configsections['databox']['label'] = 'DataBox';
$LANG_configsections['databox']['title'] = 'DataBoxの設定';

//----------
$LANG_configsubgroups['databox']['sg_main'] = 'メイン';
//--(0)

$LANG_tab['databox'][tab_main] = 'メイン設定';
$LANG_fs['databox'][fs_main] = 'DataBoxのメイン設定';
$LANG_confignames['databox']['perpage'] = 'ページあたりのデータ数';
$LANG_confignames['databox']['loginrequired'] = 'ログイン要求する';
$LANG_confignames['databox']['hidemenu'] = 'メニューに表示しない';

$LANG_confignames['databox']['categorycode'] = 'カテゴリ　コードを使用する';
$LANG_confignames['databox']['datacode'] = 'データ　コードを使用する';
$LANG_confignames['databox']['groupcode'] = 'グループ　コードを使用する';
$LANG_confignames['databox']['top'] = 'topに表示するプログラム';
$LANG_confignames['databox']['templates'] = 'テンプレート　一般画面';
$LANG_confignames['databox']['templates_admin'] = 'テンプレート 管理画面';

$LANG_confignames['databox']['themespath'] = 'テーマテンプレートパス';
$LANG_confignames['databox']['delete_data'] = '所有者の削除と共に削除する';
$LANG_confignames['databox']['datefield'] = '使用する日付';

$LANG_confignames['databox']['meta_tags'] = 'メタタグを使用する';

$LANG_confignames['databox']['layout'] = 'レイアウト 一般画面';
$LANG_confignames['databox']['layout_admin'] = 'レイアウト 管理画面';
//----------------------
$LANG_confignames['databox']['mail_to'] = '更新通知先メールアドレス';
$LANG_confignames['databox']['mail_to_owner'] = '所有者に更新を通知する';
$LANG_confignames['databox']['mail_to_draft'] = '下書データの更新を通知する';
$LANG_confignames['databox']['allow_data_update'] = 'ユーザに更新を許可する';
$LANG_confignames['databox']['allow_data_delete'] = 'ユーザに削除を許可する';
$LANG_confignames['databox']['allow_data_insert'] = 'ユーザに新規登録を許可する';
$LANG_confignames['databox']['admin_draft_default'] = '管理者新規登録のドラフトのデフォルト';
$LANG_confignames['databox']['user_draft_default'] = 'ユーザ新規登録のドラフトのデフォルト';

$LANG_confignames['databox']['dateformat'] = '日付書式　datepicker用';

$LANG_confignames['databox']['aftersave'] = '保存後の画面遷移 一般画面';
$LANG_confignames['databox']['aftersave_admin'] = '保存後の画面遷移 管理画面';

$LANG_confignames['databox']['grp_id_default'] = 'グループのデフォルト';

$LANG_confignames['databox']['default_img_url'] = 'デフォルト画像URL';

//--(1)
$LANG_tab['databox'][tab_whatsnew] = '新着情報ブロック';
$LANG_fs['databox'][fs_whatsnew] = '新着情報ブロック';
$LANG_confignames['databox']['whatsnew_interval'] = '新着の期間';
$LANG_confignames['databox']['hide_whatsnew'] = '新着ページを表示しない';
$LANG_confignames['databox']['title_trim_length'] = 'タイトル最大長';




//---(2)
$LANG_tab['databox'][tab_search] = '検索';
$LANG_fs['databox'][fs_search] = '検索結果';
$LANG_confignames['databox']['include_search'] = 'データを検索する';
$LANG_confignames['databox']['additionsearch'] = '検索対象にする追加属性の数';

//---(3)
$LANG_tab['databox'][tab_permissions] = 'パーミッション';
$LANG_fs['databox'][fs_permissions] = 'データのパーミッションのデフォルト（[0]所有者 [1]グループ [2]メンバー [3]ゲスト）';
$LANG_confignames['databox']['default_permissions'] = 'パーミッション';

//---(4)
$LANG_tab['databox'][tab_autotag] = '自動タグ';
$LANG_fs['databox'][fs_autotag] = '自動タグ';
$LANG_confignames['databox']['intervalday']="表示期間（日）";
$LANG_confignames['databox']['limitcnt']="表示件数";//@@@@@
$LANG_confignames['databox']['newmarkday']="新着マーク表示期間（日）";//@@@@@
$LANG_confignames['databox']['categories']="デフォルトカテゴリ";//@@@@@!!!!
$LANG_confignames['databox']['new_img']="新着マーク";//@@@@@
$LANG_confignames['databox']['rss_img']="RSSマーク";//@@@@@

//---(５)
$LANG_tab['databox']['tab_file'] = 'アップロードファイル';
$LANG_fs['databox']['fs_file'] = 'アップロードファイル';
$LANG_confignames['databox']['imgfile_size'] = 'イメージファイル(DB)の最大サイズ';
$LANG_confignames['databox']['imgfile_type'] = 'イメージファイル(DB)のタイプ';

$LANG_confignames['databox']['imgfile_size2'] = 'イメージファイル(外部)の最大サイズ';
$LANG_confignames['databox']['imgfile_type2'] = 'イメージファイル(外部)のタイプ';
$LANG_confignames['databox']['imgfile_frd'] = '画像保存URL';
$LANG_confignames['databox']['imgfile_thumb_frd'] = 'サムネイル画像保存URL';

$LANG_confignames['databox']['imgfile_thumb_ok'] = 'サムネイルを使用する？';
$LANG_confignames['databox']['imgfile_thumb_w'] = 'サムネイルを作成する大きさ（w）';
$LANG_confignames['databox']['imgfile_thumb_h'] = 'サムネイルを作成する大きさ（h）';
$LANG_confignames['databox']['imgfile_thumb_w2'] = 'サムネイルリンク先画像の大きさ（w2）';
$LANG_confignames['databox']['imgfile_thumb_h2'] = 'サムネイルリンク先画像の大きさ（h2）';
$LANG_confignames['databox']['imgfile_smallw'] = '表示する画像の最大横幅';



$LANG_confignames['databox']['file_path'] = 'ファイル保存  絶対アドレス';
$LANG_confignames['databox']['file_size'] = 'ファイルサイズ';
$LANG_confignames['databox']['file_type'] = 'ファイルタイプ';


//---(６)
$LANG_tab['databox']['tab_autotag_permissions'] = '自動タグのパーミッション';
$LANG_fs['databox']['fs_autotag_permissions'] = '自動タグのパーミッション （[0]所有者 [1]グループ [2]メンバー [3]ゲスト）';
$LANG_confignames['databox']['autotag_permissions_databox'] = '[databox: ] パーミッション';

//---(９)
$LANG_tab['databox']['tab_xml'] = 'profesional版';
$LANG_fs['databox']['fs_xml'] = '（profesional版）';
$LANG_confignames['databox']['path_xml'] = 'XML一括インポートディレクトリ';
$LANG_confignames['databox']['path_xml_out'] = 'XMLエキスポートディレクトリ';





// Note: entries 0, 1, 9, 12, 17 are the same as in $LANG_configselects['Core']
$LANG_configselects['databox'][0] =array('はい' => 1, 'いいえ' => 0);
$LANG_configselects['databox'][1] =array('はい' => TRUE, 'いいえ' => FALSE);
$LANG_configselects['databox'][12] =array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3);
$LANG_configselects['databox'][13] =array('アクセス不可' => 0, '利用する' => 2);

$LANG_configselects['databox'][5] =array(
    '表示しない' => 'hide'
    , '編集日付によって表示する' => 'modified'
    , '作成日付によって表示する' => 'created');

//$LANG_configselects['databox'][17] =array('アクセス不可' => 0, '表示' => 2, '表示・編集' => 3);

$LANG_configselects['databox'][20] =array(
    '標準' => 'standard'
    , 'カスタム' => 'custom'
    , 'テーマ' => 'theme');

//@@@@@
$LANG_configselects['databox'][21] =array(
     '編集日付による' => 'modified'
    , '作成日付による' => 'created');

$LANG_configselects['databox'][22] =array(
    'ヘッダ・フッタ・左ブロックあり（右ブロックはテーマ設定による）' => 'standard'
    , 'ヘッダ・フッタ・左右ブロックあり' => 'leftrightblocks'
    , '全画面表示（ヘッダ・フッタ・ブロックなし）' => 'blankpage'
    , 'ヘッダ・フッタあり（ブロックなし）' => 'noblocks'
    , 'ヘッダ・フッタ・左ブロックあり（右ブロックなし）' => 'leftblocks'
    , 'ヘッダ・フッタ・右ブロックあり（左ブロックなし）' => 'rightblocks'

    );

$LANG_configselects['databox'][23] =array(
    'はい' => 3
    ,'一覧と詳細' => 2
    ,'詳細のみ' => 1
    , 'いいえ' => 0
    );


$LANG_configselects['databox'][9] =array(
    '画面遷移なし' => 'no'
    ,'ページを表示する' => 'item'
    , '一覧を表示する' => 'list'
    , 'ホームを表示する' => 'home'
    , '管理画面トップを表示する' => 'admin'
    , 'プラグイントップを表示する' => 'plugin'

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