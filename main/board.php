<?
$board_info = $db->object("DYB_BOARD_INFO", "where boardid='$boardid'");
$boardskin = $board_info->skin;
?>
 <!-- #wrap -->
 <div id="wrap">
	<!-- #header -->
	<div id="header">
		<h1><a href="../main/main.php"><img src="../images/common/h1_logo.png" alt="" /></a></h1>
		<div id="btnGnb">메뉴 열고 닫기</div>
		<div class="btnToggleMenu"><a href="#none"><img src="../images/common/btn_toggle_menu_1.png" alt="" /></a></div>
	</div>
    <!-- /#header -->
    
	<!-- #container -->
	<div id="container">
		<div class="inner">
		<?if($menu_code == "7_73_731" || $menu_code == "7_72_721" || $menu_code == "7_72_723"){?>
			<?
			include_once("../include/left_body.inc.php"); 
			?>

				<!-- #contents -->
				<div id="contents">
		<?}?>
			<!--내용 -->
			<?
			if($mode=='view'){
				include("../board_skin/$boardskin/view.inc.php");
			}else if($mode=='write'){
				include("../board_skin/$boardskin/write.inc.php");
			}else if($mode=='edit'){
				include("../board_skin/$boardskin/edit.inc.php");
			}else{
				include("../board_skin/$boardskin/list.inc.php");
			}
			?>
			<?if($menu_code == "7_73_731" || $menu_code == "7_72_721" || $menu_code == "7_72_723"){?>
				</div>
			<?}?>
		</div>
	</div>
	<!-- /#container -->