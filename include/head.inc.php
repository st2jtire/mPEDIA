<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
 <head>
 
 <?php
    include('../config/common.php');
 ?>

  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densitydpi=device-dpi" />
  <meta name="theme-color" content="#b3191c" />
  <title>PEDIA</title>
  <?
  // 현재 파일이 메인인지를 구별하여 css 파일 따로 적용
    if( basename($_SERVER["PHP_SELF"]) == "main.php" ){
  ?>
    <link rel="stylesheet" type="text/css" href="../css/main.css" />
  <?
    }else{
  ?>
    <link rel="stylesheet" type="text/css" href="../css/sub.css" />
  <?
    }
  ?>

  <script type="text/javascript" src="../js/jquery-1.11.0.min.js"></script>
  <script type="text/javascript" src="../js/style_common.js"></script>
  <script type="text/javascript" src="../js/jquery-ui.min.js"></script>
 </head>