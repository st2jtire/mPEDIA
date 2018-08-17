<?php
	include_once("../include/head.inc.php");
?>

 <body>
  <!-- #wrap -->
  <div id="wrap">
	<!-- #header -->
	<div id="header">
		<h1><a href="../index.html"><img src="../images/common/h1_logo.png" alt="" /></a></h1>
		<div id="btnGnb">메뉴 열고 닫기</div>
		<div class="btnToggleMenu"><a href="#none"><img src="../images/common/btn_toggle_menu_1.png" alt="" /></a></div>
	</div>
	<!-- /#header -->

	<!-- #gnb -->
	<ul id="gnb">
		<li><a href="#none" class="active">내신 정복</a></li>
		<li><a href="#none">내신 이야기</a></li>
		<li><a href="#none">입시 광장</a></li>
		<li><a href="#none">운영센터</a></li>
	</ul>
	<!-- /#gnb -->

	<hr />

	<!-- #lnb -->
	<div id="lnb">
		<a href="#none" id="lnbClose"><img src="../images/common/btn_lnb_close.png" alt="" /></a>
		<div class="top">
			<h2>홍길동님 <span>(<span class="colorRed">재원생</span>) M1-ACE1</span></h2>
			<p><a href="#none">로그아웃 ></a></p>
		</div>
		<div class="cont">
			<ul class="menu_1">
				<li><a href="#none">강의실</a></li>
				<li><a href="#none">결제 정보</a></li>
				<li><a href="#none">이용 문의</a></li>
				<li><a href="#none">회원 정보</a></li>
			</ul>
			<ul class="menu_2">
				<li><a href="#none">내신 강좌</a></li>
				<li><a href="#none">오늘의 영단어</a></li>
			</ul>
			<div class="customer">
				<h3>고객센터</h3>
				<ul>
					<li><a href="tel:02-569-5326">일반  02-569-5326</a></li>
					<li><a href="tel:02-556-1604">전산  02-556-1604</a></li>
				</ul>
				<ul>
					<li>평일 : 11:00~22:00</li>
					<li>토요일 : 11:00~14:00</li>
				</ul>
			</div>
		</div>
		<div class="bottom">
			<select onchange="if(this.value) window.open(this.value);">
				<option value="">패밀리사이트</option>
				<option value="http://www.naver.com">네이버</option>
				<option value="http://www.daum.net">다음</option>
				<option value="http://www.nate.com">네이트</option>
				<option value="http://www.sayclub.com">세이클럽</option>
			</select>
		</div>
	</div>
	<!-- /#lnb -->

	<hr />

	<!-- .twoDepthMenu -->
	<div class="twoDepthMenu size_1">
		<ul>
			<li class="alignLeft active"><span>시스템</span></li>
		</ul>
	</div>
	<!-- /.twoDepthMenu -->

	<hr />

	<!-- #contents -->
	<div id="contents">
		<div class="pdlr"><img src="../images/sub/img_sistem.png" width="100%" alt="" /></div>
	</div>
	<!-- /#contents -->

	<hr />

	    <?php
    	include_once("../include/bottom.inc.php");
    	?>
