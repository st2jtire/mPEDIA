<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
  <meta name="theme-color" content="#b3191c" />
  <title>PEDIA</title>
  <?
  /* 페이지 화면이 메인이냐 서브냐에 따라 화면 css 변경*/
	@$page = $_GET['page'];
	if($page == "sub") {
  ?>
	<link rel="stylesheet" type="text/css" href="../css/sub.css" />
  <?
	}else{
  ?>
	<link rel="stylesheet" type="text/css" href="../css/main.css" />
  <?
	}
  ?>


  <script type="text/javascript" src="../js/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="../js/style_common.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
 </head>
