<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// |  追加項目別件数一覧、追加項目別一覧
// +---------------------------------------------------------------------------+
// $Id: public_html/databox/field.php
define ('THIS_SCRIPT', 'databox/field.php');
//define ('THIS_SCRIPT', 'databox/test.php');
define ('NEXT_SCRIPT', 'databox/data.php');
//define ('NEXT_SCRIPT', 'databox/test.php');
//20100820 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/
//20110905 update

require_once ('../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

//debug 時 true
$_DATABOX_VERBOSE = false;

// +---------------------------------------------------------------------------+
// | 機能  追加項目別件数一覧表示
// | 書式
// +---------------------------------------------------------------------------+
// | 引数　$template　使用するテンプレートフォルダの名前
// | 戻値
// +---------------------------------------------------------------------------+
function fnclist($id,$template)
{
    global $_CONF;
    global $_TABLES;
    global $_DATABOX_CONF;
    global $perpage;
    global $LANG_DATABOX;
    global $LANG_DATABOX_ADMIN;
    global $LANG_DATABOX_NOYES;

    //-----
    $page = COM_applyFilter($_REQUEST['page'],true);
    if (!isset($page) OR $page == 0) {
        $page = 1;
    }

    $pi_name="databox";
    $field_def=DATABOX_getadditiondef($pi_name);


    //-----
    $tbl1=$_TABLES['DATABOX_addition'] ;
    $tbl2=$_TABLES['DATABOX_base'] ;
    $tbl3=$_TABLES['DATABOX_def_field'] ;


    //-----
    $sql = "SELECT ".LB;

    $sql .= " t1.field_id ".LB;
    $sql .= " ,t1.value ".LB;
    $sql .= " ,t3.name ".LB;
    $sql .= " ,t3.templatesetvar".LB;
    $sql .= " ,t3.description ".LB;
    $sql .= " ,Count(t1.id) AS count".LB;

    $sql .= " FROM ".LB;
    $sql .= " {$tbl1} AS t1 ".LB;
    $sql .= " ,{$tbl2} AS t2 ".LB;
    $sql .= " ,{$tbl3} AS t3 ".LB;

    $sql .= " WHERE ".LB;
    $sql .= " t1.value <>''".LB;
    $sql .= " AND t1.id = t2.id ".LB;
    $sql .= " AND t1.field_id = t3.field_id ".LB;

    //TYPE[0] = '一行テキストフィールド';
    //TYPE[2] = 'いいえ/はい';
    //TYPE[3] = '日付　（date picker対応）';
    //TYPE[7] = 'オプションリスト';
    //TYPE[8] = 'ラジオボタンリスト';
    $sql .= " AND t3.type IN (0,2,3,7,8) ".LB;

    //ALLOW_DISPLAY[0] ='表示する（orderに指定可能）';
    //ALLOW_DISPLAY[1] ='ログインユーザのみ表示する';
    if (COM_isAnonUser()){
        $sql .= " AND t3.allow_display=0 ".LB;
    }else{
        $sql .= " AND t3.allow_display IN (0,1) ".LB;
    }

    if ($id<>0){
        $sql .= " AND t1.field_id = ".$id.LB;
    }

    //管理者の時,下書データも含む
    if ( SEC_hasRights('databox.admin')) {
    }else{
       $sql .= " AND t2.draft_flag=0".LB;
    }
    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND',0,2,"t2").LB;
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())".LB;

    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())".LB;

    $sql .= " GROUP BY ".LB;
    $sql .= " t1.field_id , t1.value". LB;

    $sql .= " ORDER BY ".LB;
    $sql .= " t1.field_id,t1.value".LB;

    $result = DB_query ($sql);
    $cnt = DB_numRows ($result);
    $pages = 0;
    if ($perpage > 0) {
        $pages = ceil($cnt / $perpage);
    }
    //ヘッダ、左ブロック
    //@@@@@@ 修正要

    if ($id==0){
        $w=$LANG_DATABOX['field_top'];
        $field_top="";
        $field_top2=$w;
        $col="col.thtml";
    }else{
        $url=$_CONF['site_url']."/databox/field.php";
        $field_top=":<a href='".$url."'>".$LANG_DATABOX['field_top']."</a>";
        $field_top2=$field_def[$id]['name'];
        $w=$field_def[$id]['name'].$LANG_USERBOX['list'];
        $col="col2.thtml";
    }


    if ($page > 1) {
        $page_title = sprintf ('%s (%d)', $w, $page);
    } else {
        $page_title = sprintf ('%s ', $w);
    }
    $headercode="<title>".$_CONF['site_name']." - ".$page_title ."</title>";
    $retval .= DATABOX_siteHeader($pi_name,'',$page_title,$headercode);

    //

    $tmplfld=DATABOX_templatePath('field',$template,$pi_name);
    $templates = new Template($tmplfld);


    $templates->set_file (array (
        'list' => 'list.thtml',
        'nav'   => 'navigation.thtml',
        'row'   => 'row.thtml',
        'col'   => $col,
        'pagenav'  => 'pagenavigation.thtml'
        ));


    //
    $templates->set_var ('site_url',$_CONF['site_url']);
    $templates->set_var ('this_script',THIS_SCRIPT);

    $templates->set_var ('home',$LANG_DATABOX['home']);


    $templates->set_var ('field_top',$field_top);
    $templates->set_var ('field_top2',$field_top2);

    //page
    $offset = ($page - 1) * $perpage;
    $lin1=$offset+1;
    $lin2=$lin1+$perpage - 1;
    if ($lin2>$cnt){
        $lin2=$cnt;
    }
    $templates->set_var ('lang_view', $LANG_DATABOX['view']);
    $templates->set_var ('lin', $lin1."-".($lin2));
    $templates->set_var ('cnt', $cnt);

    //
    $templates->set_var ('lang_name', $LANG_DATABOX_ADMIN['name']);
    $templates->set_var ('lang_count', $LANG_DATABOX['count']);

    //

    $sql .= " LIMIT $offset, $perpage";

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);

            $name=COM_applyFilter($A['name']);
            $description=COM_applyFilter($A['description']);

            $fid=$A["field_id"];
            $value=$A["value"];

            $fieldvalue=DATABOX_getfieldvalue(
                $value
                ,$field_def[$fid]['type']
                ,$field_def[$fid]['selectionary']
                ,$LANG_DATABOX_NOYES
                );

            $url=$_CONF['site_url'] . "/".THIS_SCRIPT;
            $url.="?";
                //$url.="m=code";
                //$url.="&code=".$A['code'];
                $url.="m=id";
                $url.="&id=".$A['field_id'];

            $url = COM_buildUrl( $url );
            $link= COM_createLink($name, $url);

            $url2=$url."&value=".$A['value'];
            $link2= COM_createLink($fieldvalue, $url2);

            $templates->set_var ('field_link', $link);
            $templates->set_var ('value_link', $link2);

            $templates->set_var ('field_description', $description);
            $templates->set_var ('field_name', $name);
            $templates->set_var ('field_url', $url);

            $templates->set_var ('value_url', $url2);
            $templates->set_var ('value', $fieldvalue);


            $templates->set_var ('count', $A['count']);


            //=====
            $templates->parse ('col_var', 'col', true);
            $templates->parse ('row_var', 'row', true);

            $templates->set_var ('col_var', '');

        }
        //ページなび
        //$url = $_CONF['site_url']  . '/'.THIS_SCRIPT."?m=".$m;//."?order=$order";
        $url = $_CONF['site_url']  . '/'.THIS_SCRIPT;

        $templates->set_var ('page_navigation',
                  COM_printPageNavigation ($url, $page, $pages));
        //------------
        $templates->parse ('nav_var', 'nav', true);

        $templates->set_var ('blockfooter',COM_endBlock());

        $templates->set_var ('msg', "");

        $templates->parse ('output', 'list');

        $school_content = $templates->finish ($templates->get_var ('output'));
        $retval .=$school_content;

    }else{
        $templates->set_var ('msg', $LANG_DATABOX["nohit"]);
        $templates->parse ('output', 'list');
        $content = $templates->finish ($templates->get_var ('output'));
        $retval .=$content;
    }

    $retval =PLG_replacetags ($retval);

    return $retval;
}



