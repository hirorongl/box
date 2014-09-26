<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// |  検索リスト
// +---------------------------------------------------------------------------+
// $Id: public_html/databox/search.php
define ('THIS_SCRIPT', 'databox/search.php');
//define ('THIS_SCRIPT', 'databox/test.php');

define ('NEXT_SCRIPT', 'databox/data.php');
//define ('THIS_SCRIPT', 'databox/test.php');
//20140924 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/

require_once ('../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

//debug 時 true
$_DATABOX_VERBOSE = false;

function fncDisplay()
{

    $pi_name="databox";
    
    global $_CONF;
    global $_TABLES;
    
    global $_DATABOX_CONF;
    global $LANG_DATABOX;
    global $LANG_DATABOX_ADMIN;
    global $_IMAGE_TYPE;
    global $LANG_confignames;

    //ログイン要否チェック
    if (COM_isAnonUser()){
        if  ($_CONF['loginrequired']
                OR ($_DATABOX_CONF['loginrequired'] >1) ){
            return $LANG_DATABOX['loginrequired'];
        }

    }
    //-----テーブル
    $tbl1=$_TABLES['DATABOX_category'] ;
    $tbl2=$_TABLES['DATABOX_base'] ;
    $tbl3=$_TABLES['DATABOX_addition'] ;
    //
    $tbl5=$_TABLES['DATABOX_def_category'] ;
    
    $tbl6=$_TABLES['DATABOX_stats'];

    //
    $datefield=$_DATABOX_CONF['datefield'];//使用する日付（編集日付、作成日付、公開日）
    $new_img=$_DATABOX_CONF['new_img'];
    if ($new_img==""){
        $new_img="New!";
    }
    $newmarkday=$_DATABOX_CONF['newmarkday'];
    if ($newmarkday==""){
        $newmarkday=3;
    }
    $chkday=strtotime("- $newmarkday days",time());
    
    //-----引数退避
    $uri = $_SERVER["REQUEST_URI"];
    $w=explode ('?', $uri);
    $uri=$w[1];
    $w=explode ('&page', $uri);
    $uri=$w[0];
    //-----引数チェック
    $arg=$_REQUEST;
    $cary=array();

    foreach((array)$arg as $key => $value) {
        if (is_array($value)){
            $k = explode ('_', $key);
            $ids="";
            $ary=$value;
            if  ($k[0]=="gor"){
                foreach($ary as $key2 => $value2){
                    if ($ids<>""){
                        $ids.=",";
                    }
                    $ids.= COM_applyFilter($value2);
                }
                $cary[]= "(t2.id IN (SELECT id FROM {$tbl1}"
                           ." WHERE t2.id=id AND category_id IN ({$ids})) )";
            }else if ($k[0]=="gand"){
                foreach($ary as $key2 => $value2){
                    if ($ids<>""){
                        $ids.=" AND ";
                    }
                    $ids.= COM_applyFilter($value2);
                    $ids.= " IN (SELECT category_id";
                    $ids.=" FROM {$tbl1}  ";
                    $ids.=" WHERE t2.id = id )";
                }
                $cary[]= " (" .$ids." ) ";
            }
        }else{
            if  ($key=="fieldset") {
                $fieldset_id=$value;
            }else if  ($key=="templatedir") {
                $templatedir=$value;
            }else if  ($key=="perpage") {
                $perpage=$value;
            }else if  ($key=="page") {
                $page=$value;
            }else if  ($key=="nohitmsg") {
                $nohitmsg=$value;
            }else{
                $k = explode ('_', $key);
                if  ($k[0]=="aeq"){
                    $w=COM_applyFilter($k[1]);
                }else if ($k[0]=="afr"){
                    $w=COM_applyFilter($k[1]);
                }else if ($k[0]=="ato"){
                    $w=COM_applyFilter($k[1]);
                }
            }
        }
    }
    if  ($fieldset_id==""){
        $fieldset_id=0;
    }
    if ($perpage===0 OR is_null($perpage)){
        $perpage=$_DATABOX_CONF['perpage'];
    }
    if ($page===0 OR is_null($page)){
        $page=1;
    }
    if (is_null($nohitmsg)){
        $nohitmsg="yes";
    }
    //-----
    $sql = "SELECT ";

    $sql .= " t2.id ".LB;
    $sql .= " ,t2.title ".LB;
    $sql .= " ,t2.code ".LB;
    $sql .= " ,t2.description ".LB;
    $sql .= " ,t2.released ".LB;
    $sql .= " ,t2.expired ".LB;
    $sql .= " ,t2.".$datefield." AS datefield ".LB;
    $sql .= " ,t2.fieldset_id ".LB;
    $sql .= " ,UNIX_TIMESTAMP(t2.".$datefield.") AS datefield_un ".LB;
    $sql .= " ,UNIX_TIMESTAMP(t2.released ) AS released_un ".LB;
    $sql .= " ,UNIX_TIMESTAMP(t2.expired ) AS expired_un ".LB;

    $sql .= " ,t2.group_id";
    $sql .= " ,t2.owner_id";

    
    //--FROM
    $sql .= " FROM ".LB;
    $sql .= " {$tbl2} AS t2 ".LB;
    
    //--WHERE
    $sql .= " WHERE ".LB;
                
    //タイプ
    $sql .= " t2.fieldset_id=".$fieldset_id.LB;
    
    //条件
    foreach((array)$cary as $value) {
        $sql .= " AND ".$value;
    }
    //下書データを除く
    $sql .= " AND t2.draft_flag=0".LB;

    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND',0,2,"t2");

    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())".LB;
    //公開終了日を過ぎたデータはのぞく
    if  (strtoupper($expired)=="NO"){
        $sql .= " AND (expired=0 OR expired > NOW())";
    }

//echo "sql=".$sql."<br>";    
    $result = DB_query ($sql);
    $cnt = DB_numRows ($result);

    $pages = 0;
    if ($perpage > 0) {
        $pages = ceil($cnt / $perpage);
    }
    $offset = ($page - 1) * $perpage;
    $sql .= " LIMIT $offset, $perpage";

    //自動タグでない時　ヘッダ、左ブロック
    if ($autotag==="notautotag"){
        if ($page > 1) {
            $page_title = sprintf ('%s (%d)', $category_name, $page);
        } else {
            $page_title = sprintf ('%s ', $category_name);
        }
        
        // Meta Tags
        $headercode=DATABOX_getheadercode(    
            "category"
            ,$template
            ,$pi_name
            ,$category_id
            ,$category_name
            ,$category_description
            ,$category_name
            ,$category_description);
        $retval .= DATABOX_siteHeader($pi_name,'',$page_title,$headercode) ;
    }
    

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        
        $tmplfld=DATABOX_templatePath('search',$template,$pi_name);
        $templates = new Template($tmplfld);
        $templates->set_file (array (
            'list' => 'list_detail.thtml',
            'nav'   => 'navigation_detail.thtml',
            'row'   => 'row.thtml',
            'col'   => "col_detail.thtml",
            'pagenav'  => 'pagenavigation.thtml'
            ));

        $languageid=COM_getLanguageId();
        $language= COM_getLanguage();
        $templates->set_var ('languageid', $languageid);
        $templates->set_var ('language', $language);
        if ($languageid<>"") {
            $templates->set_var ('_languageid', "_".$languageid);
        }else{
            $templates->set_var ('_languageid', "");
        }

        //
        $templates->set_var ('site_url',$_CONF['site_url']);
        $templates->set_var ('this_script',THIS_SCRIPT);

        //bread
        $templates->set_var ('home',$LANG_DATABOX['home']);
        
        //page
        $templates->set_var ('cnt', $cnt);
        $lin1=$offset+1;
        $lin2=$lin1+$perpage - 1;
        if ($lin2>$cnt){
            $lin2=$cnt;
        }

        //summary navigation
        $templates->set_var ('lang_view', $LANG_DATABOX['view']);
        $templates->set_var ('lin', $lin1."-".($lin2));
        $templates->set_var ('cnt', $cnt);

        //
        $templates->set_var ('lang_title', $LANG_DATABOX_ADMIN['title']);
        $templates->set_var ('lang_code', $LANG_DATABOX_ADMIN['code']);
        $templates->set_var ('lang_id', $LANG_DATABOX_ADMIN['id']);
        $templates->set_var ('lang_description', $LANG_DATABOX_ADMIN['description']);
        $templates->set_var ('lang_date', $LANG_DATABOX_ADMIN[$datefield]);
        $templates->set_var ('lang_released', $LANG_DATABOX_ADMIN['released']);
        $templates->set_var ('lang_expired', $LANG_DATABOX_ADMIN['expired']);
        $templates->set_var ('lang_remaingdays', $LANG_DATABOX_ADMIN['remaingdays']);
        $templates->set_var ('lang_addfield', $addfield_name);
        // 追加項目のヘッダ
        $addition_def=DATABOX_getadditiondef($pi_name);
        
        //
        $templates->set_var('lang_imgfile_frd', $LANG_confignames['databox']['imgfile_frd']);
        $templates->set_var ('imgfile_frd', $_DATABOX_CONF['imgfile_frd']);
        $templates->set_var ('data_img_url', $_CONF['site_url']."/".$_DATABOX_CONF['imgfile_frd']);
        $templates->set_var('lang_imgfile_thumb_frd', $LANG_confignames['databox']['imgfile_thumb_frd']);
        $templates->set_var ('imgfile_thumb_frd', $_DATABOX_CONF['imgfile_thumb_frd']);
        $templates->set_var ('data_thumb_img_url', $_CONF['site_url']."/".$_DATABOX_CONF['imgfile_thumb_frd']);
        
        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);
            $A = array_map('stripslashes', $A);

            $title=$A['title'];
            $description=$A['description'];
            $code=COM_applyFilter($A['code']);
            $id=COM_applyFilter($A['id']);
            $datefield=COM_applyFilter($A['datefield']);
            $released=COM_applyFilter($A['released']);
            $expired=COM_applyFilter($A['expired']);
            $fieldset_id=COM_applyFilter($A['fieldset_id']);
            $datefield_ary = COM_getUserDateTimeFormat($A['datefield_un']);
            $released_ary = COM_getUserDateTimeFormat($A['released_un']);
            if ($expired==="0000-00-00 00:00:00"){
                $expired_ary=array();
            }else{    
                $expired_ary = COM_getUserDateTimeFormat($A['expired_un']);
            }
            $curdate_ary =  COM_getUserDateTimeFormat();

            
            $value=COM_applyFilter($A['value']);
            $group_id = $A['group_id'];
            $owner_id = $A['owner_id'];

            $url=$_CONF['site_url'] . "/databox/data.php";
            $url.="?";
            //コード使用の時
            if ($_DATABOX_CONF['datacode']){
                $url.="code=".$code;
                $url.="&amp;m=code";
            }else{
                $url.="id=".$id;
                $url.="&amp;m=id";
            }
            $url = COM_buildUrl( $url );
            $link= COM_createLink($title, $url);

            $templates->set_var ('data_link', $link);
            $templates->set_var ('data_title', $title);
            $templates->set_var ('data_code', $code);
            $templates->set_var ('data_description', $description);
            $templates->set_var ('data_id', $id);
            $templates->set_var ('data_url', $url);

            $templates->set_var ('data_datefield', $datefield_ary[0]);
            $templates->set_var ('data_value', $value);
            $templates->set_var ('data_datefield_shortdate', strftime( $_CONF['shortdate'], $A['datefield_un'] ));
            
            $templates->set_var ('data_released', $released_ary[0]);
            $templates->set_var ('data_released_shortdate', strftime( $_CONF['shortdate'], $A['released_un'] ));
            //公開終了日 Expired to publish
            if ($A['expired'] ==="0000-00-00 00:00:00"){
                $templates->set_var ('data_expired', "");
                $templates->set_var ('data_expired_shortdate', "" );
            }else{
                $wary = COM_getUserDateTimeFormat($A['expired_un']);
                $templates->set_var ('data_expired', $expired_ary[0]);
                $templates->set_var ('data_expired_shortdate', strftime( $_CONF['shortdate'], $A['expired_un'] ));
            }
            $remaingdays="";
            if ($expired<>"0000-00-00 00:00:00") {
                if  ($expired_ary[1]>=$curdate_ary[1]){
                    $remaingdays=COM_dateDiff( "d", $expired_ary[1], $curdate_ary[1] ) + 1;
                }
            }
            $templates->set_var ('data_remaingdays', $remaingdays);//@@@@@@
            if (date("Ymd",strtotime($datefield)) >= date("Ymd",$chkday)){
                $templates->set_var ('new_img', $new_img);
            }else{
                $templates->set_var ('new_img', '');
            }
            $hits=COM_applyFilter(DB_getItem( $tbl6 ,"hits","id={$id}"),true);
            $templates->set_var('lang_hits', $LANG_DATABOX_ADMIN['hits']);
            $templates->set_var('data_hits', $hits);
            
            //カテゴリ@@@@@
            $templates->set_var('lang_category', $LANG_DATABOX_ADMIN['category']);
            DATABOX_getcategoriesDisp($A['id'],$templates,$chk_user,0,$pi_name);

            //追加項目
            $chk_user=DATABOX_chkuser($group_id,$owner_id,"databox.admin");
            $additionfields = DATABOX_getadditiondatas($id,$pi_name);
            DATABOX_getaddtionfieldsDisp($additionfields,$addition_def,$templates,$chk_user,$pi_name,$fieldset_id);
            
            //管理者の時「編集」
            if ( SEC_hasRights('databox.admin')) {
                $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
                $attr = array('title' => $title." ".$LANG_DATABOX_ADMIN['edit']);
                $editiconhtml = COM_createImage($icon_url, $LANG_DATABOX_ADMIN['edit'], $attr);
                
                $attr = array('class' => 'editlink', 'title' => $title." ".$LANG_DATABOX_ADMIN['edit']);
                $url = $_CONF['site_admin_url'];
                $url .= '/plugins/databox/data.php';
                $url .= '?mode=edit';
                $url .= '&amp;'."id={$id}";
                $icon = '&nbsp;' ;
                $icon .=  COM_createLink( $editiconhtml,  $url,   $attr   );
                $templates->set_var ('data_edit', $icon);
            }else{
                $rt=databox_chk_loaddata($id);
                //編集権限のあるMyData
                if ( $rt==="OK") {
                    $icon_url = $_CONF['layout_url'] . '/images/edit.' . $_IMAGE_TYPE;
                    $attr = array('title' => $LANG_DATABOX_ADMIN['edit']);
                    $editiconhtml = COM_createImage($icon_url, $LANG_DATABOX_ADMIN['edit'], $attr);

                    $attr = array('class' => 'editlink', 'title' => $title." ".$LANG_DATABOX_ADMIN['edit']);

                    $url = $_CONF['site_url'];
                    $url .= '/databox/mydata/data.php';
                    $url .= '?mode=edit';
                    $url .= '&amp;'."id={$id}";

                    $icon = '&nbsp;' ;
                    $icon .=  COM_createLink( $editiconhtml,  $url,   $attr   );

                    $templates->set_var ('data_edit', $icon);
                }else{
                    $templates->set_var ('data_edit', "");
                }
                
            }

            
            //=====
            $templates->parse ('col_var', 'col', true);
            $templates->parse ('row_var', 'row', true);

            $templates->set_var ('col_var', '');

        }
        // Call to plugins to set template variables in the databox
        PLG_templateSetVars( 'databox', $templates );

        //------------
        //-----navigation
        $url = $_CONF['site_url']  . '/';
        $url.=THIS_SCRIPT;
        $url.="?";
        $url.=$uri;
        
        //-----page navigation
        $url .= $order;
        $templates->set_var ('page_navigation',
                COM_printPageNavigation ($url, $page, $pages));
        $templates->set_var ( 'pagenavinone', '' );
        //------------
        $templates->parse ('nav_var', 'nav', true);

        $templates->set_var ('msg', "");

        $templates->parse ('output', 'list');

        $content = $templates->finish ($templates->get_var ('output'));
        $retval .=$content;

    }else{
        if ($nohitmsg==="yes"){
            $tmplfld=DATABOX_templatePath('search',$template,$pi_name);
            $templates = new Template($tmplfld);
            $templates->set_file (array (
                'list' => 'nohit.thtml',
            ));
            
            $templates->set_var ('home',$LANG_DATABOX['home']);
            
                        
            $templates->set_var('xhtml', XHTML);
            $templates->set_var('site_url', $_CONF['site_url']);
            $templates->set_var('site_admin_url', $_CONF['site_admin_url']);
            $templates->set_var('layout_url', $_CONF['layout_url']);
            
            $templates->set_var ('lang_nohit', $LANG_DATABOX['nohit']);

            $templates->parse ('output', 'list');
            $content = $templates->finish ($templates->get_var ('output'));
            $retval .=$content;
        }
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
//
$display = '';
$page_title=$LANG_DATABOX_ADMIN['piname'];
//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_DATABOX_CONF['loginrequired'] == 3)
            OR ($_DATABOX_CONF['loginrequired'] == 2 AND $id>0) ){
        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }
}


//引数
//public_html/search.php?tp=1&gr1=1&at71=1&at72=1||2||3&at73=1000_2000
//labo3.itsup.net/gl210/databox/search.php?type=
//&attributeA=100000_15000
//&attributeA=2000|3000
//&attributeA=2000


$display = '';
$information = array();

$information['pagetitle']=$LANG_DATABOX_ADMIN['piname'];

$display=fncDisplay();



//---
$display=DATABOX_displaypage($pi_name,'',$display,$information);
COM_output($display);

?>