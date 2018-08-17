<?
class dbConnect {
	var $db_host, $db_name, $db_user, $db_pwd, $db_conn;

	function dbConnect ( $db_host, $db_name, $db_user, $db_pwd) {
		$this->db_host		= $db_host;
		$this->db_name		= $db_name;
		$this->db_user		= $db_user;
		$this->db_pwd		= $db_pwd;

		$this->db_conn = @mysql_connect( $this->db_host, $this->db_user, $this->db_pwd) or die("데이타 베이스에 접속이 불가능합니다.");
		@mysql_select_db( $this->db_name, $this->db_conn);
		@mysql_query('set names euckr');
	}

	function result ( $sql ) {
		$sql				= trim( $sql );
		$result			= @mysql_query( $sql, $this->db_conn ) or die($sql);
		return $result;
	}

	function select ( $table, $where, $field = "*" ) {
		$sql				= "Select $field from $table $where";
		$result			= $this->result( $sql );
		return $result;
	}

	function select_choice ( $table, $where, $field ) {
		$sql				= "Select $field from $table $where";
		$result			= $this->result( $sql );
		return $result;
	}

	function all_select ( $sql ) {
		$sql				= trim( $sql );
		$result		= $db->select_all( $sql);
//		$result			= $this->result( $sql );
		return $result;
	}

	function object ( $table, $where, $field = "*" ) {
		$sql				= "Select $field from $table $where";
		$result			= $this->result( $sql );
		$row			= @mysql_fetch_object($result);



		return $row;
	}

	function row ( $table, $where, $field = "*" ) {
		$sql				= "Select $field from $table $where";
		$result			= $this->result( $sql );
		$row			= @mysql_fetch_row($result);
		return $row;
	}

	function sum ( $table, $where, $field = "*" ) {
		$sql				= "Select sum($field) from $table $where";
		$result			= $this->result( $sql );
		$row			=  @mysql_fetch_row($result);
		if( $row[0] ) { return $row[0]; } else { return 0;}
	}

	function cnt ( $table, $where, $field = "idx" ) {
		$sql				= "Select count($field) from $table $where";
		$result			= $this->result( $sql );
		$row			=  @mysql_fetch_row($result);
		if( $row[0] ) { return $row[0]; } else { return 0;}
	}

	function cnt_total ( $table, $where ) {
		$sql				= "Select count(*) from $table $where";
		$result			= $this->result( $sql );
		$row			=  @mysql_fetch_row($result);
		if( $row[0] ) { return $row[0]; } else { return 0;}
	}

	function max_ ( $table, $where, $field = "idx" ) {
		$sql				= "Select max($field) from $table $where";
		$result			= $this->result( $sql );
		$row			=  @mysql_fetch_row($result);
		if( $row[0] ) { return $row[0]; } else { return 0;}
	}

	function min_ ( $table, $where, $field = "idx" ) {
		$sql				= "Select min($field) from $table $where";
		$result			= $this->result( $sql );
		$row			=  @mysql_fetch_row($result);
		if( $row[0] ) { return $row[0]; } else { return 0;}
	}

	function insert ( $table, $data ) {
		$sql				= "insert into $table set $data";
		if($this->result( $sql )) { return true; } else { return false; }
	}

	function update ( $table, $data ) {
		$sql				= "update $table set $data";
		if($this->result( $sql )) { return true; } else { return false; }
	}

	function delete ( $table, $data ) {
		$sql				= "delete from $table $data";

		if($this->result( $sql )) { return true; } else { return false; }
	}

	function dropTable ( $data ) {
		$sql				= "drop table $data";
		if($this->result( $sql )) { return true; } else { return false; }
	}

	function createTable ( $data ) {
		$sql				= "create table $data";
		if($this->result( $sql )) { return true; } else { return false; }
	}

	function stripSlash ( $str ) {
		$str				= trim( $str );
		$str				= str_replace( "rn","",$str);
		$str				= stripslashes( $str );
		return $str;
	}

	function addSlash ( $str ) {
		$str				= trim( $str );
		$str				= str_replace( "rn","",$str);
		$str				= addslashes( $str );
		if(empty( $str )) {
			$str			= "NULL";
		}
		return $str;
	}

	function addSlash_chk ( $str ) {
		$str				= trim( $str );
		$str				= str_replace( "rn","",$str);
		$str				= stripslashes( $str );
		$str				= addslashes( $str );
		$str				= mysql_real_escape_string( $str );
		return $str;
	}

