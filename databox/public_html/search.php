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
    global $_PLUGINS;
    global $_MAPS_CONF;

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
    $tbl7=$_TABLES['DATABOX_def_fieldset'];

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
    
    //-----Argument checking　引数チェック
	$arg=$_REQUEST;
	$arg_sv="";//---Argument save 引数退避　order page を除く
    foreach((array)$arg as $key => $value) {
        if (is_array($value)){
            $ary=$value;
            foreach($ary as $key2 => $value2){
			    if  ($arg_sv<>""){
				    $arg_sv.="&amp;";
			    }
				$arg_sv.=$key."[]=".$value2;
			}	
		}else{
		    if  ($key=="order"  OR $key=="page"){
			}else{
			    if  ($arg_sv<>""){
				    $arg_sv.="&amp;";
			    }
				$arg_sv.=$key."=".$value;
			}
		}
	}
    $cary=array();
    $acnt=0;
    $afield=array();
    $afile=array();
    $awhere=array();
    foreach((array)$arg as $key => $value) {
        if (is_array($value)){
            $k = explode ('_', $key);
            $ids="";
            $ary=$value;
            if  ($k[0]=="gor"){
                foreach($ary as $key2 => $value2){
                    $w= COM_applyFilter($value2);
					if  ($w<>""){
                        if ($ids<>""){
                            $ids.=",";
                        }
                        $ids.= COM_applyFilter($value2);
                    }
                }
                if  ($ids<>""){
                    $cary[]= "(t2.id IN (SELECT id FROM {$tbl1}"
                           ." WHERE t2.id=id AND category_id IN ({$ids})) )";
				}	
            }else if ($k[0]=="gand"){
                foreach($ary as $key2 => $value2){
                    $w= COM_applyFilter($value2);
					if  ($w<>""){
                        if ($ids<>""){
                            $ids.=" AND ";
						}
                        $ids.= $w;
                        $ids.= " IN (SELECT category_id";
                        $ids.=" FROM {$tbl1}  ";
                        $ids.=" WHERE t2.id = id )";
                    }
                }
                if  ($ids<>""){
                    $cary[]= " (" .$ids." ) ";
                }
            }else if ($k[0]=="ams"){
                foreach($ary as $key2 => $value2){
                    $w= COM_applyFilter($value2);
					if  ($w<>""){
                        if ($ids<>""){
                            $ids.=",";
                        }
                        $ids.= COM_applyFilter($value2);
                    }
                }
                if  ($ids<>""){
					$dummy= fncfield($k[0],COM_applyFilter($k[1]),$ids,$acnt,$afield,$afile,$awhere);
				}	
            }
		}else if ($value<>""){
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
            }else if  ($key=="expired") {
                $expired=$value;
            }else if  ($key=="order") {
                $order=$value;
            }else if  ($key=="teq") {
                $teq=$value;
            }else if  ($key=="t") {
                $t=$value;
            }else{
                $k = explode ('_', $key);
				if  ($k[0]=="aeq" OR $k[0]=="afr" OR $k[0]=="ato" OR $k[0]=="a"){
					$dummy= fncfield($k[0],COM_applyFilter($k[1]),$value,$acnt,$afield,$afile,$awhere);
                }
            }
        }
	}
    if  ($fieldset_id==""){
        $fieldset_id=0;
    }
    $fieldset_name=COM_applyFilter(DB_getItem( $tbl7 ,"name","fieldset_id={$fieldset_id}"));

    if ($perpage===0 OR is_null($perpage)){
        $perpage=$_DATABOX_CONF['perpage'];
    }
    if ($page===0 OR is_null($page)){
        $page=1;
    }
    if (is_null($nohitmsg)){
        $nohitmsg="yes";
    }
    if (is_null($expired)){
        $expired="no";
	}
    if (is_null($order)){
        $order="date";
	}
    $dummy=databox_orderby($datefield,$order,$orderby,$addfieldorder,$field_id);

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

    $sql .= " ,t2.group_id".LB;
    $sql .= " ,t2.owner_id".LB;
	
	if  ($acnt>0){
        for ($i = 1; $i <= $acnt; $i++) {
			$sql .= $afield[$i].LB;
		}
    }
	
    if ($addfieldorder){
        $sql .= " ,t3.value ".LB;
    }
    
    //--FROM
    $sql .= " FROM ".LB;
    $sql .= " {$tbl2} AS t2 ".LB;
    if ($addfieldorder){
        $sql .= " ,{$tbl3} AS t3 ".LB;
    }
	
	if  ($acnt>0){
        for ($i = 1; $i <= $acnt; $i++) {
			$sql .= $afile[$i].LB;
		}
    }
    
    //--WHERE
    $sql .= " WHERE ".LB;
                
    //タイプ
    $sql .= " t2.fieldset_id=".$fieldset_id.LB;
	//additionfield 追加項目でsort する時
    if ($addfieldorder){
		$sql .= " AND t3.field_id=".$field_id.LB;
        $sql .= " AND t3.id=t2.id".LB;
    }

	//条件
    if  ($teq<>""){
        $sql .= " AND (title="."'".$teq."')".LB;
    }
    if  ($t<>""){
        $sql .= " AND (title LIKE '%".$t."%')".LB;
    }
    foreach((array)$cary as $value) {
        $sql .= " AND ".$value.LB;
    }
	if  ($acnt>0){
        for ($i = 1; $i <= $acnt; $i++) {
			$sql .= " AND ".$awhere[$i].LB;
		}
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
	//--ORDER
    $sql .= " ORDER BY ".LB;
	$sql .= $orderby.LB;

//echo "sql=".$sql."<br>";    
    $result = DB_query ($sql);
    $cnt = DB_numRows ($result);

    $pages = 0;
    if ($perpage > 0) {
        $pages = ceil($cnt / $perpage);
    }
    $offset = ($page - 1) * $perpage;
    $sql .= " LIMIT $offset, $perpage";

    if ($page > 1) {
        $page_title = sprintf ('%s (%d)', $LANG_DATABOX_ADMIN['piname'], $page);
    } else {
        $page_title = sprintf ('%s ', $LANG_DATABOX_ADMIN['piname']);
    }
	// Meta Tags
	$title=$_CONF['site_name'] ."-". $fieldset_name;//og_title
	$description=$_CONF['meta_description'];//og_description
	$keywords=$_CONF['meta_keywords'];//og_description
	//meta 
	$headercode=DATABOX_getheadercode(	
		"search"
		,$templatedir
		,$pi_name
		,""
		,$title
		,$description
		,$keywords
		,$description
        ,""
        ,""
        ,""
        ,$fieldset_id
        ,$fieldset_name
	);
    $result = DB_query ($sql);
    $numrows = DB_numRows ($result);

    if ($numrows > 0) {
        
        $tmplfld=DATABOX_templatePath('search',$templatedir,$pi_name);
        $templates = new Template($tmplfld);
        $templates->set_file (array (
            'list' => 'list_detail.thtml',
            'arg'   => 'argument.thtml',
            'nav'   => 'navigation_detail.thtml',
            'row'   => 'row.thtml',
            'col'   => "col_detail.thtml",
            'pagenav'  => 'pagenavigation.thtml'
            ));
        
        $dummy=fncarg($arg,$templates);
        
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
        
        $referer =$_SERVER['HTTP_REFERER'];
        $templates->set_var ('referer', $referer);
        $templates->set_var ('lang_referer',$LANG_DATABOX['return']);
        $templates->set_var ('fieldset_name',$fieldset_name);
        $mkids="";
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
             //maps plugin link
             $mkid="";
             if (in_array("maps", $_PLUGINS)){
                 if ($code<>""){
                     $mkid=DB_getItem($_TABLES['maps_markers'],"mkid","item_10='$code'");
                     $mkids.=$mkid." ";
                 }
             }

            //=====
            $templates->parse ('col_var', 'col', true);
            $templates->parse ('row_var', 'row', true);

            $templates->set_var ('col_var', '');

        }
        $mkids=rtrim($mkids," ");
        $mkidary=array();
        $mkid_ary=split(" " , $mkids);
        $selectedMarkers="";
        if (function_exists("MAPS_selectedMarkers")) {
            $selectedMarkers=MAPS_selectedMarkers(
              $_MAPS_CONF['map_width']
             ,$_MAPS_CONF['map_height']
             ,$_MAPS_CONF['map_zoom']
             ,$mkid_ary);
        }
        $templates->set_var ('mkids', $mkids);
        $templates->set_var ('selectedMarkers', $selectedMarkers);

        // Call to plugins to set template variables in the databox
        PLG_templateSetVars( 'databox', $templates );

        //------------
        //-----navigation
        $url = $_CONF['site_url']  . '/';
        $url.=THIS_SCRIPT;
        $url.="?";
        $url.=$arg_sv;
        $url .= "&amp;order=";
		//-----order navigation
        $dummy=databox_order ($url, $templates, $order) ;
        //-----page navigation
        $url .= $order;
        $templates->set_var ('page_navigation',
                COM_printPageNavigation ($url, $page, $pages));
        $templates->set_var ( 'pagenavinone', '' );
        //------------
        $templates->parse ('arg_var', 'arg', true);
        $templates->parse ('nav_var', 'nav', true);

        $templates->set_var ('msg', "");

        $templates->parse ('output', 'list');

        $content = $templates->finish ($templates->get_var ('output'));

    }else{
        if ($nohitmsg==="yes"){
            $tmplfld=DATABOX_templatePath('search',$template,$pi_name);
            $templates = new Template($tmplfld);
            $templates->set_file (array (
                'list' => 'nohit.thtml',
                'arg'   => 'argument.thtml',
            ));

            $dummy=fncarg($arg,$templates);
            
            $templates->set_var ('home',$LANG_DATABOX['home']);
            $referer =$_SERVER['HTTP_REFERER'];
            $templates->set_var ('referer', $referer);
            $templates->set_var ('lang_referer',$LANG_DATABOX['return']);
            $templates->set_var ('fieldset_name',$fieldset_name);
                        
            $templates->set_var('xhtml', XHTML);
            $templates->set_var('site_url', $_CONF['site_url']);
            $templates->set_var('site_admin_url', $_CONF['site_admin_url']);
            $templates->set_var('layout_url', $_CONF['layout_url']);
            
            $templates->set_var ('lang_nohit', $LANG_DATABOX['nohit']);

            $templates->parse ('arg_var', 'arg', true);
            
            $templates->parse ('output', 'list');
            $content = $templates->finish ($templates->get_var ('output'));
        }
    }

    $retval["pagetitle"] =$pagetitle;
    $retval["headercode"] =$headercode;
    $retval["display"] =PLG_replacetags ($content);

    return $retval;
}    
function fncfield(
    $operate
    ,$field_id
    ,$value
    ,&$acnt
    ,&$afield
    ,&$afile
    ,&$awhere

)
// +---------------------------------------------------------------------------+
// | 機能  追加項目の条件 を編集
// | 書式  fncfield($operate,$field_id,$value,$acnt,$afield,$afile,$awhere);
// +---------------------------------------------------------------------------+
// | 引数 $operate
// | 引数 $field_id
// | 引数戻値 $acnt
// | 引数戻値 $afield
// | 引数戻値 $afile
// | 引数戻値 $awhire
// +---------------------------------------------------------------------------+

