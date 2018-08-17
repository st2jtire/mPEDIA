<?php
$mobile_br_check = false;

if (preg_match('/(iPhone|iPad|Android|Opera Mini|SymbianOS|WindowsCE|BlackBerry|SonyEricsson|webOS|PalmOS)/i', $_SERVER['HTTP_USER_AGENT'])) {
	$mobile_br_check = true;
}

//루트디렉토리
$_RootPath_ = $_SERVER['DOCUMENT_ROOT'];

//이미지저장
$img_save_dir = $_SERVER['DOCUMENT_ROOT'].'/_sfile/image/';

//파일저장
$file_save_dir = $_SERVER['DOCUMENT_ROOT'].'/_sfile/file/';

//강의 사운드파일저장
$sound_save_dir = $_SERVER['DOCUMENT_ROOT'].'/_sfile/sound/';

//에디터 이미지
$editor_img_save_dir = $_SERVER['DOCUMENT_ROOT'].'/editor/_image/';

//에디터 파일
$editor_file_save_dir = $_SERVER['DOCUMENT_ROOT'].'/editor/_file/';

//메인 이미지 flv
$main_img_save_dir = $_SERVER['DOCUMENT_ROOT'].'/thumImg/';

//파일 확장자 체크
$check_img_ext = '[^\.(jpg|jpeg|gif|png)]';
$check_file_ext = '^\.(php|htm|html|phtm|phtml|js|jsp|asp|php3|exe|com|bat|cgi|pl|c|cpp|h|inc|cmd|nt)$';

$check_img_ext_add = array('.jpg','.jpeg','.gif','.png');
$check_file_ext_add = array('.php','.htm','.html','.phtm','.phtml','.js','.jsp','.asp','.php3','.exe','.com','.bat','.cgi','.pl','.c','.cpp','.h','.inc','.cmd','.nt');

$member_type_ary = array(1=>'일반회원', '최선어학원생');

$member_lev_ary = array(1=>'일반회원',2=>'STAFF', 3=>'선생님', 4=>'강좌선생님', 8=>'원장', 9=>'관리자');

$pay_type_ary = array('card' => '카드','bank' => '무통장입금','tran'=>'계좌이체','virtual'=>'가상계좌','mobile'=>'핸드폰','coupon'=>'쿠폰취소');

$order_type_ary  = array('lect' => '강좌','book' => '교재','lcbo'=>'강좌+교재','free'=>'프리패스');

$type_ary  = array('l' => '강좌','b' => '교재','f'=>'프리패스');


$pay_status_ary = array(0=>'결제전',1=>'결제완료',2=>'전체환불',3=>'부분환불',4=>'결제실패',5=>'쿠폰사용');
$pay_status_ary_admin = array(0=>'결제전',1=>'결제완료',2=>'전체환불',3=>'부분환불');
//kcp 코드 1. 결제완료 2. 환불처리 3.환불처리실패 4. 결제실패
$deli_status_ary = array(0=>'배송전',1=>'배송중',2=>'배송완료',3=>'배송취소');

$cancel_ary = array(0=>'고객변심',1=>'착오구매',2=>'컴퓨터이상',3=>'강좌변경');
$cancel_lecture_ary = array(1=>'구매',2=>'취소');
$bank_ary = array('03'=>'기업','05'=>'외환','06'=>'국민','11'=>'농협','81'=>'하나','07'=>'수협','20'=>'우리','26'=>'신한','39'=>'경남','71'=>'우체국','32'=>'부산','31'=>'대구');
$_report_type_ary = array(1=>'출석','수강','노트','후기');

$lec_cancel_ary = array(1=>'환불대기',2=>'환불완료',3=>'환불불가',4=>'강좌변경완료',5=>'강좌변경불가',6=>'전화요망');

$lec_cancel_type_ary = array(1=>'전체환불',2=>'부분환불',3=>'강좌변경');

$level_type_ary  = array('E' => '초급','M' => '중급','H'=>'고급');

$lec_month_ary = array(1=>'1',2=>'2',3=>'3',4=>'4',5=>'5',6=>'6',7=>'7',8=>'8',9=>'9',10=>'10',11=>'11',12=>'12');


$report_05_tit_ary = array(
	'd' => '일별',
	'm' => '월별',
	'y' => '년별'
);