	function stripSlash_chk ( $str ) {
		$str				= trim( $str );
		$str				= str_replace( "rn","",$str);
		$str				= stripslashes( $str );
		$str				= mysql_real_escape_string( $str );
		return $str;
	}

	function prints ( $table, $where, $field = "*" ) {
		echo "Select $field from $table $where<br>";
		return;
	}

	function printu ( $table, $data ) {
		echo "update $table set $data<br>";
		return;
	}

	function printi ( $table, $data ) {
		echo "insert into $table set $data<br>";
		return;
	}
}

class tools {

	// 엔코드
	function encode($data) {
		return base64_encode($data)."||";
	}
	function check_bytes($num)
	{
		$btail	= "bytes";
		$ktail	= "K";
		if($num>=1024&&$num<1048576)
		{
			$this_num = $num/1024;
			$namuji   = $num%1024;
		}
		else if($num>=1024&&$num>=1048576)
		{
			$this_num = $num/1048576;
			$namuji   = $num%1048576;
			if($namuji>=1024)
			{
				$namuji = $namuji/1024;
				$btail  = "K";
			}
			$ktail="M";
		}
		else $this_num=$num;
		echo $this->Nformat($this_num,0)."&nbsp;".$ktail."&nbsp;&nbsp;";
		if($namuji>0) echo $this->Nformat($namuji,0)." ".$btail;
	}
	function Nformat($value,$sort)
	{
		echo number_format($value,$sort);
		return;
	}
	// 디코드
	function decode($data){
		$vars=explode("&",base64_decode(str_replace("||","",$data)));
		$vars_num=count($vars);
		for($i=0;$i<$vars_num;$i++) {
			$elements=explode("=",$vars[$i]);
			$var[$elements[0]]=$elements[1];
		}
		return $var;
	}

	// 문자열 자르는 부분
	function strCut($str, $len, $checkmb=true, $tail='...') {
			preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
	  $m    = $match[0];
	  $slen = strlen($str);  // length of source string
	  $tlen = strlen($tail); // length of tail string
	  $mlen = count($m);    // length of matched characters

	  if ($slen <= $len) return $str;
	  if (!$checkmb && $mlen <= $len) return $str;

	  $ret  = array();
	  $count = 0;

	  for ($i=0; $i < $len; $i++) {
		$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
		if ($count + $tlen > $len) break;
		$ret[] = $m[$i];
	  }
	  return join('', $ret).$tail;
		}





	// 문자열 자르는 부분
	function strCutNew($str, $str_len) {
		$tmpstr = strip_tags($str);
		return mb_strimwidth($tmpstr, '0', $str_len, '..', 'utf-8');
	}


	// HTML 출력
	function strHtml($str) {
		$str = trim($str);
		$str				= str_replace( "rn","",$str);
		$str = stripslashes($str);
		return $str;
	}

	// 문자열 HTML BR 형태 출력
	function strHtmlBr($str) {
		$str = trim($str);
		$str = stripslashes($str);
		$str = str_replace("\n","<br>", $str);
		return $str;
	}

	// 문자열 TEXT 형태 출력
	function strHtmlNo($str) {
		$str = trim($str);
		$str = htmlspecialchars($str);
		$str = stripslashes($str);
		$str = str_replace("\n","<br>", $str);
		return $str;
	}

	// 문자열 TEXT 형태 출력
	function strHtmlNoBr($str) {
		$str = trim($str);
		$str = htmlspecialchars($str);
		$str = stripslashes($str);
		return $str;
	}

