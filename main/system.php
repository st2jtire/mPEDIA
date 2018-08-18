<?php
	include_once("../include/head.inc.php");
	include_once("../include/quickmenu.inc.php");
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
		include_once("../include/menu.inc.php");
	?>

	<hr />


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