{
    global $_TABLES;
	
	
	$return=false;
	
    $sql="SELECT ";
    $sql.= " field_id ";
    $sql.= ",name ";
    $sql.= ",type ";
    $sql.=" FROM";
    $sql.=" {$_TABLES['DATABOX_def_field']} ";
    $sql.=" WHERE field_id=".$field_id;
    // 表示する項目のみ
    $sql.=" AND allow_display='0'";
	if  ($operate=="ams"){
        //9:オプションリスト（マスター）
        //16:ラジオボタンリスト（マスター）
		//18:マルチセレクトリスト（マスター）
		$sql.=" AND type IN (9,16,18)";
	}else{
         //0: 一行テキストフィールド
         //1: 複数行テキストフィールド
         //20:HTML  10:TinyMCE 19:CKEditor
         //15:数値  21:通貨
         $sql.=" AND type IN (0,1,10,19,20,15,21)";
	}
	
	$result = DB_query ($sql);
    $numrows = DB_numRows ($result);
    if ($numrows>0){
       $A = DB_fetchArray ($result);
       $acnt=$acnt+1;
       $afield[$acnt]=" ,a".$acnt.".value AS value".$acnt;
       $afile[$acnt]=" ,{$_TABLES['DATABOX_addition']} AS a".$acnt;
	   $w="a".$acnt.".field_id=".$field_id;
	   $w.=" AND a".$acnt.".id=t2.id";
	   if  ($operate=="aeq"){
	       $w.=" AND a".$acnt.".value='".$value."'";
       }else if ($operate=="a"){
            $w.=" AND a".$acnt.".value LIKE '%".$value."%'";
	   }else if ($operate=="afr"){
            if  ($A['type']==15  OR $A['type']==21){
                $w.=" AND (a".$acnt.".value + 0) >='".$value."'";
        	}else{
                $w.=" AND a".$acnt.".value>='".$value."'";
            }
	   }else if ($operate=="ato"){
            if  ($A['type']==15  OR $A['type']==21){
                $w.=" AND (a".$acnt.".value + 0) <='".$value."'";
            }else{
                $w.=" AND a".$acnt.".value<='".$value."'";
            }
       }else if ($operate=="ams"){
            $w.=" AND a".$acnt.".value  IN  ({$value})";
	   }
	   $awhere[$acnt]=$w;
       $return=true;
	}

    return ;

}
// $dummy=fncarg($arg,$templates);
function fncarg(
    $arg
    ,&$templates
)
{
    global $LANG_DATABOX;
    global $_CONF;
    global $_TABLES;
    
    $rt="";
    $templates->set_var ('site_url',$_CONF['site_url']);
    $templates->set_var ('this_script',THIS_SCRIPT);
    $templates->set_var ("lang_search",$LANG_DATABOX['search']);
    foreach((array)$arg as $key => $value) {
        if (is_array($value)){
            $k = explode ('_', $key);
            $ary=$value;
            if  ($k[0]=="gor"  OR  $k[0]=="gand"){
                $wnames="";
                foreach($ary as $key2 => $value2){
                    $key2p1=$key2+1;
                    $w= COM_applyFilter($value2);
                    $ary[$key2]=$w;
                    $templates->set_var ($key."_".$key2p1."_id",$w);
                    if  ($w<>""){
                        $wname=COM_applyFilter(
                        DB_getItem($_TABLES['DATABOX_def_category'] 
                            ,"name","category_id={$w}"));
                            $wnames.=$wname." ";
                    }else{
                        $wname="";
                    }
                    $templates->set_var ($key."_".$key2p1."_name",$wname);
                }
                $checklist=DATABOX_getcheckList ("categorygroup",$ary,"databox",$k[1],$key);
                $templates->set_var ($key,$checklist);
                $templates->set_var ($key."_names",$wnames);
            }else if  ($k[0]=="ams" ){
                $kind=COM_applyFilter(
                DB_getItem($_TABLES['DATABOX_def_field'] 
                     ,"selectlist","field_id={$k[1]}"));
                $wnames="";
                foreach($ary as $key2 => $value2){
                    $key2p1=$key2+1;
                    $w= COM_applyFilter($value2);
                    $ary[$key2]=$w;
                    $templates->set_var ($key."_".$key2p1."_no",$w);
                    if  ($w<>""){
                         $wname=COM_applyFilter(
                         DB_getItem($_TABLES['DATABOX_mst'] 
                             ,"value","kind='{$kind}' AND no={$w}"));
						$wnames.=$wname." ";
                     }else{
                         $wname="";
                     }
                     $templates->set_var ($key."_".$key2p1."_name",$wname);
                }
                $checklist=DATABOX_getcheckList ($kind,$ary,"databox",$k[1],$key);
                $templates->set_var ($key,$checklist);
                $templates->set_var ($key."_names",$wnames);
            }
        }else if ($value<>""){
            $w=COM_applyFilter($value);
            $templates->set_var ($key,$w);
        }
    }

    return ;
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


$rt=fncDisplay();
$information['pagetitle']=$rt['pagetitle'];
$information['headercode']=$rt['headercode'];
$display=$rt['display'];


//---
$display=DATABOX_displaypage($pi_name,'',$display,$information);
COM_output($display);

?>