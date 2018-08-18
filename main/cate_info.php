<?
if($SUBJECT_CD){
	$SEARCH_DETAIL .= "  AND left(b.code,2) = '".$SUBJECT_CD."'  ";
}
if($YEAR_CD){
	$SEARCH_DETAIL .= "  AND (select YEAR.cat_name from cat as YEAR where   left(YEAR.cat_code,4) = left(b.code,4)  and length(CAT_CODE) = '4'  ) = '".iconv("UTF-8","EUC-KR",$YEAR_CD)."'  ";
}
if($PRESS_CD){
	$SEARCH_DETAIL .= "  AND c.cat_name = '".iconv("UTF-8","EUC-KR",$PRESS_CD)."'  ";
}
$search = "&SUBJECT_CD=$SUBJECT_CD&YEAR_CD=$YEAR_CD&PRESS_CD=$PRESS_CD&DATA=$DATA";
?>

<?
$SQL = "
 select
		a.*,
		e.*,
		b.cat_name as class_name ,
		c.cat_order as class_img_no ,
		d.name as book_name,
		d.price as book_price
	from
		class as a
		left join cat as b on (a.code = b.cat_code)
		left join cat as c on (left(a.code,4) = c.cat_code)
		left join product as d on (a.book = d.seq)
		left join DYB_CLASS_LEVEL as e on (a.code = e.CODE)
	where a.code = '".$class_code."'
	";
$lecture_info = mysql_fetch_object(mysql_query($SQL));
if (trim($lecture_info->sample_list)) {
	$get_sample_list = explode(',', $lecture_info->sample_list);
	shuffle($get_sample_list);
	$get_sample = array_pop($get_sample_list);
}
if (isset($get_sample) && is_numeric($get_sample)) {
	$sql1 = " select
						*
					from
						movie
					where
						seq = '".$get_sample."' ";
		
	$result1 = mysql_query($sql1);
	$sample_info = mysql_fetch_object($result1);
	if($sample_info->pc_addr){
		$sample_info_key = $sample_info->pc_addr;
	}else{
		$sample_info_key = $sample_info->mobile_addr;
	}
}
?>

<?
include_once("../include/quickmenu.inc.php");
?>

