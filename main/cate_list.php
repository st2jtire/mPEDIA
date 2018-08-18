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
	if($DATA){
		$SEARCH_DETAIL .= "  AND b.LECTURE_NM LIKE '%".iconv("UTF-8","EUC-KR",$DATA)."%'  ";
	}
	$search = "&SUBJECT_CD=$SUBJECT_CD&YEAR_CD=$YEAR_CD&PRESS_CD=$PRESS_CD&DATA=$DATA";
?>

 <body>
  <!-- #wrap -->
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

	<hr />

    <!-- #container -->
    <div id="contents">
	    <!-- .boardSearch -->	
		<div class="boardSearch pdlr pdb" style="">
			<div style="width:30%">
				<select name = "SUBJECT_CD" onchange="javascript:document.search_form.submit();">
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
            </div>
            <div style="width:30%">
				<select name = "YEAR_CD" onchange="javascript:document.search_form.submit();" >
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
            </div>
            <div style="width:40%">
				<select name = "PRESS_CD" onchange="javascript:document.search_form.submit();">
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
            </div>
		</div>			
        <!-- /.boardSearch -->
            
        <!-- .courseList -->
        <div class="courseList">
		    <?
			    $lec2_result = $db->select( "DYB_STORE_CAT_NEW", "where  CAT_CODE LIKE '".$sub_code."%' and length(CAT_CODE) = '4'  order by CAT_ORDER asc");
			    $main_cnt = "0";
			    while( $lec2_row = @mysql_fetch_object($lec2_result) ) { 	
			    $main_cnt++;
			?>
            <?
                if($main_cnt == 1) {
            ?>
            <h3><span><?=iconv("EUC-KR","UTF-8",$lec2_row->CAT_NAME);?></span></h3>
            <?
                }else{
            ?>
            <h3 class="pdt15"><span><?=iconv("EUC-KR","UTF-8",$lec2_row->CAT_NAME);?></span></h3>
            <?        
                }
            ?>
			<ul>
			    <?
                /*
                $lec3_cnt = $db->cnt( "DYB_CLASS_DISPLAY_NEW as a left outer join class as b on a.class_code = b.code 
                left outer join cat as c on c.cat_code = b.code 
                left outer join DYB_STORE_CAT_NEW as d on a.store_code = d.CAT_CODE 
                left outer join DYB_STORE_CAT_NEW as e on left(a.store_code,4) = e.CAT_CODE  
                left outer join product  on b.book = product.seq", "where a.store_code LIKE '$lec2_row->CAT_CODE%'  ".$SEARCH_DETAIL."  ", "a.idx" );
                */
                $lec3_result = $db->select_choice("DYB_CLASS_DISPLAY_NEW as a left outer join class as b on a.class_code = b.code 
                left outer join cat as c on c.cat_code = b.code 
                left outer join DYB_STORE_CAT_NEW as d on a.store_code = d.CAT_CODE 
                left outer join product  on b.book = product.seq", 
                "where a.store_code LIKE '$lec2_row->CAT_CODE%'  ".$SEARCH_DETAIL." 
                order by b.LECTURE_NM asc","a.*,b.*,d.CAT_NAME as cname2 , product.name as book_name , product.price as book_price");
			    $lec_cnt = "0";
			    while( $lec3_row = @mysql_fetch_object($lec3_result) ) { 	
				    $lec_cnt++;
			    ?>
			<li>
				<a href = 'sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>'>
				<span class="img">
					<?if($lec3_row->LECTURE_LIST_IMAGE_PC) { ?>
						<img src="../data/lecture/<?=$lec3_row->LECTURE_LIST_IMAGE_PC;?>" alt="" />
					<?}else{?>
						<img src="../images/board/img_product_no.jpg" alt="" />
					<?}?>
                </span>
			    <span class="txt">
					<span class="tit"><?=iconv("EUC-KR","UTF-8",$lec3_row->LECTURE_NM);?></span>
                    <span><?=iconv("EUC-KR","UTF-8",$lec3_row->AD_TEXT);?></span>
                </span>    
                <span class="li">총 <?=$lec3_row->LECTURE_CNT;?>강</span>
                <span class="li"><?=$lec3_row->LECTURE_MONTH;?>개월</span>
				<span class="li">
					<? if($lec3_row->dc_type == "Y" || $lec3_row->dyb_dc_type == "Y") { ?>
					    <del>
					<?}?>정가 : 
					<? if($lec3_row->dc_type == "Y" || $lec3_row->dyb_dc_type == "Y") { ?>
						</del>
					<?}?>
					<? if($lec3_row->dc_type == "Y" || $lec3_row->dyb_dc_type == "Y") { ?>
						<del>
					<?}?>
					<?=($lec3_row->price)?number_format($lec3_row->price).' 원':'무료강좌'?>
					<? if($lec3_row->dc_type == "Y" || $lec3_row->dyb_dc_type == "Y") { ?>
					    </del>
					<?}?>
                </span>
				<? if($lec3_row->dc_type == "Y") { ?>
					<li class="colorRed">
				    	<span class="dt">
							<strong>비재원생 할인가</strong>
						</span>:
						<span class="dd"><?=($lec3_row->dc_price)?number_format($lec3_row->dc_price).' 원':'무료강좌'?>
						</span>
					</li>
				<?}?>
				<? if($lec3_row->dyb_dc_type == "Y"){ ?>
					<li class="colorRed">
						<span class="dt">
							<strong>재원생 할인가</strong>
						</span>:
						<span class="dd"><?=($lec3_row->dyb_dc_price)?number_format($lec3_row->dyb_dc_price).' 원':'무료강좌'?>
						</span>
					</li>
				<?}?>
				<?if($lec3_row->book_name){?>
					<?
				    	//교재잔여수량 확인
						$SQL_BOOK = "	
						SELECT
						product.qty
						FROM
						product
						WHERE
						product.seq = '".$lec3_row->book."'  ";

						$book_info = mysql_fetch_object(mysql_query($SQL_BOOK));
					?>
					<?if($book_info->qty >= "1"){?>
						<li class="last">
							<span class="dt">
								<label class="checkWrap">
									<input type="checkbox" name="list[]"  id="add_lec_book<?=$lec3_row->seq;?>" value="b<?=$lec3_row->book?>" />
									<span class="txt">교재와 함께 구매</span>
								</label>
							</span>:
							<span class="dd"><?=number_format($lec3_row->book_price);?>원</span>
						</li>
					<?}?>
				<?}?>

					<!-- 강좌보기 버튼 관련 부분이지만 모바일에서는 필요없을거 같아서 일단 주석
					<div class="btn" <?if($lec3_row->dyb_reg_type == "Y" ){?><?if($_SESSION['LEVEL_TYPE'] != "Y"){ ?>style="top:56px"<?}?><?}?>>
						<?//특별 재원생 전용 강좌인 경우?>
						<?if($lec3_row->dyb_reg_type == "Y" ){?>
							<?if($_SESSION['LEVEL_TYPE'] == "Y"){ ?>
								<?if(!$lec3_row->price){?>
									<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
									<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
								<?}else{?>
									<? if($lec3_row->dyb_dc_type == "Y" && !$lec3_row->dyb_dc_price && $_SESSION['DYB_TYPE'] == "2" ) { ?>
										<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
										<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
									<?}else if($lec3_row->dc_type == "Y" && !$lec3_row->dc_price && $_SESSION['DYB_TYPE'] == "1" ) { ?>
										<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
										<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
									<?}else{?>
											<a href="javascript:cartAdd(<?=$lec3_row->seq;?>,'l', 1);" class="btnStyle bgRed last">수강 신청<img src="../images/sub/img_more.png" alt="" /></a>
											<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>" class="btnStyle bdBk first">상세 보기</a>
											<a href="javascript:cartAdd(<?=$lec3_row->seq;?>,'l', 0);" class="btnStyle bdBk last">장바구니 </a>
									<?}?>
								<?}?>
							<?}else{?>
								<a href="javascript:alert('재원생 major, brain, song\'s class 전용 강좌 입니다.');" class="btnStyle bgRed last">특정 재원생 전용 강좌<img src="../images/sub/img_more.png" alt="" /></a>
							<?}?>
						<?}else{?>
							<?if(!$lec3_row->price){?>
								<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
								<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
							<?}else{?>
								<? if($lec3_row->dyb_dc_type == "Y" && !$lec3_row->dyb_dc_price && $_SESSION['DYB_TYPE'] == "2" ) { ?>
									<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
									<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
								<?}else if($lec3_row->dc_type == "Y" && !$lec3_row->dc_price && $_SESSION['DYB_TYPE'] == "1" ) { ?>
									<a href="javascript:addFreeLec(<?=$lec3_row->seq;?>);" class="btnStyle bgRed last">강좌보기<img src="../images/sub/img_more.png" alt="" /></a>
									<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>"  class="btnStyle bdBk first last" style="width:100%;">상세 보기</a>
								<?}else{?>
										<a href="javascript:cartAdd(<?=$lec3_row->seq;?>,'l', 1);" class="btnStyle bgRed last">수강 신청<img src="../images/sub/img_more.png" alt="" /></a>
										<a href="sub.php?goPage=cate_info&class_code=<?=$lec3_row->class_code;?>&menu_code=<?=$menu_code;?>&sub_code=<?=$lec2_row->CAT_CODE;?><?=$search;?>" class="btnStyle bdBk first">상세 보기</a>
										<a href="javascript:cartAdd(<?=$lec3_row->seq;?>,'l', 0);" class="btnStyle bdBk last">장바구니 </a>
								<?}?>
							<?}?>
						<?}?>
					
					</div>
					-->
					</a>
					<!-- -->
                </li>
				<?
				}
                ?>
            </ul>
			
			<?
			}
            ?>
        </div>    
			<!-- /.courseList -->

			
		
	</div>
	<!-- /#container -->

	<hr />