	// 날자출력 형태
	function strDateCut($str, $chk = 1) {
		if( $chk==1 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."/".$mon."/".$day;
		} else if( $chk==2 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."/".$mon."/".$day." ".$time.":".$minu;
		} else if( $chk==3 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."-".$mon."-".$day;
		} else if( $chk==4 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."-".$mon."-".$day." ".$time.":".$minu;
		} else if( $chk==5 ) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year."년 ".$mon."월 ".$day."일";
		} else if( $chk==6) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$time	=	substr($str,11,2);
			$minu	=	substr($str,14,2);
			$str	=	$year."년 ".$mon."월 ".$day."일 ".$time."시 ".$minu."분";
		} else if( $chk==7) {
			$year	=	substr($str,0,4);
			$mon	=	substr($str,5,2);
			$day	=	substr($str,8,2);
			$str	=	$year.".".$mon.".".$day;
		}
		return $str;
	}

	// 숫자로 된 값을 요일로 변환한다. (0:월요일, 1:화요일, 6:일요일)
	function strDateWeek($chk) {
		if( $chk==0 ) {
			$str="월요일";
		} else if( $chk==1 ) {
			$str="화요일";
		} else if( $chk==2 ) {
			$str="수요일";
		} else if( $chk==3 ) {
			$str="목요일";
		} else if( $chk==4 ) {
			$str="금요일";
		} else if( $chk==5 ) {
			$str="토요일";
		} else if( $chk==6) {
			$str="일요일";
		}
		return $str;
	}

	# E-MAIL 주소가 정확한 것인지 검사하는 함수
	#
	# eregi - 정규 표현식을 이용한 검사 (대소문자 무시)
	#         http://www.php.net/manual/function.eregi.php
	# gethostbynamel - 호스트 이름으로 ip 를 얻어옴
	#          http://www.php.net/manual/function.gethostbynamel.php
	# checkdnsrr - 인터넷 호스트 네임이나 IP 어드레스에 대응되는 DNS 레코드를 체크함
	#          http://www.php.net/manual/function.checkdnsrr.php
	function chkMail($email,$hchk=0) {
		$url = trim($email);
		if($hchk) {
			$host = explode("@",$url);
			if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) {
				if(checkdnsrr($host[1],"MX") || gethostbynamel($host[1])) return $url;  else return false;
			}
		} else {
			if(eregi("^[\xA1-\xFEa-z0-9_-]+@[\xA1-\xFEa-z0-9_-]+\.[a-z0-9._-]+$", $url)) return $url;  else return false;
		}
	}
	// 주민등록번호진위여부 확인 함수
	function chkJumin($resno1,$resno2) {
		$resno = $resno1.$resno2;
		$len = mb_strlen($resno);
		if ($len <> 13) return false;
		if (!ereg('^[[:digit:]]{6}[1-4][[:digit:]]{6}$', $resno)) return false;
		$birthYear = ('2' >= $resno[6]) ? '19' : '20';
		$birthYear += substr($resno, 0, 2);
		$birthMonth = substr($resno, 2, 2);
		$birthDate = substr($resno, 4, 2);
		if (!checkdate($birthMonth, $birthDate, $birthYear)) return false;
		for ($i = 0; $i < 13; $i++) $buf[$i] = (int) $resno[$i];
		$multipliers = array(2,3,4,5,6,7,8,9,2,3,4,5);
		for ($i = $sum = 0; $i < 12; $i++) $sum += ($buf[$i] *= $multipliers[$i]);
		if ((11 - ($sum % 11)) % 10 != $buf[12]) return false;
		return true;
	}

	// 사업자등록번호 체크 함수
	function chkCompany($reginum) {
		$weight = '137137135';
		$len = mb_strlen($reginum);
		$sum = 0;
		if ($len <> 10) return false;
		for ($i = 0; $i < 9; $i++) $sum = $sum + (substr($reginum,$i,1)*substr($weight,$i,1));
		$sum = $sum + ((substr($reginum,8,1)*5)/10);
		$rst = $sum%10;
		if ($rst == 0) $result = 0;
		else $result = 10 - $rst;
		$saub = substr($reginum,9,1);
		if ($result <> $saub) return false;
		return true;
	}

	# 문자열에 한글이 포함되어 있는지 검사하는 함수
	function chkHan($str) {
		# 특정 문자가 한글의 범위내(0xA1A1 - 0xFEFE)에 있는지 검사
		$strCnt=0;
		while( strlen($str) >= $strCnt) {
			$char = ord($str[$strCnt]);
			if($char >= 0xa1 && $char <= 0xfe) return true;
			$strCnt++;
		}
	}

	// 문자열 체크(숫자)
	function chkDigit($str) {
		if(ereg("^[1-9]+[0-9]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파)
	function chkAlpha($str) {
		if(ereg("^[a-zA-Z]+[a-zA-Z]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파+숫자)
	function chkAlnum($str) {
		if(ereg("^[1-9a-zA-Z]+[0-9a-zA-Z]*$",$str))  return true;
		else return false;
	}

	// 문자열 체크(알파+숫자+특수문자)
	function chkAlnumAll($str) {
		if(ereg("^[1-9a-zA-Z_-]+[0-9a-zA-Z_-]*$",$str))  return true;
		else return false;
	}

	// 메세지 출력
	function msg($msg) {
		echo "<script language='javascript'> alert('$msg'); </script>";
	}

	function script($msg) {
		echo "<script language='javascript'> $msg </script>";
	}

	// 메세지 출력후 BACK
	function errMsg($msg) {
		echo "<script language='javascript'> alert('$msg'); window.history.back(); </script>";
		exit();
	}

	// 메세지 출력후 이동하는 자바스크립트
	function alertJavaGo($msg,$url) {
		echo "<script language='javascript'> alert('$msg'); location.replace('$url'); </script>";
		exit();
	}

	// 메세지 출력후 이동하는 메타테그
	function alertMetaGo($msg,$url) {
		echo "<script language='javascript'> alert('$msg'); </script>";
		echo "<meta http-equiv='refresh' content='0;url=$url'>";
		exit();
	}

	// 메타태그로 바로 가기
	function metaGo($url) {
		echo "<meta http-equiv='refresh' content='0;url=$url'>";
		exit();
	}

	// 자바스크립트로 바로 가기
	function javaGo($url) {
		echo "<script language='javascript'> location.href='$url'; </script>";
		exit();
	}

	// 창을 닫기
	function winClose() {
		echo "<script language='javascript'> window.close(); </script>";
		exit();
	}

	// 메세지 출력후 창을 닫기
	function msgClose($msg) {
		echo "<script language='javascript'> alert('$msg'); window.close(); </script>";
		exit();
	}


	// 메세지 출력후 창을 닫고 오프너 리로드하기
	function msgClosereload($msg) {
		echo "<script language='javascript'> alert('$msg'); opener.location.reload(); window.close(); </script>";
		exit();
	}

	// 창을 닫고 가는 함수
	function javaGoClose($url) {
		echo "<script language='javascript'> opener.location.replace('$url'); self.close(); </script>";
		exit();
	}

	// 프레임으로 된 경우 상위 프레임으로 가는 함수
	function javaGoTop($url) {
		echo "<script language='javascript'> parent.frames.top.location.replace('$url'); </script>";
		exit();
	}
}
	// 원본 이미지 -> 썸네일로 만드는 함수
function thumnail($file, $save_filename, $save_path, $max_width, $max_height, $bcor)
{
	$ratio=$max_width/$max_height;
       $img_info = getImageSize($file);
		if($img_info[2] == 1)
		{
			$src_img = ImageCreateFromGif($file);
		}elseif($img_info[2] == 2){
			$src_img = ImageCreateFromJPEG($file);
		}elseif($img_info[2] == 3){
			$src_img = ImageCreateFromPNG($file);
		}else{
			return 0;
		}
       $img_width = $img_info[0];
       $img_height = $img_info[1];

/*	   if($max_width>$img_width && $max_height>$img_height){
		   if($img_width/3 >=$img_height/4){
			   $max_width=$img_width;
			   $max_height=ceil($img_width*4/3);
		   }
		   else {
			   $max_height=$img_height;
			   $max_width=ceil($img_height*3/4);
		   }
	   } */

       if($img_width > $max_width || $img_height > $max_height)
       {
              if($img_width == ceil($img_height*$ratio))
              {
                     $dst_width = $max_width;
                     $dst_height = $max_height;
              }elseif($img_width > ceil($img_height*$ratio)){
                     $dst_width = $max_width;
                     $dst_height = ceil(($max_width / $img_width) * $img_height);
              }else{
                     $dst_height = $max_height;
                     $dst_width = ceil(($max_height / $img_height) * $img_width);
              }
       }else{
              $dst_width = $img_width;
              $dst_height = $img_height;
       }
       if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
       if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

       if($img_info[2] == 1)
       {
              $dst_img = imagecreate($max_width, $max_height);
       }else{
              $dst_img = imagecreatetruecolor($max_width, $max_height);
       }

       $bgc = ImageColorAllocate($dst_img, $bcor, $bcor, $bcor);
       ImageFilledRectangle($dst_img, 0, 0, $max_width, $max_height, $bgc);
       ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

       if($img_info[2] == 1)
       {
              ImageInterlace($dst_img);
              ImageGif($dst_img, $save_path.$save_filename);
       }elseif($img_info[2] == 2){
              ImageInterlace($dst_img);
              ImageJPEG($dst_img, $save_path.$save_filename);
       }elseif($img_info[2] == 3){
              ImagePNG($dst_img, $save_path.$save_filename);
       }
       ImageDestroy($dst_img);
       ImageDestroy($src_img);
}


function orderID(){
   mt_srand((double)microtime()*1000000);
   $orderID=chr(mt_rand(65, 90));
   $orderID.=chr(mt_rand(65, 90));
   $orderID.=chr(mt_rand(65, 90));
   $orderID.=chr(mt_rand(65, 90));
   $orderID.=chr(mt_rand(65, 90));
   $orderID.=time();

   return $orderID;
}


class Page {
	function Page_class( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes'  class='move go_first no_ml'></a> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes'  class='move go_prev'></a> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes'  class=''>$pageNum</a> ";
					} else {
						echo "<a href='#none' class='active'>$pageNum</a> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' class='move go_next'></a> ";
			}
			//마지막페이지
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' class='move go_last'></a>";
		}
		if( $totalList <= $listScale) {
			echo "<a href='#none' class='active'>1</a>";
		}
	}
	function Page_default( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li class='btn btnFirst'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes'  >$fistImgName</a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li class='btn btnPrev'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes'  >$prexImgName</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li class='btn btnNext'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' >$nextImgName</a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li class='btn btnLast'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' >$lastImgName</a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}
	function Page_ajax( $totalPage, $totalList, $listScale, $pageScale, $startPage, $search_itmes, $mode) {
		if( $totalList > $listScale ) {
			//첫페이지
			$page_echo .= "<li class='btn btnFirst'><a href='javascript:searchAjaxList(0,$mode);'   title='처음'></a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				$page_echo .= "<li class='btn btnPrev'><a href='javascript:searchAjaxList($prePage,$mode);' title='이전' ></a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						$page_echo .= "<li><a href='javascript:searchAjaxList($nextPage,$mode);' >$pageNum</a></li> ";
					} else {
						$page_echo .= "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				$page_echo .= "<li class='btn btnNext'><a href='javascript:searchAjaxList($nNextPage,$mode);' title='다음'></a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			$page_echo .= "<li class='btn btnLast'><a href='javascript:searchAjaxList($last_page,$mode);' title='마지막'></a></li>";
		}
		if( $totalList <= $listScale) {
			$page_echo .= "<li><strong>1</strong></li>";
		}
		return  $page_echo;
	}
	function Page_ajax_pedia( $totalPage, $totalList, $listScale, $pageScale, $startPage, $search_itmes, $mode) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li class='btn btnFirst'><a href='javascript:searchAjaxList(0,$mode);'   title='처음'></a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li class='btn btnPrev'><a href='javascript:searchAjaxList($prePage,$mode);' title='이전' ></a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='javascript:searchAjaxList($nextPage,$mode);' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li class='btn btnNext'><a href='javascript:searchAjaxList($nNextPage,$mode);' title='다음'></a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li class='btn btnLast'><a href='javascript:searchAjaxList($last_page,$mode);' title='마지막'></a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}


	function Page_default_pedia( $totalPage, $totalList, $listScale, $pageScale, $startPage, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li class='btn btnFirst'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes'   title='처음'></a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li class='btn btnPrev'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes' title='이전' ></a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li class='btn btnNext'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' title='다음'></a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li class='btn btnLast'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' title='마지막'></a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}


	function Page_default_onstp( $totalPage, $totalList, $listScale, $pageScale, $startPage, $search_itmes) {
		if( $totalList > $listScale ) {
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li class='btn'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes'  >PREV</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li class='btn'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' >NEXT</a></li> ";
			}
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}
	function Page_default_sub( $totalPage, $totalList, $listScale, $pageScale, $sub_startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li class='btn btnFirst'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&sub_startPage=0$search_itmes'  >$fistImgName</a></li> ";
			if( $sub_startPage+1 > $listScale*$pageScale ) {
				$prePage = $sub_startPage - $listScale * $pageScale;
				echo "<li class='btn btnPrev'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&sub_startPage=$prePage$search_itmes'  >$prexImgName</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $sub_startPage ) {
						echo "<li><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&sub_startPage=$nextPage$search_itmes' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li class='btn btnNext'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&sub_startPage=$nNextPage$search_itmes' >$nextImgName</a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li class='btn btnLast'><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&sub_startPage=".$last_page."$search_itmes' >$lastImgName</a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}
	function Page_student( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li ><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes'  >$fistImgName</a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li ><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes'  >$prexImgName</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li ><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' >$nextImgName</a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li ><a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' >$lastImgName</a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}

	function Page_student_sms( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<li ><a href='javascript:paging_sms(0);'  >$fistImgName</a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "<li ><a href='javascript:paging_sms($prePage);'  >$prexImgName</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<li><a href='javascript:paging_sms($nextPage);' >$pageNum</a></li> ";
					} else {
						echo "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "<li ><a href='javascript:paging_sms($nNextPage);' >$nextImgName</a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "<li ><a href='javascript:paging_sms($last_page);' >$lastImgName</a></li>";
		}
		if( $totalList <= $listScale) {
			echo "<li><strong>1</strong></li>";
		}
	}


	function Page_student_ajax( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			$page_echo .= "<li ><a href='javascript:cmtListPage(0);'>$fistImgName</a></li> ";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				$page_echo .=  "<li ><a href='javascript:cmtListPage($prePage);'>$prexImgName</a></li> ";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						$page_echo .= "<li><a href='javascript:cmtListPage($nextPage);'>$pageNum</a></li> ";
					} else {
						$page_echo .= "<li><strong>$pageNum</strong></li> ";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				$page_echo .= "<li ><a href='javascript:cmtListPage($nNextPage);' >$nextImgName</a></li> ";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			$page_echo .= "<li ><a href='javascript:cmtListPage($last_page);' >$lastImgName</a></li>";
		}
		if( $totalList <= $listScale) {
			$page_echo .= "<li><strong>1</strong></li>";
		}
		return  $page_echo;
	}
	function Page_default_admin( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes' onfocus=this.blur()>$fistImgName</a>&nbsp;&nbsp;";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes' onfocus=this.blur()>$prexImgName</a>&nbsp;&nbsp;";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' onfocus=this.blur()> $pageNum </a>";
					} else {
						echo "<font color='#000000'>&nbsp;<b>$pageNum</b>&nbsp;</font>";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' onfocus=this.blur()>$nextImgName</a>&nbsp;&nbsp;";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' onfocus=this.blur()>$lastImgName</a>&nbsp;&nbsp;";
		}
		if( $totalList <= $listScale) {
			echo "<b><font color='#000000'>1</font></b>";
		}
	}
	//CSS적용시 사용
	function Page_default_class( $totalPage, $totalList, $listScale, $pageScale, $startPage, $pre_end, $pre, $next, $next_end, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes' onfocus=this.blur() class='$pre_end'>맨앞</a>";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes' onfocus=this.blur() class='$pre_end'>이전</a>";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' onfocus=this.blur()> [$pageNum] </a>";
					} else {
						echo "<font color='#000000'><strong>[$pageNum]</strong></font>";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' onfocus=this.blur() class='$next'>다음</a>";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=".$last_page."$search_itmes' onfocus=this.blur() class='$next_end'>맨뒤</a>";
		}
		if( $totalList <= $listScale) {
			echo "<strong><font color='#000000'>1</font></strong>";
		}
	}

	function Page_Old_Good( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=0$search_itmes' onfocus=this.blur()>$fistImgName</a>&nbsp;&nbsp;";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$prePage$search_itmes' onfocus=this.blur()>$prexImgName</a>&nbsp;&nbsp;";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						echo "<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nextPage$search_itmes' onfocus=this.blur()> [$pageNum] </a>";
					} else {
						echo "<font color='#000000'>&nbsp;<b>[$pageNum]</b>&nbsp;</font>";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$nNextPage$search_itmes' onfocus=this.blur()>$nextImgName</a>&nbsp;&nbsp;";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			echo "&nbsp;<a href='$_SERVER[PHP_SELF]?goPage=$_GET[goPage]&startPage=$last_page$search_itmes' onfocus=this.blur()>$lastImgName</a>&nbsp;&nbsp;";
		}
		if( $totalList <= $listScale) {
			echo "<b><font color='#000000'>1</font></b>";
		}
	}


	function board( $totalPage, $totalList, $listScale, $pageScale, $startPage, $fistImgName, $prexImgName, $nextImgName, $lastImgName, $search_itmes) {
		if( $totalList > $listScale ) {
			//첫페이지
			$mv_data=$this->encode("startPage=0");
			echo "<a href='$_SERVER[PHP_SELF]?board_data=$mv_data&search_items=$search_itmes' onfocus=this.blur()>$fistImgName</a>&nbsp;&nbsp;";
			if( $startPage+1 > $listScale*$pageScale ) {
				$prePage = $startPage - $listScale * $pageScale;
				$mv_data=$this->encode("startPage=".$prePage);
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?board_data=$mv_data&search_items=$search_itmes' onfocus=this.blur()>$prexImgName</a>&nbsp;&nbsp;";
			}
			for( $j=0; $j<$pageScale; $j++ ) {
				$nextPage = ($totalPage * $pageScale + $j) * $listScale;
				$pageNum = $totalPage * $pageScale + $j+1;
				if( $nextPage < $totalList ) {
					if( $nextPage!= $startPage ) {
						$mv_data=$this->encode("startPage=".$nextPage);
						echo "<a href='$_SERVER[PHP_SELF]?board_data=$mv_data&search_items=$search_itmes' onfocus=this.blur()> [$pageNum] </a>";
					} else {
						echo "<font color='#000000'>&nbsp;<b>[$pageNum]</b>&nbsp;</font>";
					}
				}
			}
			if( $totalList > (($totalPage+1) * $listScale * $pageScale)) {
				$nNextPage = ($totalPage+1) * $listScale * $pageScale;
				$mv_data=$this->encode("startPage=".$nNextPage);
				echo "&nbsp;<a href='$_SERVER[PHP_SELF]?board_data=$mv_data&search_items=$search_itmes' onfocus=this.blur()>$nextImgName</a>&nbsp;&nbsp;";
			}
			//마지막페이지
			if($totalList%$listScale == "0"){
				$last_page = floor($totalList/$listScale) -1;
			}else{
				$last_page = floor($totalList/$listScale) ;
			}
			$mv_data=$this->encode("startPage=".$last_page);
			echo "&nbsp;<a href='$_SERVER[PHP_SELF]?board_data=$mv_data&search_items=$search_itmes' onfocus=this.blur()>$lastImgName</a>&nbsp;&nbsp;";
		}
		if( $totalList <= $listScale) {
			echo "<b><font color='#000000'>1</font></b>";
		}
	}
}