$report_06_tit_ary = array(
	'r' => '회원가입',
	1 => '로그인',
	2 => '수강',
	3 => '학습노트',
	4 => '수강후기',
	'p' => '결제'
);

$_excel_fname_ary = array(
	1 => '학원장 Report',
	'분원장 Report',
	'TR Report',
	'고객 지원팀 Report',
	'운영자 Report',
	'통 계'
);

##################################################################
# db 연결
##################################################################
$db_con = mysql_connect($DB_HOST, $DB_USER, $DB_PWD)  or die ("데이타 베이스 접속실패.");
mysql_select_db($DB_NAME, $db_con);
mysql_query("set names euckr", $db_con);

##################################################################
#config
##################################################################
$_ConFig_ = mysql_fetch_assoc(mysql_query(' select * from `config` '));

$_SiteInfo_ = mysql_fetch_assoc(mysql_query(' select * from `DYB_SITE_INFO` '));

if (!isset($_SESSION['spam_code']) && !trim($_SESSION['spam_code'])) {
	$_SESSION['spam_code'] = strtolower(substr(uniqid(''), -5));
}

//카운터
if (!$_COOKIE['date']) {
	$Gis = date("G:i:s");
	@setcookie("date",md5($date),time()+86400,"/",$_SERVER['HTTP_HOST']);
	$sql = ' insert into `_counter` set
	`ip` = \''.$_SERVER['REMOTE_ADDR'].'\' ,
	`date`  = curdate() ,
	`time`  = \''.$Gis.'\' ,
	`referer`  = \''.$_SERVER['HTTP_REFERER'].'\' ,
	`browser`  = \''.$_SERVER['HTTP_USER_AGENT'].'\' ';
	@mysql_query($sql);
}

//장바구니 삭제
@mysql_query(' delete from `cart` where `sdate` < date_add(now(), interval -3 day) ');

##################################################################
# 함수
##################################################################

//print_r 간단.
function pr($var)
{
	echo'<xmp>';
	print_r($var);
	echo'</xmp>';
}

//alt
function alt($msg, $opt)
{
	$script = '<script type="text/javascript">';
	$script .= 'alert("'.$msg.'");';
	$script .= ($opt) ? $opt : '' ;
	$script .= '</script>';
	echo$script;
	exit;
}

//javascript
function script($spt)
{
	$script = '<script type="text/javascript">';
	$script .= ($spt);
	$script .= '</script>';
	echo$script;
	exit;
}

// 리퍼러 체크
function check_referer()
{
	if(isset($_SERVER['HTTP_REFERER']) == false || !preg_match("/^http[s]?:\/\/".$_SERVER['HTTP_HOST']."/", $_SERVER['HTTP_REFERER']))
	{
		alt('제대로 된 접근이 아닌것 같습니다.','top.location.replace("http://'.$_SERVER['SERVER_NAME'].'");');
		exit;
	}
}

//쿼리, 조건, 정렬, 출력수, 현재페이지, 페이징 블럭수
function page_list($sql, $where, $order, $per_page, $n_page, $page_block, $page_option)
{
	$list = Array();
	if($where) $sql .= " where {$where} "; //where 필드 추가
	if($order) $sql .= " order by {$order} "; //order by 함
	$result = mysql_query($sql);
	$total = mysql_num_rows($result); //총게시물수
	if($total)
	{
		$total_page = ceil($total / $per_page); //총페이지수
		$start = $per_page * ($n_page - 1); //첫페이지
		$sql .= " limit {$start}, $per_page";
		$result = mysql_query($sql);
		if(mysql_num_rows($result))
		{
			$n_number = $total - $start;
			while($row = mysql_fetch_assoc($result))
			{
				$list['list'][] = array_merge($row, array('n_num' => $n_number));
				$n_number--;
			}
		}
		else
		{
			$list['list'] = 0;
		}
		if($start >= 0) $list['paging'] = page_paging($total_page, $n_page, $page_block, $page_option);
		else $list['paging'] = 0;
	}
	else
	{
		$list['list'] = 0;
		$list['paging'] = 0;
	}
	return $list;
}