<!-- 퀵메뉴를 제외한 몸통부분 -->
<div id="wrap">
    <!-- #header -->
    <div id="header">
		<h1><a href="../main/main.php"><img src="../images/common/h1_logo.png" alt="" /></a></h1>
		<div id="btnGnb">메뉴 열고 닫기</div>
		<div class="btnToggleMenu"><a href="#none"><img src="../images/common/btn_toggle_menu_1.png" alt="" /></a></div>
	</div>
	<!-- /#header -->

	<?php
	// 메뉴 항목 포함
		include_once("../include/menu.inc.php");
	?>

	<!-- .twoDepthMenu 메뉴 갯수에 따라 class="size_갯수" -->
	<div class="twoDepthMenu size_5">
		<ul>
			<li class="active"><a href="sub.php?goPage=cate_list&menu_code=2_21&sub_code=">전체강좌</a></li>
			<li class=""><a href="#none">중1 내신</a></li>
			<li class=""><a href="#none">중2 내신</a></li>
			<li class=""><a href="#none">중3 내신</a></li>
			<li class=""><a href="#none">교재</a></li>
		</ul>
	</div>
	<!-- /.twoDepthMenu 메뉴 갯수에 따라 class="size_갯수" -->

    <div class="innerWrap pdb30">
		<!-- .boardSearch -->
		<div class="boardSearch">
			<div class="in" style="width:100%;">
				<form name="search_form" method="get" action="<?=$_SERVER[PHP_SELF];?>" class="ajax"  onkeydown="if(event.keyCode==13) return false;">
				<input type="hidden" name = "goPage" value="<?=$goPage;?>">
				<input type="hidden" name = "menu_code" value="<?=$menu_code;?>">
				<input type="hidden" name = "sub_code" value="<?=$sub_code;?>">
				<input type="hidden" name = "class_code" value="<?=$class_code;?>">
				<select style="width:32%;" name = "SUBJECT_CD"  id = "SUBJECT_CD"  onchange="comboboxAjax('CLASS_CD',this.form,'','<?=$class_code;?>');">
						<option value ="" <?if($SUBJECT_CD == "" || !$SUBJECT_CD){?>selected<?}?>>교과</option>
						<?
						$result_com	= $db->select_choice( " cat ","WHERE  length(cat_code) = '2' ORDER BY cat_order ASC", " * ");
						$i = 1;
						while( $row = mysql_fetch_object($result_com)) {
						?>
						<option value="<?=$row->cat_code;?>" <?if($SUBJECT_CD == $row->cat_code){?>selected<?}?>><?= iconv("EUC-KR","UTF-8",$row->cat_name);?></option>
						<?
						}
						?>
					</select>
					<select style="width:32%;" name = "YEAR_CD"  id = "YEAR_CD"   onchange="comboboxAjax('CLASS_CD',this.form,'','<?=$class_code;?>');">
						<option value ="" <?if($YEAR_CD == "" || !$YEAR_CD){?>selected<?}?>>학년</option>
						<?
						$result_com	= $db->select_choice( " cat ","WHERE  length(cat_code) = '4' GROUP BY cat_name ORDER BY cat_name ASC", " * ");
						$i = 1;
						while( $row = mysql_fetch_object($result_com)) {
						?>
						<option value="<?= iconv("EUC-KR","UTF-8",$row->cat_name);?>" <?if($YEAR_CD == iconv("EUC-KR","UTF-8",$row->cat_name)){?>selected<?}?>><?= iconv("EUC-KR","UTF-8",$row->cat_name);?></option>
						<?
						}
						?>
					</select>
					<select style="width:32%;" name = "PRESS_CD"  id = "PRESS_CD"   onchange="comboboxAjax('CLASS_CD',this.form,'','<?=$class_code;?>');">
						<option value ="" <?if($PRESS_CD == "" || !$PRESS_CD){?>selected<?}?>>출판사</option>
						<?
						$result_com	= $db->select_choice( " cat ","WHERE  length(cat_code) = '6' GROUP BY cat_name ORDER BY cat_name ASC", " * ");
						$i = 1;
						while( $row = mysql_fetch_object($result_com)) {
						?>
						<option value="<?= iconv("EUC-KR","UTF-8",$row->cat_name);?>" <?if($PRESS_CD == iconv("EUC-KR","UTF-8",$row->cat_name)){?>selected<?}?>><?= iconv("EUC-KR","UTF-8",$row->cat_name);?></option>
						<?
						}
						?>
					</select>
				<select style="width:97.5%;" name ="CLASS_CD"  id = "CLASS_CD" onchange="javascript:cateInfoChange();"  >
					<option value ="" <?if($class_code == "" || !$class_code){?>selected<?}?>>강좌 선택</option>
					<?
				$lec3_result = $db->select_choice( "DYB_CLASS_DISPLAY_NEW as a left outer join class as b on a.class_code = b.code left outer join cat as c on c.cat_code = b.code
left outer join DYB_STORE_CAT_NEW as d on a.store_code = d.CAT_CODE left outer join DYB_STORE_CAT_NEW as e on left(a.store_code,4) = e.CAT_CODE  left outer join product  on b.book = product.seq

", "where 1=1 ".$SEARCH_DETAIL." order by  e.CAT_ORDER asc, b.LECTURE_NM asc","a.*,b.*,e.CAT_NAME as cname1 ,d.CAT_NAME as cname2 , product.name as book_name , product.price as book_price");
				while( $lec3_row = @mysql_fetch_object($lec3_result) ) { 	
					?>
					<option value="<?= $lec3_row->class_code;?>" <?if($class_code == $lec3_row->class_code){?>selected<?}?>><?= iconv("EUC-KR","UTF-8",$lec3_row->LECTURE_NM);?></option>
					<?
					}
					?>
				</select>
				</form>
			</div>
		</div>
		<!-- /.boardSearch -->
	</div>


	<div style="height:496px;  <?if($lecture_info->LECTURE_BASIC_IMAGE_PC) { ?>background:url(../data/lecture/<?=$lecture_info->LECTURE_BASIC_IMAGE_PC;?>)<?}else{?>background:url(../images/board/img_lecture_no.jpg)<?}?> no-repeat center 0;">
		<div class="innerWrap">
			<?if($sample_info_key){?>
			<div class="moviePalyer" style="box-shadow:0px 5px 7px rgba(0,0,0,0.5); position:absolute; top:267px; right:0;">
			<iframe id ="gabiaPlayer" width="387px" height="203px" src="http://play.smartucc.kr/player.php?origin=<?=$sample_info_key;?>&view_type=iframe&width=387&height=203" frameborder="0" allowfullscreen></iframe>	
			</div>
			<?}?>
		</div>
	</div>

	<div class="lectureTopDetailed">
		<div class="innerWrap">
			<dl>
				<dt>난이도</dt>
				<dd><?=$level_type_ary[$lecture_info->LEVEL];?></dd>
			</dl>
			<dl>
				<dt>강의수</dt>
				<dd><?=$lecture_info->LECTURE_CNT;?>강</dd>
			</dl>
			<dl>
				<dt>수강기간</dt>
				<dd><?=iconv("EUC-KR","UTF-8",$lecture_info->LECTURE_MONTH);?>개월</dd>
			</dl>
			<div class="right">
				<div>
					<ul>
						<? if($lecture_info->dc_type == "Y") { ?><li><span class="dt">비재원생 할인가</span>:<span class="dd"><?=($lecture_info->dc_price)?number_format($lecture_info->dc_price).' 원':'무료강좌'?></span></li><?}?>
						<? if($lecture_info->dyb_dc_type == "Y"){ ?><li><span class="dt">재원생 할인가</span>:<span class="dd"><?=($lecture_info->dyb_dc_price)?number_format($lecture_info->dyb_dc_price).' 원':'무료강좌'?></span></li><?}?>
					</ul>
				</div>
				<div class="fixedPrice">
					<ul>
						<li><? if($lecture_info->dc_type == "Y" || $lecture_info->dyb_dc_type == "Y") { ?><del><?}?>정가 : <?=($lecture_info->price)?number_format($lecture_info->price).' 원':'무료강좌'?><? if($lecture_info->dc_type == "Y" || $lecture_info->dyb_dc_type == "Y") { ?></del><?}?></li>
					</ul>
				</div>
			</div>
		</div>
	</div>


	<div class="innerWrap">
		<div class="lectureTopCartArea">
			<?if($lecture_info->book_name){?>
			<div class="check">
				<ul>
					<li class="first">관련 교재 :  <a href="sub.php?goPage=book_info&menu_code=2_22&book_code=<?=$lecture_info->book?>"><?=iconv("EUC-KR","UTF-8",$lecture_info->book_name);?></a></li>
					<?
					//교재잔여수량 확인
					$SQL_BOOK = "	
							SELECT
								product.qty
							FROM
								product
							WHERE
								product.seq = '".$lecture_info->book."'  ";

					$book_info = mysql_fetch_object(mysql_query($SQL_BOOK));
					?>
					<?if($book_info->qty >= "1"){?>
					<li><label class="checkWrap"><input type="checkbox"  onclick ="bookCheck(1);" name="bookChk1"  id="add_lec_book<?=$lecture_info->seq;?>" value="b<?=$lecture_info->book?>" /><span class="txt">교재와 함께 구매 : + <?=number_format($lecture_info->book_price);?>원</span></label></li>
					<?}?>
				</ul>
			</div>
			<?}?>
			<div class="btnArea">
				<?//재원생 전용 강좌인 경우?>
				<?if($lecture_info->dyb_reg_type == "Y" ){?>
					<?if($_SESSION['LEVEL_TYPE'] == "Y"){ ?>
						<?if(!$lecture_info->price){?>
							<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
						<?}else{?>
							<? if($lecture_info->dyb_dc_type == "Y" && !$lecture_info->dyb_dc_price && $_SESSION['DYB_TYPE'] == "2" ) { ?>
							<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
							<?}else if($lecture_info->dc_type == "Y" && !$lecture_info->dc_price && $_SESSION['DYB_TYPE'] == "1" ) { ?>
								<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
							<?}else{?>
								<a href="javascript:cartAdd(<?=$lecture_info->seq;?>,'l', 1);" class="btnStyleB bgRed">수강신청<img src="../images/sub/img_more.png" alt="" /></a>
								<a href="javascript:cartAdd(<?=$lecture_info->seq;?>,'l', 0);" class="btnStyleB bdBk last">장바구니<img src="../images/sub/img_cart.png" alt="" /></a>
							<?}?>
						<?}?>
					
					<?}else{?>
						<a href="javascript:alert('재원생 major, brain, song\'s class 전용 강좌 입니다.');" class="btnStyleB bgRed">특정 재원생 전용 강좌<img src="../images/sub/img_more.png" alt="" /></a>
					<?}?>
				<?}else{?>
				
					<?if(!$lecture_info->price){?>
						<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
					<?}else{?>
						<? if($lecture_info->dyb_dc_type == "Y" && !$lecture_info->dyb_dc_price && $_SESSION['DYB_TYPE'] == "2" ) { ?>
							<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
						<?}else if($lecture_info->dc_type == "Y" && !$lecture_info->dc_price && $_SESSION['DYB_TYPE'] == "1" ) { ?>
							<a href="javascript:addFreeLec(<?=$lecture_info->seq;?>);" class="btnStyleB bgRed">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
						<?}else{?>
							<a href="javascript:cartAdd(<?=$lecture_info->seq;?>,'l', 1);" class="btnStyleB bgRed">수강신청<img src="../images/sub/img_more.png" alt="" /></a>
							<a href="javascript:cartAdd(<?=$lecture_info->seq;?>,'l', 0);" class="btnStyleB bdBk last">장바구니<img src="../images/sub/img_cart.png" alt="" /></a>		
						<?}?>
					<?}?>
				
				<?}?>
			</div>
		</div>
	</div>

	<div class="tab">
		<div class="innerWrap">
			<div class="btnTab lectureBtnTab">
				<a href="#none" class="active">강좌 소개</a>
				<a href="#none" class="last">강좌 목차</a>
			</div>
		</div>

		<div class="innerWrap tabArea">
			<div>
				<div class="outer" <?if($lecture_info->LECTURE_BACK_IMAGE){?>style="height:<?=$lecture_info->LECTURE_BACK_HEGIHT;?>px; background:url(../data/lecture/<?=$lecture_info->LECTURE_BACK_IMAGE;?>) no-repeat center 0;" <?}?>>
					<div class="inner">
						<?
						$LECTURE_CONTENT_PC = iconv("EUC-KR","UTF-8",$lecture_info->LECTURE_CONTENT_PC);
						if($LECTURE_CONTENT_PC== "NULL"){
							$LECTURE_CONTENT_PC = "";
						}
						?>
						<?=$tools->strHtml($LECTURE_CONTENT_PC);?>
					</div>
				</div>
			</div>
			<div style="display:none">
				<div class="innerWrap pdt100">
					<!-- .boardList -->
					<div class="boardList">
						<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<colgroup>
								<col width="80" />
								<col width="" />
								<col width="140" />
							</colgroup>
							<thead>
								<tr>
									<th>UNIT</th>
									<th>강의명</th>
									<th>강의시청</th>
								</tr>
							</thead>
							<tbody>
								<?
								if (trim($lecture_info->display_list)) {
									$sql_m = " select
															a.* ,
															b.count as log_cnt ,
															b.sdate as log_date
														from
															movie as a
															left join movie_log as b on (a.seq = b.m_seq and b.mid = '".$_SESSION['memid']."' )
														where
															a.seq in (".$lecture_info->display_list.") order by a.m_order, a.seq ";
									$result_m = mysql_query($sql_m);
									if (mysql_num_rows($result_m)) {
										while ($row_m = mysql_fetch_assoc($result_m)) {
											$lectureList[] = $row_m;
										}
									}
								}
								?>
								<?if(trim($lecture_info->display_list)){?>
								<?foreach ($lectureList as $kk => $vv) {
									/*
									파일
									*/
									$attach = $vv['attach'];
									$attach_real_file = $vv['attach_real'];	
								?>
								<tr>
									<td><?=$kk+1?></td>
									<td class="alignLeft"><?=iconv("EUC-KR","UTF-8",stripslashes($vv['m_name']))?></td>
									<td>
									<?if($_SESSION[memid]){?>
										<?

										//모바일 동영상
										//미디어 고유키
										if($vv['pc_addr']){
											$play_key = $vv['pc_addr'];
										}else{
											$play_key = $vv['mobile_addr'];
										}

										//ucc 인증키 (스마트HD 관리툴 > 지원센터 > 연동 환경 설정 > ucc 인증키)
										$ucc_auth_key = $ucc_key;

										//시청자 IP
										$user_ip = $_SERVER["REMOTE_ADDR"];

										//10자리 int형 unixtime
										$timestamp = time();

										//5자리의 랜덤키 생성
										$rand_key = md5(rand() * rand());
										$rand_key = substr($rand_key, 0, 5);
				
										$okey = $rand_key . md5($rand_key . "|" . $play_key . "|" . $ucc_auth_key . "|" . $user_ip . "|" . $timestamp);

										?>
										<?


											if (!in_array($_SESSION['memlevel'], array(2,3,4,8,9))) {			
												$sql = ' select
														a.*,
														b.`display_list` as lec_list
													from
														`order_list` as a
														left join `class` as b on (a.`pdt_seq` = b.`seq`)
													where
														`od_mid` = \''.$_SESSION['memid'].'\' and `od_type` = \'l\' and `order_status` = 1 and `s_day` <= curdate() and `e_day` >= curdate() and b.`code` = \''.$lecture_info->code.'\' ';

												$result = mysql_query($sql);

												if (!mysql_num_rows($result)) {
													?>
													<a href="javascript:alert('수강신청 후 이용가능합니다');" class="btn">강의보기</a>
													<?
												}else{
													$lecturesub_info = mysql_fetch_object($result);
													//강좌 재생
													?>
													<a href="javascript:viewLecture('<?=$play_key?>','<?=$okey?>','<?=$timestamp?>','<?=$vv['seq']?>','<?=$lecturesub_info->seq?>');" class="btn">강의보기</a>
													<?
												}
											}else{
												//강좌 재생
												?>
												<a href="javascript:viewLecture('<?=$play_key?>','<?=$okey?>','<?=$timestamp?>','<?=$vv['seq']?>','<?=$lecturesub_info->seq?>');" class="btn">강의보기</a>
												<?
											}
										?>

									<?}else{?>
										<a href="javascript:if (confirm('로그인 후 이용가능합니다 로그인 하시겠습니까?')){ location.href='sub.php?goPage=login&menu_code=6_61';}" class="btn">강의보기</a>
									<?}?>
									</td>
								</tr>
								<?
								}
								?>
								<?}?>
							</tbody>
						</table>
					</div>
					<!-- /.boardList -->
				</div>
			</div>
		</div>

	</div>


		<!-- 환불규정 -->
		<div class="innerWrap refundPolicy pdb70">
			<h3><span>배송 및 환불 안내</span></h3>
			<?
			$DELIVERY_HTML_NEW = iconv("EUC-KR","UTF-8",$site_info->DELIVERY_HTML_NEW);
			?>
			<?=$tools->strHtml($DELIVERY_HTML_NEW);?>
			
		</div>
		<!-- /환불규정 -->



<!-- 플레이어 -->
<div class="layer" id="playerArea" style="display:none">
	<div class="layerInner" style="width:768px;">
		<div class="layerBox" style="overflow:visible;">
			<iframe id ="gabiaPlayerSub" width="768" height="456" src="http://play.smartucc.kr/player.php?origin=&view_type=iframe&width=768&height=456" frameborder="0" allowfullscreen></iframe>
			<a href="#none" style="position:absolute; top:5px; right:-46px;" onclick="layerClose('playerArea');"><img src="../images/popup/btn_layer_close_b.png" alt="" /></a> 
		</div>
	</div>
</div>
<!-- /플레이어 -->
</div>


	