// 숫자를 이미지로 변환함수
function Number_Image($num, $week) {
	$split = preg_split("//",trim($num),-1,PREG_SPLIT_NO_EMPTY);  //숫자 하나씩 자름

	for($i=0;$i<count($split);$i++) {   //자른 숫자에 해당하는 그림표현
		$result .= "<img src='./img/date/before_list_".$split[$i].".gif'>";
	}

	return $result;
}

// 월를 이미지로 변환함수
function Month_Image($num) {
			$result = "<img src='./img/date/before_month_".$num.".gif'>";
	return $result;
}
// 주차를 이미지로 변환함수
function Week_Image($num) {
			$result = "<img src='./img/date/before_week_".$num.".gif'>";
	return $result;
}
// 날짜를 이미지로 변환함수
function Day_Image($num, $week) {
		if($week==0){
			$result = "<img src='./img/date/before_list_".$num."_on.gif'>";
		}else{
			$result = "<img src='./img/date/before_list_".$num.".gif'>";
		}

	return $result;
}
// 숫자를 이미지로 변환함수
function Date_Image($num) {
	$split = preg_split("//",trim($num),-1,PREG_SPLIT_NO_EMPTY);  //숫자 하나씩 자름

	for($i=0;$i<count($split);$i++) {   //자른 숫자에 해당하는 그림표현
		$result .= "<img src='./img/date/sell_num_0".$split[$i].".gif'>";
	}

	return $result;
}