// +---------------------------------------------------------------------------+
// MAIN
// +---------------------------------------------------------------------------+
//############################
$pi_name    = 'databox';
//############################


//引数
$id = COM_applyFilter($_REQUEST['id'],true);
$code = COM_applyFilter($_REQUEST['code']);
$value = COM_applyFilter($_REQUEST['value']);
$template = COM_applyFilter($_REQUEST['template']);
$page = COM_applyFilter($_REQUEST['page'],true);
$perpage = COM_applyFilter($_REQUEST['perpage'],true);
$order = COM_applyFilter($_REQUEST['order']);

if ($_CONF['url_rewrite']){
    COM_setArgNames(array('m','code','template','arg2'));
    $m=COM_applyFilter(COM_getArgument('m'));
    if ($m==="code"){
        COM_setArgNames(array('m','code','template','arg2'));
        $id=0;
        $code=COM_applyFilter(COM_getArgument('code'));
    }else{
        COM_setArgNames(array('m','id','template','arg2'));
        $id=COM_applyFilter(COM_getArgument('id'),true);
        $code=0;
    }
    $template=COM_applyFilter(COM_getArgument('template'));
}

//@@@@@@!!!
if ($id===0){
    if ($code<>""){
        $id=DATABOX_codetoid(
            $code,'DATABOX_def_field',"field_id","templatesetvar");
    }
}
if ($perpage===0){
    $perpage=$_DATABOX_CONF['perpage']; // 1ページの行数 @@@@@
}


//


$display = '';
$page_title=$LANG_DATABOX_ADMIN['piname'];

//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_DATABOX_CONF['loginrequired'] === 3)
            OR ($_DATABOX_CONF['loginrequired'] === 2 AND $id>0) ){
        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }

}


if ($value==="") { //一覧
    $display .= fnclist($id,$template);
}else{//詳細
    if ($perpage>5){
        $perpage=5;
    }

    $display .= databox_field(
        "notautotag"
        ,$id
        ,$value
        ,$template
        ,"yes"
        ,$perpage
        ,$page
        ,$order
        ,$code
        );
}

$display .= DATABOX_siteFooter($pi_name);

//---

COM_output($display);

?>