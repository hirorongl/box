<?php
/* Reminder: always indent with 4 spaces (no tabs). */
// +---------------------------------------------------------------------------+
// |  download
// +---------------------------------------------------------------------------+
// $Id: public_html/databox/download.php
define ('THIS_SCRIPT', 'databox/download.php');
//define ('THIS_SCRIPT', 'databox/test.php');

//20140924 tsuchitani AT ivywe DOT co DOT jp http://www.ivywe.co.jp/

require_once ('../lib-common.php');
if (!in_array('databox', $_PLUGINS)) {
    echo COM_refresh($_CONF['site_url'] . '/index.php');
    exit;
}

//debug 時 true
$_DATABOX_VERBOSE = false;

function DATABOX_fieldownload(
    $pi_name
    ,$id
    ,$code
    ,$field_id
    ,$field_code
)
// +---------------------------------------------------------------------------+
// | 機能  ファイルダウンロード 
// | 書式 DATABOX_fieldownload($pi_name,$id,$code,$field_id,$field_code)
// +---------------------------------------------------------------------------+
// | 引数 $pi_name:plugin name 'databox' 'userbox' 'formbox'
// | 引数 $id:
// | 引数 $code:
// | 引数 $field_id:
// | 引数 $field_code:
// +---------------------------------------------------------------------------+
// | 戻値 nomal:
// +---------------------------------------------------------------------------+
{
    global $_TABLES;
    global $_CONF;
    
    $box_conf="_".strtoupper($pi_name)."_CONF";
    global $$box_conf;
    $box_conf=$$box_conf;
          
    $lang_box="LANG_".strtoupper($pi_name);
    global $$lang_box;
    $lang_box=$$lang_box;
    $separater=$lang_box['field_separater'];

    $table_base=$_TABLES[strtoupper($pi_name).'_base'];
    $table_def_field=$_TABLES[strtoupper($pi_name).'_def_field'];
    $table_addition=$_TABLES[strtoupper($pi_name).'_addition'];
    $table_def_fieldset_assignments
        =$_TABLES[strtoupper($pi_name).'_def_fieldset_assignments'];
    //-----引数チェック
    if (is_null($id)  OR $id===""){
        if (is_null($code) OR $code===""){
            $id=0;
        }else{
            if ($pi_name=="userbox"){
                $id=DATABOX_codetoid($code,'users',"uid","username");
            }else{
                $id=DATABOX_codetoid($code,strtoupper($pi_name).'_base');
            }
        }
	}
    if ($id===0) {
        return "download argument error id";
    }
    if (is_null($field_id) OR $field_id===""){
        if (is_null($field_code) OR $field_code===""){
            $field_id=0;
        }else{
            $field_id=DATABOX_codetoid($field_code,strtoupper($pi_name).'_def_field'
                     ,"field_id","templatesetvar");
        }
    }
    if ($field_id===0) {
        return "download Argument error field_id";
    }
    $fieldset_id=DB_getItem( $table_base,"fieldset_id","id=".$id  );
    if  ($fieldset_id==0){
    }else{
        $w=DB_getItem( $table_def_fieldset_assignments
             ,"fieldset_id","fieldset_id=$fieldset_id AND field_id=".$field_id );
        if  ($w==""){
            return "download drgument error id field_id";
        }
    }
    //
    $sql  = "SELECT DISTINCT ".LB;
    $sql  .= " t.value ".LB;
    $sql  .= " FROM ".LB;
    $sql  .= "{$table_addition} AS t".LB;
    $sql  .= " , {$table_def_field} AS m".LB;
    
    $sql  .= " WHERE  ".LB;
    $sql  .= " t.id = {$id} AND t.field_id = {$field_id} ".LB;
    $sql  .= " AND m.field_id = {$field_id} ".LB;
    //@@@@@>>>$sql  .= " AND m.allow_display = 0 ".LB;
    $sql  .= " AND m.type = 13 ".LB;
    
    $result = DB_query ($sql);
    $num = DB_numRows ($result);
    $rt="Target file is not found";
    if ($num<>0){
        $A = DB_fetchArray ($result);
        $A = array_map('stripslashes', $A);
		$value=$A['value'];
		if  ($value<>""){
		    $a=explode("/",$value);
		    if  (count($a)>1){
			    $filename=$a[1];
			}else{
			    $filename=$a[0];
			}
		    list($dummy,$extention)=explode(".",$filename);
		    $filetype=DATABOX_getFileTypeAry($extention );
		    if  ($filetype<>""){
			    $path=$box_conf['file_path'];
 		        if  (file_exists($path.$value)){
		            header('Content-Type: '.$filetype);
                    header('Content-Disposition: attachment; filename="'.$filename.'"');
					readfile($path.$value);
                    //download log
					//download count
					exit;
				}
		    }
		}
	}
	
    return $rt;

}
function DATABOX_getFileTypeAry(
    $extension 
)
{
    $ary=array();
    $ary['odt']="application/vnd.oasis.opendocument.text";//open office writer*
    $ary['doc']="application/msword";//Microsoft Word
    $ary['docx']="application/vnd.openxmlformats";// Microsoft Office Word 2007*
    $ary['html']="text/html";
    $ary['odb']="application/octet-stream ";//OpenOffice Base*
    $ary['odf']="application/vnd.oasis.opendocument.formula";//OpenOffice Calc*
    $ary['odg']="application/vnd.oasis.opendocument.graphics";//OpenOffice Draw*
    $ary['odm']="application/vnd.oasis.opendocument.text-master";// OpenOffice Writer*
    $ary['odp']="application/vnd.oasis.opendocument.presentation";//OpenOffice Impress*
    $ary['ods']="application/vnd.oasis.opendocument.spreadsheet";//OpenOffice Calc*
    $ary['otg']="application/vnd.oasis.opendocument.graphics-template";//OpenOffice Draw*
    $ary['oth']="application/octet-stream";// OpenOffice.org Writer*
    $ary['otp']="application/vnd.oasis.opendocument.presentation-template";//OpenOffice Impress*
    $ary['ots']="application/octet-stream";//OtsAV*
    $ary['ott']="application/vnd.oasis.opendocument.formula-template ";//OpenOffice Writer*
    $ary['oxt']="application/vnd.openofficeorg.extension";//OpenOffice *
    $ary['pdf']="application/pdf";
    $ary['ppt']="application/mspowerpoint";//Microsoft PowerPoint*
    $ary['pptx']="application/vnd.openxmlformats";//Microsoft Office PowerPoint 2007*
    $ary['txt']="text/plain";
    $ary['xls']="application/vnd.ms-excel";//Microsoft Excel*
    $ary['xlsx']="application/vnd.openxmlformats ";//Microsoft Office Excel 2007*
    $ary['xml']="text/xml";
	if  ($extention===""){
		$rt= $ary;
	}else{
		$rt= $ary[$extension];
	}
	return $rt;
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
//public_html/download.php?id=1&field_id=
$id = '';
if (isset ($_REQUEST['id'])) {
    $id = COM_applyFilter ($_REQUEST['id'], true);
}
$code = '';
if (isset ($_REQUEST['code'])) {
    $code = COM_applyFilter ($_REQUEST['code'], false);
}
$field_id = '';
if (isset ($_REQUEST['field_id'])) {
    $field_id = COM_applyFilter ($_REQUEST['field_id'], false);
}
$field_code = '';
if (isset ($_REQUEST['field_code'])) {
    $field_id = COM_applyFilter ($_REQUEST['field_code'], false);
}

//$information = array();
//$information['pagetitle']=$LANG_DATABOX_ADMIN['piname'];
//$display=DATABOX_fieldownload($pi_name,$id,$code,$field_id,$field_code);
//$display=DATABOX_displaypage($pi_name,'',$display,$information);
//COM_output($display);


$rt=DATABOX_fieldownload($pi_name,$id,$code,$field_id,$field_code);

//$ret_url = $_SERVER['HTTP_REFERER'];
//echo COM_refresh($ret_url);

?>