function d_day($m,$d,$y) {
	$now = time();
	$dday = mktime(0,0,0,$m,$d,$y);
	$xday = ceil(($dday-$now)/(60*60*24));

	$result = "<img src='d_day.jpg'>";  //D- 그림표현

	$split = preg_split("//",trim($xday),-1,PREG_SPLIT_NO_EMPTY);  //숫자 하나씩 자름

	for($i=0;$i<count($split);$i++) {   //자른 숫자에 해당하는 그림표현
		$result .= "<img src='./img/date/before_list_".$split[$i].".gif'>";
	}

	return $result;
}

//페이지 공백 공각
function table_space($height){
	echo "
		<table border='0' cellspacing='0' cellpadding='0'>
			<tr>
				<td height='$height'>&nbsp;</td>
			</tr>
		</table>
	";
}

// password encode
function pass_encode($data) {
	$data = trim($data);

	if($data == "") {
		$return_data = "";
	} else {
		$return_data = base64_encode($data);
	}
	return $return_data;
}

// password decode
function pass_decode($data) {
	$data = trim($data);

	if($data == "") {
		$return_data = "";
	} else {
		$return_data = base64_decode($data);
	}
	return $return_data;
}


function ftp_upload($server, $port, $id, $pw, $localfile, $remotefilename, $type=FTP_BINARY){

	$conn_id = ftp_connect($server, $port);
    $login_result = ftp_login($conn_id, $id, $pw);
    ftp_pasv($conn_id, true);

    if (ftp_put($conn_id, $remotefilename, $localfile, $type)) {
	//	 echo "successfully uploaded $localfile to $remotefilename\n";
    } else {
		//echo "There was a problem while uploading $localfile\n";
    }
    ftp_close($conn_id);

}

