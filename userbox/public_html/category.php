<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// |  カテゴリ別件数一覧、カテゴリ別一覧                                       |
// +---------------------------------------------------------------------------+
// $Id: public_html/databo/category.php
define ('THIS_SCRIPT', 'userbox/category.php');
//define ('THIS_SCRIPT', 'userbox/test.php');
define ('NEXT_SCRIPT', 'userbox/profile.php');
//20101119 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/
//20110905

require_once ('../lib-common.php');
if (!in_array('userbox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

$perpage=$_USERBOX_CONF['perpage']; // 1ページの行数 @@@@@

//debug 時 true
$_USERBOX_VERBOSE = false;


// +---------------------------------------------------------------------------+
// | 機能  カテゴリ別件数一覧表示
// | 書式
// +---------------------------------------------------------------------------+
// | 引数　$template　使用するテンプレートフォルダの名前
// | 戻値
// +---------------------------------------------------------------------------+
function fnclist($template)
{

    $pi_name="userbox";

    global $_CONF;
    global $_TABLES;
    global $perpage;

    global $_USERBOX_CONF;
    global $LANG_USERBOX;
    global $LANG_USERBOX_ADMIN;

    //-----
    $page = COM_applyFilter($_REQUEST['page'],true);
    if (!isset($page) OR $page == 0) {
        $page = 1;
    }

    //-----
    $tbl1=$_TABLES['USERBOX_category'] ;
    $tbl2=$_TABLES['USERBOX_base'] ;
    $tbl3=$_TABLES['USERBOX_def_category'] ;

    //-----
    $sql = "SELECT ".LB;

    $sql .= " t1.category_id ".LB;
    $sql .= " ,t3.name ".LB;
    $sql .= " ,t3.code ".LB;
    $sql .= " ,t3.description ".LB;
    $sql .= " ,Count(t1.id) AS count".LB;

    $sql .= " FROM ".LB;
    $sql .= " {$tbl1} AS t1 ".LB;
    $sql .= " ,{$tbl2} AS t2 ".LB;
    $sql .= " ,{$tbl3} AS t3 ".LB;

    $sql .= " WHERE ".LB;
    $sql .= " t1.id = t2.id ".LB;
    $sql .= " AND t1.category_id = t3.category_id ".LB;
    //管理者の時,下書データも含む
    //if ( SEC_hasRights('userbox.admin')) {
    //}else{
       $sql .= " AND t2.draft_flag=0".LB;
    //}
    //アクセス権のないデータ はのぞく
    $sql .= COM_getPermSql('AND',0,2,"t2").LB;
    //公開日以前のデータはのぞく
    $sql .= " AND (released <= NOW())".LB;

    //公開終了日を過ぎたデータはのぞく
    $sql .= " AND (expired=0 OR expired > NOW())".LB;

    $sql .= " GROUP BY ".LB;
    $sql .= " t1.category_id".LB;

    $sql .= " ORDER BY ".LB;
    $sql .= " t3.orderno".LB;


    $result = DB_query ($sql);
    $cnt = DB_numRows ($result);

    $pages = 0;
    if ($perpage > 0) {
        $pages = ceil($cnt / $perpage);
    }
    //ヘッダ、左ブロック
    if ($page > 1) {
        $page_title = sprintf ('%s (%d)', $LANG_USERBOX['category_top'], $page);
    } else {
        $page_title = sprintf ('%s ', $LANG_USERBOX['category_top']);
    }
    $headercode="<title>".$_CONF['site_name']." - ".$page_title ."</title>";
    $retval .= DATABOX_siteHeader($pi_name,'',$page_title,$headercode);

    //

    $tmplfld=DATABOX_templatePath('category',$template,$pi_name);
    $templates = new Template($tmplfld);
    $templates->set_file (array (
        'list' => 'list.thtml',
        'nav'   => 'navigation.thtml',
        'row'   => 'row.thtml',
        'col'   => "col.thtml",
        'pagenav'  => 'pagenavigation.thtml'
        ));


    //
    $templates->set_var ('site_url',$_CONF['site_url']);
    $templates->set_var ('this_script',THIS_SCRIPT);

    $templates->set_var ('home',$LANG_USERBOX['home']);
    $templates->set_var ('lang_category_list_h2',$LANG_USERBOX['category_top']);

    //page
    $offset = ($page - 1) * $perpage;
    $lin1=$offset+1;
    $lin2=$lin1+$perpage - 1;
    if ($lin2>$cnt){
        $lin2=$cnt;
    }
    $templates->set_var ('lang_view', $LANG_USERBOX['view']);
    $templates->set_var ('lin', $lin1."-".($lin2));
    $templates->set_var ('cnt', $cnt);

    //
    $templates->set_var ('lang_name', $LANG_USERBOX_ADMIN['name']);
    $templates->set_var ('lang_count', $LANG_USERBOX['count']);

    //

    $sql .= " LIMIT $offset, $perpage";

    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        for ($i = 0; $i < $numrows; $i++) {
            $A = DB_fetchArray ($result);

            $name=COM_applyFilter($A['name']);
            $description=COM_applyFilter($A['description']);
            $url=$_CONF['site_url'] . "/".THIS_SCRIPT;
            $url.="?";
            //コード使用の時
            if ($_USERBOX_CONF['categorycode']){
                $url.="m=code";
                $url.="&code=".$A['code'];
            }else{
                $url.="m=id";
                $url.="&id=".$A['category_id'];
            }
            $url = COM_buildUrl( $url );
            $link= COM_createLink($name, $url);
            $templates->set_var ('category_link', $link);
            $templates->set_var ('category_name', $name);
            $templates->set_var ('category_description', $description);
            $templates->set_var ('category_url', $url);
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
        $templates->set_var ('msg', $LANG_USERBOX["nohit"]);
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
$pi_name    = 'userbox';
//############################


//引数
if ($_CONF['url_rewrite']){
    COM_setArgNames(array('m','arg','template','arg2'));
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
    $page = COM_applyFilter($_REQUEST['page'],true);
    $order = COM_applyFilter($_REQUEST['order']);
    $mode = COM_applyFilter($_REQUEST['mode']);
}else{
    $id = COM_applyFilter($_REQUEST['id'],true);
    $code = COM_applyFilter($_REQUEST['code']);
    $template = COM_applyFilter($_REQUEST['template']);
    $page = COM_applyFilter($_REQUEST['page'],true);
    $order = COM_applyFilter($_REQUEST['order']);
    $mode = COM_applyFilter($_REQUEST['mode']);
}

if ($id===0){
    if ($code<>""){
        $id=DATABOX_codetoid(
            $code,'USERBOX_def_category',"category_id");
    }
}


//

$display = '';
$page_title=$LANG_USERBOX_ADMIN['piname'];

//ログイン要否チェック
if (COM_isAnonUser()){
    if  ($_CONF['loginrequired']
            OR ($_USERBOX_CONF['loginrequired'] === 3)
            OR ($_USERBOX_CONF['loginrequired'] === 2 AND $id>0) ){

        $display .= DATABOX_siteHeader($pi_name,'',$page_title);
        $display .= SEC_loginRequiredForm();
        $display .= DATABOX_siteFooter($pi_name);
        COM_output($display);
        exit;
    }

}

if ($id===0) { //一覧
	if ($code<>""){
		$display .= userbox_category("notautotag",$id,$template,"yes",$perpage,$page,$order,$code,$mode);
	}else{
		$display .= fnclist($template);
	}
}else{//詳細
    $display .= userbox_category("notautotag",$id,$template,"yes",$perpage,$page,$order,$code,$mode);
}

$display .= DATABOX_siteFooter($pi_name);

//---

echo $display;

?>