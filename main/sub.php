<?php
include_once("../include/head.inc.php");
include_once("../include/quickmenu.inc.php");

$MENU_CODE_TMP = str_replace("_","/",$_GET['menu_code']);
$MENU_INFO_SQL = "SELECT *   FROM DYB_MENU_M_NEW WHERE menu_code = '$MENU_CODE_TMP' ";
$MENU_INFO = mysql_fetch_object(mysql_query($MENU_INFO_SQL));
$tmp_menu_code = $_GET['menu_code'];
$tmp_menu_code=explode("_",$tmp_menu_code);

//1차 조회
$ON_MENU1 = "SELECT *   FROM DYB_MENU_M_NEW WHERE menu_code = '".$tmp_menu_code[0]."' ";
$ON_MENU_ROW1 = mysql_fetch_object(mysql_query($ON_MENU1));
//2차 조회
$ON_MENU2 = "SELECT *   FROM DYB_MENU_M_NEW WHERE menu_code = '".$tmp_menu_code[0]."/".$tmp_menu_code[1]."' ";
$ON_MENU_ROW2 = mysql_fetch_object(mysql_query($ON_MENU2));
//3차 조회
$ON_MENU3 = "SELECT *   FROM DYB_MENU_M_NEW WHERE menu_code = '".$tmp_menu_code[0]."/".$tmp_menu_code[1]."/".$tmp_menu_code[2]."' ";
$ON_MENU_ROW3 = mysql_fetch_object(mysql_query($ON_MENU3));
?>


	<!-- #path -->
	<div id="path">
		<p class="inner">
			<?if(($goPage == "cate_list" || $goPage == "cate_info" ) && $menu_code <> "2_21" ){?>
				<?
				$SQL = "SELECT *   FROM DYB_STORE_CAT_NEW where  CAT_CODE = '".$sub_code."' and length(CAT_CODE) = '4'   ";
				$sub_page = mysql_fetch_object(mysql_query($SQL));
				?>
				<span><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW1->menu_nm)?></span>
				<?if($goPage == "cate_info" ){?>
				<strong>강좌상세</strong>
				<?}else{?>
				<a href="sub.php?goPage=cate_list&menu_code=<?=$ON_MENU_ROW1->menu_code;?>_<?=$sub_page->CAT_CODE;?>&sub_code=<?=$sub_page->CAT_CODE;?>"><strong><?= iconv("EUC-KR","UTF-8",$sub_page->CAT_NAME)?></strong></a>
				<?}?>
			<?}else{?>
				<?if($ON_MENU_ROW3->menu_nm){?>

				<span><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW1->menu_nm)?></span>
				<span><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW2->menu_nm)?></span>
				<a href="<?=$ON_MENU_ROW3->page_url;?>"><strong><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW3->menu_nm)?></strong></a>


				<?}else if($ON_MENU_ROW2->menu_nm){?>
				<span><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW1->menu_nm)?></span>
				<a href="<?=$ON_MENU_ROW2->page_url;?>"><strong><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW2->menu_nm)?></strong></a>
				<?}else if($ON_MENU_ROW1->menu_nm){?>
				<a href="<?=$ON_MENU_ROW1->page_url;?>"><strong><?= iconv("EUC-KR","UTF-8",$ON_MENU_ROW1->menu_nm)?></strong></a>
				<?}?>
			<?}?>
		</p>
	</div>
	<!-- /#path -->

	<?
	//본문내용=====================
	 if($goPage){ include($goPage.".php"); } 
	//본문내용=====================	
	?>
	
<?php
include_once("../include/bottom.inc.php"); 
?>