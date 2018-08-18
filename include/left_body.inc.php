<?
//1차 메뉴 조회
$SQL = "SELECT *   FROM DYB_MENU_M_NEW WHERE menu_code = '$tmp_menu_code[0]' ";
$page1_row = mysql_fetch_object(mysql_query($SQL));
?>
			<!-- #lnb -->
			<div id="lnb">
				<h2><?=iconv("EUC-KR","UTF-8",$page1_row->menu_nm);?></h2>
				<ul>
					<?if($tmp_menu_code[0] == "6"){?>
					<?
					$page2_result = $db->select( "DYB_MENU_M_NEW", "where menu_depth=2 and substring_index(menu_code,'/',1) = '$page1_row->idx'   order by menu_sort asc");
					while( $page2_row = @mysql_fetch_object($page2_result) ) { 	
					?>
						<?if (!$_SESSION['memid'] ){?>
						<li><a href="<?=$page2_row->page_url;?>" <?if($tmp_menu_code[1] == $page2_row->idx){ ?>class="active"<?}?>><?=iconv("EUC-KR","UTF-8",$page2_row->menu_nm);?></a></li>
						<?}else{?>
							<?if ($page2_row->idx == "64"  || $page2_row->idx == "65"  ){?>
								<li ><a href="<?=$page2_row->page_url;?>" <?if($tmp_menu_code[1] == $page2_row->idx){ ?>class="active"<?}?>><?=iconv("EUC-KR","UTF-8",$page2_row->menu_nm);?></a></li>
							<?}?>
						<?}?>
					<?}?>
					<?}else if($tmp_menu_code[0] == "7"){?>
					<?
					$page2_result = $db->select( "DYB_MENU_M_NEW", "where menu_depth=2 and substring_index(menu_code,'/',1) = '$page1_row->idx'   order by menu_sort asc");
					while( $page2_row = @mysql_fetch_object($page2_result) ) { 	
					?>
					<li>
						<a href="<?=$page2_row->page_url;?>"><?=iconv("EUC-KR","UTF-8",$page2_row->menu_nm);?></a>
						<ul>
							<?
							$page3_result = $db->select( "DYB_MENU_M_NEW", "where menu_depth=3 and substring_index(menu_code,'/',2) = '$page1_row->idx/$page2_row->idx'   order by menu_sort asc");
							while( $page3_row = @mysql_fetch_object($page3_result) ) { 	
							?>
							<li><a href="<?=$page3_row->page_url;?>"  <?if($tmp_menu_code[2] == $page3_row->idx){ ?>class="active"<?}?>>- <?=iconv("EUC-KR","UTF-8",$page3_row->menu_nm);?></a></li>
							<?
							}
							?>
						</ul>
					</li>
					<?}?>
					<?}?>
				</ul>
			</div>
			<!-- /#lnb -->

			<hr />