//쿼리, 조건, 정렬, 출력수, 현재페이지, 페이징 블럭수
function page_list_group($sql, $where, $group, $order, $per_page, $n_page, $page_block, $page_option)
{
	$list = Array();
	if($where) $sql .= " where {$where} "; //where 필드 추가
	if($group) $sql .= " group by {$group} "; //group by 필드 추가
	if($order) $sql .= " order by {$order} "; //order by 함
	$result = mysql_query($sql);
	$total = mysql_num_rows($result); //총게시물수
	if($total)
	{
		$total_page = ceil($total / $per_page); //총페이지수
		$start = $per_page * ($n_page - 1); //첫페이지
		$sql .= " limit {$start}, $per_page";
		$result = mysql_query($sql);
		if(mysql_num_rows($result))
		{
			$n_number = $total - $start;
			while($row = mysql_fetch_assoc($result))
			{
				$list['list'][] = array_merge($row, array('n_num' => $n_number));
				$n_number--;
			}
		}
		else
		{
			$list['list'] = 0;
		}
		if($start >= 0) $list['paging'] = page_paging($total_page, $n_page, $page_block, $page_option);
		else $list['paging'] = 0;
	}
	else
	{
		$list['list'] = 0;
		$list['paging'] = 0;
	}
	return $list;
}

//총페이지, 현재페이지, 페이징블럭, 페이지 옵션
function page_paging($totalPage, $nowPage, $listPage, $page_option)
{
	$pageStr = '<ul>';
	$firstPage = $nowPage - ceil($listPage / 2);
	if($firstPage < 1) $firstPage = 1;
	$last_page = $totalPage;
	if($totalPage - $nowPage < ceil($listPage / 2)) $limitPage = $totalPage - $firstPage + 1;
	else if($totalPage > $listPage) $limitPage = $listPage;
	else $limitPage = $totalPage;

	for($i = $firstPage ; $i < $firstPage + $limitPage ; $i++)
	{
		if($i == $nowPage) $pageStrLink .= "<li><a class='now' href='?page={$i}{$page_option}'>{$nowPage}</a></li>";
		else $pageStrLink .= "<li><a title='{$i} 페이지' href='?page={$i}{$page_option}'>{$i}</a></li>";
	}

	if($firstPage > 1) $pageStrAdd1 = "<li><a title='처음 페이지' href='?page=1{$page_option}'>1</a> ... </li>";
	if($totalPage - ceil($listPage / 2) >= $nowPage) $pageStrAdd2 = "<li> ... <a title='끝 페이지' href='?page={$totalPage}{$page_option}'>{$totalPage}</a></li>";

	$pageStr .= $pageStrAdd1.$pageStrLink.$pageStrAdd2;
	$pageStr .= '</ul>';

	return $pageStr;
}

//레벨확인
function get_level($id)
{
	if(empty($id))
	{
		$put_level = 0;
	}
	else
	{
		$sql = "select `level` from `members` where mid = '".$id."'";
		$result = mysql_query($sql);
		$put_level = mysql_result($result, 0, 0);
	}
	return $put_level;
}

//권한검사
function auth_check($catch_level, $auth_level)
{
	if($catch_level >= $auth_level)
		return true;
	else
		return false;
}

//문자열자르기
//utf8
/*function str_cut($str, $len, $tail='...')
{
	$rtn = array();
	return preg_match('/.{'.$len.'}/su', $str, $rtn) ? $rtn[0].$tail : $str;
}*/
//euckr
function str_cut($str, $len, $suffix='...')
{
    if ($len >= strlen($str)) return $str;
        $klen = $len - 1;
        while(ord($str[$klen]) & 0x80) $klen--;
        return substr($str, 0, $len - (($len + $klen + 1) % 2)) . $suffix;
}


