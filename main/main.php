<?php
include_once("../include/head.inc.php");
include_once("../include/quickmenu.inc.php");
?>

<script>
    var current_page = 0;
    var init_page = 0;
</script>

 <body>
  <!-- #wrap -->
  <div id="wrap">
	<!-- #mainHeader -->
	<div id="mainHeader">
		<div id="btnGnb">메뉴 열고 닫기</div>
		<a href="#none" class="btnMy">나의 강의실</a>
		<h3>
			무료로 누리는 내신의 모든 것
			<span>DYB PEDIA</span>
		</h3>

		<?
		// 오늘의 영어 문장 DB SEARCH
		$SQL = "SELECT * FROM DYB_BOARD_TODAY WHERE DATE_FORMAT(DYB_BOARD_TODAY.ENGLISH_TODAY,'%Y%m%d') <= '".date("Ymd")."' ORDER BY DYB_BOARD_TODAY.ENGLISH_TODAY DESC LIMIT 1";
		$todayEnglish_info = mysql_fetch_object(mysql_query($SQL));
		?>

		<div class="todayEnglishldiom">
		<h4>Today’s English ldiom </h4>
			<p>				
				<span><?=iconv("EUC-KR","UTF-8",$todayEnglish_info->subject);?></span> 
				<?if($todayEnglish_info->attach) {?>
					<a href="javascript:var audio = document.getElementById('audio');audio.play();"><img src="../html/images/main/btn_sound.png" alt="" /></a>
					<audio id="audio">
						<source src="http://182.162.73.35/pedia/<?=$todayEnglish_info->attach;?>" type="audio/mp3" />
					</audio>
				<?}?>
				<a href="#none" class="btnToday" onclick="layerOpen('todayWord')"><img src="../html/images/main/btn_today.png" alt="" /></a>
			</p>		
		</div>
		<ul class="menu">
			<li><a href="sub.php?goPage=cate_list&menu_code=2_21&sub_code=">내신 정복</a></li>
			<li><a href="#none">내신 이야기</a></li>
			<li><a href="#none">입시 광장</a></li>
			<li><a href="#none">운영센터</a></li>
		</ul>
	</div>
	<!-- /#mainHeader -->

	<hr />

	<hr />

	<!-- #contents -->
	<div id="contents">
		<ul id="inhere">
        	<script> 
            	function moreClick() {
                	var str = "";
                	current_page += 5;
                	console.log(current_page);
                	$.ajax({ 
                    	type: 'post', 
                    	dataType: 'json', 
                    	url: 'load_notice.php', 
                    	data: {init:init_page, page:current_page}, 
                    	success: function (data) { 	
                        	if (data != 'empty') { 
                            	$.each(data, function(key, val) {
                                	str +=  "<li>";
                                	str +=  "<a href=\"sub.php?uid="
                                	str +=  val.uid+"&mode=view&menu_code=5_51&boardid=NOTI&goPage=board\" >";
                                	str +=  "<span class=\"tit\">";
                                	str +=  val.subject; 
                                	str +=  "</span>";
									str +=  "<span class=\"div\">";
									switch(val.boardid) {
										case "DOWN":
											str += "내신자료";
											break;
										case "SCHOOL":
											str += "내신후기";
											break;
										case "CON":
											str += "경시대회";
											break;
										case "SER":
											str += "봉사활동";
											break;
										case "NOTI":
											str += "공지사항";
											break;
									}
									str +=  "</span>";
                                	str +=  "<span class=\"day\">";
                                	str +=  val.wdate;
                                	str +=  "</span>";
                                	str +=  "</a>";
                                	str +=  "</li>";
                                	document.getElementById("inhere").innerHTML = str;
                            	}); 
                        	} 
                    	}, 
                    	error: function (request,status,error) { 
                        	alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error); 
                    	}	 
                }); 
            }

            moreClick();
        </script>
		
		<?
            //공지사항 DB SEARCH
            /*
			$boardid = "NOTI";
			$table = "DYB_BOARD_".$boardid;
			$result	= $db->select( $table, "where 1=1  and  com_fid = 0 order by uid desc LIMIT 0, 5" );
			$notice_int = "0";
			while($bbs_row = mysql_fetch_object($result)) {
				$notice_int++;
				$subject =iconv("EUC-KR","UTF-8",$bbs_row->subject);
				$subject = $tools->strCut($subject, 44);
				$wdate =substr($bbs_row->signdate, 0, 10);
				$SQL = "select dateDIFF(now(),'".$wdate."') as diff from dual";
				$date_row = mysql_fetch_object(mysql_query($SQL));
			*/
        ?>
       
		
        <?
        	//}
		?>

		</ul>
		<a href="javascript:moreClick()" class="more">더보기</a>
	</div>
	<!-- /#contents -->

	<hr />

    <?php
    include_once("../include/bottom.inc.php");
    ?>

    <!-- todayWord -->
	<div class="layer" id="todayWord" style="display:none">
		<?
		$SQL = "
			SELECT 
				*
			FROM  
				DYB_BOARD_TODAY
			WHERE  
				DATE_FORMAT(DYB_BOARD_TODAY.ENGLISH_TODAY,'%Y%m%d') <= '".date("Ymd")."' 
			ORDER BY 
				DYB_BOARD_TODAY.ENGLISH_TODAY DESC
			LIMIT 1";

		$todayEnglish_info = mysql_fetch_object(mysql_query($SQL));
		?>
		<div class="layerInner" style="width:834px;">
			<div class="layerBox" >
				<div class="titArea">
					<h3><?=date("Y.m.d");?>  Today’s English Idiom</h3><a href="#none" class="btnLayerClose" onclick="layerClose('todayWord')"></a>
				</div>
				<div class="cont todayWordCont">
					<div class="tit"><?=iconv("EUC-KR","UTF-8",$todayEnglish_info->subject);?> <a href="#none"  onclick="window.open ('http://endic.naver.com/popManager.nhn?sLn=kr&m=search&query=<?=iconv("EUC-KR","UTF-8",$todayEnglish_info->subject);?>', 'englishPop' , 'scrollbars=1, top=0, left=0, width=408, height=517'); return false;" ><img src="../images/main/btn_naver_word.gif" alt="" /></a>
					<?if($todayEnglish_info->attach){?>
					<a href="javascript:var audio = document.getElementById('audioBottom');audio.play();"><img src="../images/main/btn_sound_2.png" alt="" /></a>
					<audio id="audioBottom">
					  <source src="http://182.162.73.35/pedia/<?=$todayEnglish_info->attach;?>" type="audio/mp3" />
					</audio>
					<?}?>
					</div>
					<div class="txt">
						<?
						$contents	=  iconv("EUC-KR","UTF-8",$todayEnglish_info->comment);
						?>
						<?=($tools->strHtml($contents));?>


					</div>
					<div class="mgt30 alignCenter posR">
						<a href="#none" onclick="layerClose('todayWord')" class="btnStyleM bdGr">닫기</a>
						<a href="sub.php?goPage=board&boardid=TODAY&menu_code=8" class="btnStyleM bgGr btnRight">이전 영단어 더보기</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /todayWord -->