//ftp 파일 삭제
function ftp_del($server, $port, $id, $pw, $file){
   //@unlink($file);

   $conn_id = ftp_connect($server, $port);
   $login_result = ftp_login($conn_id, $id, $pw);

   $res = ftp_size($conn_id, $file); //파일사이즈를 통해서 먼저 파일이 있는지 없는지 확인한다.
   if($res!='-1'){ //만약에 파일사이즈가 있는경우라면 삭제를 실행시킨다.
  if(ftp_delete($conn_id, $file)){
//    echo "$file deleted successful";
  }else{
//    echo "could not delete $file";
  }
   }
    ftp_close($conn_id);

}

//로컬  파일 삭제
function ftp_del_local($file){
   @unlink($file);
}

//ftp 파일 확인
function ftp_search($server, $port, $id, $pw, $file){
   $conn_id = ftp_connect($server, $port);
   $login_result = ftp_login($conn_id, $id, $pw);
    $res = ftp_size($conn_id, $file);
   if($res!='-1'){
		$str = "true";
   }else{
	   $str = "false";
   }
   return $str;
   /*
   $conn_id = ftp_connect($server, $port);
   $login_result = ftp_login($conn_id, $id, $pw);

   $res = ftp_size($conn_id, $file); //파일사이즈를 통해서 먼저 파일이 있는지 없는지 확인한다.
   if($res!='-1'){ //만약에 파일사이즈가 있는경우라면 삭제를 실행시킨다.
  if(ftp_delete($conn_id, $file)){
  //  echo "$file deleted successful";
  }else{
   // echo "could not delete $file";
  }
   }
    ftp_close($conn_id);
	*/
}