//파일 업로드
function upload_file_board($tmp_name, $up_file, $save_dir)
{
	$upfile_name = '';
	$up_ext = strtolower(substr($up_file, strpos($up_file, '.') + 1));
	$upfile_name = uniqid('').'.'.$up_ext;

	while(true)
	{
		if(file_exists(($save_dir.$upfile_name)))
			$upfile_name = uniqid('').'.'.$up_ext;
		else
			break;
	}

	if(is_uploaded_file($tmp_name))
	{
		if(!copy($tmp_name, $save_dir.$upfile_name))
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	@chmod($save_dir.$upfile_name, 0707);
	return $upfile_name;
}

//썸네일 이미지 생성 GD 사용
function put_gdimage($img_name, $width='', $height='', $save_name, $save_dir) {
	// GD 버젼체크
	$gd = gd_info();
	$gdver = substr(preg_replace("/[^0-9]/", "", $gd['GD Version']), 0, 1);
	if (!$gdver) return false;

	$srcname = $save_dir.$img_name;
	$imginfo = getimagesize($srcname);

	$img_width = $imginfo[0];
	$img_height = $imginfo[1];
	$img_type = $imginfo[2];

	if (!in_array($img_type, array(1,2,3))) return false;

	if(!$width && !$height) {
		$width = $img_width;
	    $height = $img_height;
	}
	else if(!$width) {
		$width = $img_width * ($height/$img_height);    //자동 비율생성 : 너비
	}
	else if(!$height) {
		$height = $img_height * ($width/$img_width);    //자동 비율생성 : 높이
	}

	if($img_width > $width || $img_height > $height) {
		if ($img_width == $img_height) {
			$dst_s_width = $width;
			$dst_s_height = $height;
		}
		else if($img_width > $img_height) {
			$dst_s_width = $width;
			$dst_s_height = ceil(($width / $img_width) * $img_height);
		}
		else {
			$dst_s_height = $height;
			$dst_s_width = ceil(($height / $img_height) * $img_width);
		}
   }
   else {
		$dst_s_width = $img_width;
		$dst_s_height = $img_height;
	}

	if ($dst_s_width < $width)
		$srcx_s = ceil(($width - $dst_s_width)/2);
	else
		$srcx_s = 0;

    if ($dst_s_height < $height)
		$srcy_s = ceil(($height - $dst_s_height)/2);
	else
		$srcy_s = 0;

	if($img_type == 1) // gif
	{
		$cfile = imagecreatefromgif($srcname);
		if($gdver == 2)
		{
			$dest = imagecreatetruecolor($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresampled($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		else
		{
			$dest = imagecreate($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresized($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		imagegif($dest, $save_dir.$save_name, 90);
	}
	else if($img_type == 2) // jpg, jpeg
	{
		$cfile = imagecreatefromjpeg($srcname);
		if($gdver == 2)
		{
			$dest = imagecreatetruecolor($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresampled($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		else
		{
			$dest = imagecreate($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresized($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		imagejpeg($dest, $save_dir.$save_name, 90);

	}
	else if($img_type == 3) // png
	{
		$cfile = imagecreatefrompng($srcname);
		if($gdver == 2){
			$dest = imagecreatetruecolor($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresampled($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		else
		{
			$dest = imagecreate($width, $height);
			$bg = imagecolorallocate($dest, 255, 255, 255);
			imagefilledrectangle($dest, 0, 0, $width, $height, $bg);
			imagecopyresized($dest, $cfile, $srcx_s, $srcy_s, 0, 0, $dst_s_width, $dst_s_height, $img_width, $img_height);
		}
		imagepng($dest, $save_dir.$save_name, 90);
	}

	imagedestroy($dest);
	return true;
}

//파일 업로드
function upload_file($tmp_name, $up_file, $save_dir)
{
	$upfile_name = '';
	$up_ext = strtolower(substr($up_file, strrpos($up_file, '.') + 1));
	$upfile_name = uniqid('').'.'.$up_ext;

	while(true)
	{
		if(file_exists(($save_dir.$upfile_name)))
			$upfile_name = uniqid('').'.'.$up_ext;
		else
			break;
	}

	if(is_uploaded_file($tmp_name))
	{
		if(!copy($tmp_name, $save_dir.$upfile_name))
		{
			return false;
		}
	}
	else
	{
		return false;
	}
	@chmod($save_dir.$upfile_name, 0707);
	return $upfile_name;
}

function checkAry($val) {
	foreach ($val as $k => $v) {
		if (!isset($_POST[$k]) || !trim($_POST[$k])) {
			if($_POST[$k] != "0"){

				alt($v, "if(parent.document.getElementById('ajaxLoading2')){parent.document.getElementById('ajaxLoading2').style.display = 'none';}");
				exit;
			}
		}
	}
}

function sd_email($subject, $toName, $toEmail, $body,$sd_info='') {
	$charset = 'UTF-8';
	$toEmail = $toEmail;
	$fromName = 'master';
	$fromEmail = (trim($sd_info)) ? $sd_info : 'master@'.$_SERVER['HTTP_HOST'];
	$fromEmail = $fromEmail;
	$encoded_subject = "=?".$charset."?B?".base64_encode($subject)."?=\n";
	$to = "\"=?".$charset."?B?".base64_encode($toName)."?=\" <".$toEmail.">" ;
	$from = "\"=?".$charset."?B?".base64_encode($fromName)."?=\" <".$fromEmail.">" ;
	$headers = "MIME-Version: 1.0\n".
					"Content-Type: text/html; charset=".$charset."; format=flowed\n".
					"From: ".$from."\n".
					"Content-Transfer-Encoding: 8bit\n";

	$mail = mail($to, $encoded_subject, $body, $headers);
	return $mail;
}



function codeStore($val) {

	$sel = '<select id="code1" name="code1"  onchange="get_addrStore(1);">';
	$sel .= '<option value="">대분류</option>';
	$sql = ' select * from `DYB_STORE_CAT_NEW` where length(`CAT_CODE`) = 2 order by `CAT_ORDER` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['CAT_CODE']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['CAT_CODE'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['CAT_NAME']).'</option>';
		}
	}
	$sel .= '</select>';
	return $sel;
}

function codeStoreAdd($val) {

	$sel = '<select id="store_code1" name="store_code1"  onchange="get_addrStoreAdd(1);">';
	$sel .= '<option value="">대분류</option>';
	$sql = ' select * from `DYB_STORE_CAT_NEW` where length(`CAT_CODE`) = 2 order by `CAT_ORDER` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['CAT_CODE']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['CAT_CODE'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['CAT_NAME']).'</option>';
		}
	}
	$sel .= '</select>';
	return $sel;
}

function codePdt($val) {
	$sel = '<select id="codePdt1" name="codePdt1" class="addr_sel_pdt" onchange="get_addrPdt(1);">';
	$sel .= '<option value="">대분류</option>';
	$sql = ' select * from `cat_pdt` where length(`cat_code`) = 2 order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function codePdt_user($val) {
	$sel = '<select id="sub_code" name="sub_code" class="addr_sel_pdt" >';
	$sel .= '<option value="">분류</option>';
	$sql = ' select * from `cat_pdt` where length(`cat_code`) = 4 order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function sel_teacher($val) {
	$sel = '<select id="tr_id" name="tr_id">';
	$sel .= '<option value="">▒▒ TR ▒▒</option>';
	$sql = ' select * from `members` where `level` = 3 order by `mid` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['mid']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['mid'].'" '.$s.'>'.$row['mid'].' ('.$row['mname'].')</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function codeCell($val) {
	$sel = '<select id="codeCell1" name="codeCell1" class="addr_sel_cell" onchange="get_addrCell(1);">';
	$sel .= '<option value="">분원선택</option>';
	$sql = ' select * from `cat_cell` where length(`cat_code`) = 4 order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}
function codeCellMem($val) {
	$sel = '<select id="area_type" name="area_type" disabled onchange="get_addrCellMem();"  >';

	$sel .= '<option value="">분원선택</option>';
	$sql = ' select * from `cat_cell` where length(`cat_code`) = 4  order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}
function codeCellMem1($val) {
	$sel = '<select id="area_type1" name="area_type" disabled onchange="get_addrCellMem1();" ';
	if($val != "TM")
		$sel .= ' style="display:none">';
	else
		$sel .= ' >';
	$sel .= '<option value="">선택</option>';
	$sql = ' select * from `cat_cell` where length(`cat_code`) = 4 and cat_code = \'TM\' order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}
function codeCellMem2($val) {
	$sel = '<select id="area_type2" name="area_type" disabled onchange="get_addrCellMem2();" ';
	if($val == "TM")
		$sel .= ' style="display:none">';
	else
		$sel .= ' >';
	$sel .= '<option value="">분원선택</option>';
	$sql = ' select * from `cat_cell` where length(`cat_code`) = 4 and cat_code <> \'TM\' order by `cat_order` ';

	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function sel_book($val) {
	$sel = '<select id="sel_book" name="sel_book">';
	$sel .= '<option value="">▒▒ 선택 ▒▒</option>';
	$sql = ' select * from `product` order by `seq` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['seq']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['seq'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function pointAdd($md, $id,$uid) {
	$_SiteInfo_ = mysql_fetch_assoc(mysql_query(' select * from `DYB_SITE_INFO` '));
	switch ($md) {
		case 'login' :
			$chg_point = $_SiteInfo_['POINT_LOGIN'];
			$chg_title = '로그인 포인트 지급';
		break;

		case 'cell_note_w' :
			$chg_point = $_SiteInfo_['POINT_NOTE'];
			$chg_title = '학습노트 글작성 포인트 지급';
		break;

		case 'cell_after_w' :
			$chg_point = $_SiteInfo_['POINT_LECTURE'];
			$chg_title = '수강후기 글작성 포인트 지급';
		break;

		case 'cell_note_best' :
			$chg_point = $_SiteInfo_['POINT_NOTE_BEST'];
			$chg_title = '학습노트 Best 선정 포인트 지급';
		break;

		case 'cell_after_best' :
			$chg_point = $_SiteInfo_['POINT_LECTURE_BEST'];
			$chg_title = '수강후기 Best 선정 포인트 지급';
		break;

		case 'member_join' :
			$chg_point = $_SiteInfo_['POINT_MEMBER'];
			$chg_title = '회원가입 포인트 지급';
		break;
	}
	if($chg_point > 0){
		$sql = ' update `members` set `s_point` =  `s_point` + '.$chg_point.' where `mid` = \''.$id.'\' ';
		@mysql_query($sql);

		$sql = ' insert into `point` set `mid` = \''.$id.'\' , `title` = \''.iconv("UTF-8","EUC-KR",$chg_title).'\' , `point` = '.$chg_point.' , `od_seq` = '.$uid.' , `use_date` = now() ';
		@mysql_query($sql);
	}
}

function delivery_info($id) {
	return mysql_result(mysql_query(' select delivery_url from `DYB_DELIVERY_URL` where `idx` = \''.$id.'\' '),0,0);
}

function userPoint($id) {
	return mysql_result(mysql_query(' select sum(`point`) from `point` where `mid` = \''.$id.'\' '),0,0);
}

function todayPoint($id) {
	return mysql_result(mysql_query(" select -sum(point) from point where mid = '".$id."' and point < 0 and  od_seq <> 0  and date_format(use_date, '%Y%m%d' ) = date_format(curdate( ), '%Y%m%d' )  "),0,0);
}

function userPoint1($id) {
	return mysql_result(mysql_query(' select sum(`point`) from `point` where `mid` = \''.$id.'\' and `point` > 0  '),0,0);
}
function userPoint2($id) {
	return mysql_result(mysql_query(' select sum(`point`) from `point` where `mid` = \''.$id.'\' and `point` < 0  '),0,0);
}

function userPointRank($id) {
	$get_point = mysql_result(mysql_query(' select `s_point` from `members` where `mid` = \''.$id.'\' '),0,0);

	$get_rank = 0;

	$get_point = $get_point ? $get_point : 0 ;

	if ($get_point) {
		$sql = 'select (@rownum:=@rownum+1) as rank, `mid` from `members`, (select @rownum:=0) as v where `s_point` > \''.$get_point.'\' and `level` = 1 order by `s_point` desc ';
		$result = mysql_query($sql);

		$get_rank = mysql_num_rows($result)+1;

		/*
		if (mysql_num_rows($result)) {
			while ($row=  mysql_fetch_assoc($result)) {
				if ($row['mid'] == $id) {
					$get_rank = $row['rank'];
					break;
				}
			}
		}
		*/
	}

	return $get_rank;
}

function board_code($val, $onchg) {
	$sel = '<select id="s_code1" name="s_code1" onchange="'.$onchg.';">';
	$sel .= '<option value="">▒▒ 강좌 ▒▒</option>';
	$sql = ' select * from `cat` where length(`cat_code`) = 4 order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}

	$sel .= '</select>';
	return $sel;
}

function addQuota($val) {
	$res = array();

	foreach ($val as $v) {
		if (trim($v))
			$res[] = '"'.$v.'"';
	}

	return $res;
}

function _report($type) {
	if (isset($_SESSION['memid']) && trim($_SESSION['memid']) && $_SESSION['memlevel'] == 1 && trim($_SESSION['memcell']) && strlen($_SESSION['memcell']) == 4) {

		$sql = ' select * from `members` where `mid` = \''.$_SESSION['memid'].'\' and `in_cell_allow` = 1 ';
		$result = mysql_query($sql);
		if (mysql_num_rows($result)) {
			@mysql_query(' insert into `_report` set `cell_code` = \''.$_SESSION['memcell'].'\' , `type` = \''.$type.'\' , `mid` = \''.$_SESSION['memid'].'\' , `sdate` = curdate(), `stime` = date_format(now(), \'%h:%i:%s\') ');
		}
	}
}

function _sms_send($f, $s, $m) {

	$DYB = "(DESCRIPTION =
		(ADDRESS_LIST =
		  (ADDRESS = (PROTOCOL = TCP)(HOST = 14.0.84.53)(PORT = 1521))
		)
		(CONNECT_DATA =
		  (SERVICE_NAME = chsundb)
		)
	  )";
   try{
		$conn = OCILogon("dyb1", "roqkf", $DYB );
		if( !$conn )
		{
		   $err = oci_error();
		   throw new Exception($err['message']);
		}

		if (!trim($f)) {
			$f = '02-556-1604';
		}
		$qr = "	INSERT INTO SC_TRAN (
							TR_NUM ,
							TR_SENDDATE ,
							TR_SENDSTAT ,
							TR_MSGTYPE ,
							TR_PHONE ,
							TR_CALLBACK ,
							TR_MSG,
							TR_ETC1,
							TR_ETC2,
							TR_ETC3,
							TR_ETC4
						) VALUES (
							SC_TRAN_SEQ.NEXTVAL,
							SYSDATE,
							'0',
							'0',
							'".$s."',
							'".$f."',
							replace('".$m."',chr(13),chr(13)||chr(10)),
							'onstp',
							'',
							'',
							''

						) ";
		/*********** fetch ********************************/
		$stid = OCIParse($conn, $qr);
		if(!$stid) {
			$err = oci_error($stid);
			throw new Exception($err['message']);
		}
		if(!OCIExecute($stid, OCI_DEFAULT)) {
			$err = oci_error($stid);
			throw new Exception($err['message']);
		}
		ocicommit($conn);
		OCILogoff($conn);

	}catch(Exception $e) {
		print($e->getMessage());
		@ocifreestatement($stid);
		if($conn) OCILogoff($conn);
	}
}

function cell_count($code) {
	return mysql_result(mysql_query('select count(`cat_uid`) from `cat_cell` where `cat_code` != \''.$code.'\' and `cat_code` like \''.$code.'%\' '), 0, 0);
}

function cell_member_count($code) {
	return mysql_result(mysql_query('select count(`mseq`) from `members` where `cell` like \''.$code.'%\' and `level` = 1 and `state` != 1'), 0, 0);
}

function cell_tr_name($mid) {
	return @mysql_result(@mysql_query('select `mname` from `members` where `mid` = \''.$mid.'\' '), 0, 0);
}

function cell_tr_name_report($code) {
	$result = mysql_query(' select `mname` from `members` where `mid` = (select `tr_id` from `cell` where `code` = \''.$code.'\') ');

	if (mysql_num_rows($result))
		return mysql_result($result, 0, 0);
	else
		return '&nbsp;';
}

function cell_pay_day_report($id) {
	$result = mysql_query('select `sdate` from `order_list` where `od_mid` = \''.$id.'\' and `pay_status` = 1 and `order_status` = 1 order by `sdate` limit 1');

	if (mysql_num_rows($result))
		return substr(mysql_result($result, 0, 0), 0, 10);
	else
		return '&nbsp;';
}

function cell_pay_seday_report($id) {
	$result = mysql_query('select `s_day`, `e_day` from `order_list` where `od_mid` = \''.$id.'\' and `pay_status` in (1, 5) and `order_status` = 1 and `od_type` = \'l\' order by `sdate` limit 1');

	if (mysql_num_rows($result))
		return mysql_result($result, 0, 0).'<br />'.mysql_result($result, 0, 1);
	else
		return '&nbsp;';
}

function last_lecture_view($id) {
	$result = mysql_query(' select b.`m_name`, a.`sdate` from `movie_log` as a left join `movie` as b on (a.`m_seq` = b.`seq`) where a.`mid` = \''.$id.'\' order by a.`sdate` desc limit 1 ');

	if (mysql_num_rows($result))
		return '<em>'.mysql_result($result, 0, 0).'</em><br /><a>'.mysql_result($result, 0, 1).'</a>';
	else
		return '&nbsp;';
}

function report_count($code,$no) {
	return mysql_result(mysql_query('select count(`seq`) from `_report` where `cell_code` like \''.$code.'%\' and `type` = '.$no.' '), 0, 0);
}

function code($val) {

	$sel = '<select id="code1" name="code1"  onchange="get_addr(1);">';
	$sel .= '<option value="">대분류</option>';
	$sql = ' select * from `cat` where length(`cat_code`) = 2 order by `cat_order` ';
	$result = mysql_query($sql);

	if (mysql_num_rows($result)) {
		while ($row = mysql_fetch_assoc($result)) {
			$s = ($val == $row['cat_code']) ? 'selected' : '' ;
			$sel .= '<option value="'.$row['cat_code'].'" '.$s.'>'.iconv("EUC-KR","UTF-8",$row['cat_name']).'</option>';
		}
	}
	$sel .= '</select>';
	return $sel;
}





//강좌 진도율
function lecture_progress($memid,$ucc_key){
	 $sql_Leclog = "
							SELECT
								movie_log.m_seq as m_seq,
								movie.mobile_addr as mobile_addr,
								movie.pc_addr as pc_addr,
								movie_log.move_device as move_device,
								movie_log.play_cur_time as play_cur_time
							FROM
								movie_log LEFT OUTER JOIN movie ON movie_log.m_seq = movie.seq
							WHERE
								movie_log.mid = '".$memid."'
								and (movie_log.complete_flag <> '1' or movie_log.complete_flag IS NULL )
								and (movie_log.sdate > movie_log.movie_count_update OR movie_log.movie_count_update IS NULL) ";

	$result_Leclog = mysql_query($sql_Leclog);
	$i = 0;
	$addr =	"";
	$move_device =	"";
	$m_seq = "";
	while($row_log = @mysql_fetch_object($result_Leclog)) {
		if($row_log->move_device == "PC"){
			if($row_log->pc_addr){
				$addr = $row_log->pc_addr;
			}else{
				$addr = $row_log->mobile_addr;
			}
			$move_device =  "P";
		}else{
			$addr = $row_log->mobile_addr;
			$move_device =  "M";
		}
		$m_seq = $row_log->m_seq;

		$ch = curl_init();
		$agent = 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.0; Trident/5.0)';
		curl_setopt($ch, CURLOPT_URL, "http://uccapi.smartucc.kr/uccapi/Contents/get_play_info/ucc_key/".$ucc_key."/uk/".$memid."/origin/".$addr."/device/".$move_device);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt ($ch, CURLOPT_POST, 0);
		curl_setopt ($ch, CURLOPT_USERAGENT, $agent);
		curl_setopt ($ch, CURLOPT_REFERER, "");
		curl_setopt ($ch, CURLOPT_TIMEOUT, 1);
		$buffer = curl_exec ($ch);
		$cinfo = curl_getinfo($ch);
		curl_close($ch);
		 if ($cinfo['http_code'] != 200)
		 {
			$data = "";
		 }else{
			 $data = json_decode($buffer) ;
		 }


		if($data->{'code'} == "0000"){
			if($data->{'result'}->{'complete_flag'} == "1"){
				$sql_log = "
									update movie_log set
											play_cur_time = '".$data->{'result'}->{'play_cur_time'}."' ,
											complete_flag = '".$data->{'result'}->{'complete_flag'}."' ,
											complete_time = '".$data->{'result'}->{'complete_time'}."' ,
											total_play_time = '".$data->{'result'}->{'total_play_time'}."' ,
											movie_count_update = now()
										where mid = '".$memid."' and m_seq = '".$m_seq."' ";
				$result_log = mysql_query($sql_log);
			}else{
				if($row_log->play_cur_time < $data->{'result'}->{'play_cur_time'}){
					$sql_log = "
										update movie_log set
												play_cur_time = '".$data->{'result'}->{'play_cur_time'}."' ,
												complete_flag = '".$data->{'result'}->{'complete_flag'}."' ,
												complete_time = '".$data->{'result'}->{'complete_time'}."' ,
												total_play_time = '".$data->{'result'}->{'total_play_time'}."' ,
												movie_count_update = now()
											where mid = '".$memid."' and m_seq = '".$m_seq."' ";

					$result_log = mysql_query($sql_log);
				}else{
					$sql_log = "
										update movie_log set
												movie_count_update = now()
											where mid = '".$memid."' and m_seq = '".$m_seq."' ";

					$result_log = mysql_query($sql_log);
				}
			}
		}
	}
}

?>

