<?
putenv("NLS_LANG=KOREAN_KOREA.KO16MSWIN949");
//putenv('NLS_LANG=AMERICAN_AMERICA.KO16MSWIN949');
 @ob_start();
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . 'GMT');
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
header('content-type:text/html; charset=utf-8');


Header("p3p: CP=\"CAO DSP AND SO ON\" policyref=\"/w3c/p3p.xml\"");
@session_cache_limiter('no-cache, must-revalidate');
@session_set_cookie_params ( 0, '/');
@session_cache_expire(86400);
ini_set("session.gc_maxlifetime", 86400);
session_start();
error_reporting(0);
error_reporting(E_ALL^E_NOTICE);
$ROOT_DIR="/home/onstp/pedia/m";

//오픈시 삭제꼭!!! 게시판 문제 생김!
$STP_DIR_TMP ="";

@include('../config/config.php');
@include('../config/basic_class.php');
@include('../config/inc.php');
$db = new dbConnect($DB_HOST, $DB_NAME, $DB_USER, $DB_PWD);
$tools = new tools();
$Page = new Page();
//$totalList	= $db->cnt( "DYB_ADMIN_INFO", "" );
$SQL = "SELECT *   FROM DYB_SITE_INFO ";
$site_info = mysql_fetch_object(mysql_query($SQL));
$new_type = "";

//===SQL injection 필터 처리
function stripslashes_deep($var){
    if($var){
		$var = is_array($var)?
                  array_map('stripslashes_deep', $var) :
                  stripslashes($var);
	}

    return $var;
}
function mysql_real_escape_string_deep($var){
	if($var){
		if(@preg_match("/[\xE0-\xFF][\x80-\xFF][\x80-\xFF]/", $var)) {
			 $var = addslashes($var);
		}else{
			$var = is_array($var)?
					  array_map('mysql_real_escape_string_deep', $var) :
					  mysql_real_escape_string($var);
		}
	}

    return $var;
}
if( get_magic_quotes_gpc() ){
    if( is_array($_POST) )
        $_POST = array_map( 'stripslashes_deep', $_POST );
    if( is_array($_GET) )
        $_GET = array_map( 'stripslashes_deep', $_GET );
}
if( is_array($_POST) )
    $_POST = array_map( 'mysql_real_escape_string_deep', $_POST );
if( is_array($_GET) )
    $_GET = array_map( 'mysql_real_escape_string_deep', $_GET);

 $HTTP_GET_VARS=$_GET;
 $HTTP_POST_VARS=$_POST;
 $HTTP_POST_FILES=$_FILES;
 if (phpversion() >= 4.2) { // POST, GET 방식에 관계 없이 사용하기 위해서
	if (count($_POST)) extract($_POST, EXTR_PREFIX_SAME, 'VARS_');
	if (count($_GET)) extract($_GET, EXTR_PREFIX_SAME, '_GET');
}
$mobile_br_check = false;
if (preg_match('/(iPhone|iPad|Android|Opera Mini|SymbianOS|WindowsCE|BlackBerry|SonyEricsson|webOS|PalmOS)/i', $_SERVER['HTTP_USER_AGENT'])) {
	$mobile_br_check = true;
}
$goPage = str_replace("../", "", $goPage);
?>