//전화번호 하이픈 생성
function tel_hyphen($hp_no){
	return preg_replace("/(0(?:2|[0-9]{2}))([0-9]+)([0-9]{4}$)/", "\\1-\\2-\\3", $hp_no);
}

//토탈일 구하기
function TotalDay($date)
{
	$date = date('t',strtotime($date));
	return $date;
}

// 요일 구하기
function WeekDay($date)
{
	$week = array("일요일","월요일","화요일","수요일","목요일","금요일","토요일");
	return $week[$date];
}

// 요일 구하기
function WeekDayDate($date)
{
	$week = array("일","월","화","수","목","금","토");
	$yoil = date("w", mktime(0,0,0,substr($date,4,2),substr($date,6,2),substr($date,0,4)));
	return $week[$yoil];
}
// 특수문자 / 제거
function stripSlash ( $str )
{
	$str				= trim( $str );
	$str				= stripslashes( $str );
	return $str;
}

// 특수문자 / 추가
function addSlash ( $str )
{
	$str				= trim( $str );
	$str				= addslashes( $str );


	return $str;
}

function htmlNotice($str){
	return str_replace(chr(10),"</br>",str_replace(chr(13),"</br>",str_replace('&quot;','"',preg_replace("(\<(/?[^\>]+)\>)", "", strip_tags(stripSlash(str_replace("</br>",chr(13),$str)))))));
}


?>
