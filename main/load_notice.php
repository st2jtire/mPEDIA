<?php
    header("Content-Type:application/json; charset=UTF-8");

    include('../config/common.php');
 
    function Console_log($data){
        echo "<script>console.log( 'PHP_Console: " . $data . "' );</script>";
    }

    $init = $_POST['init']; 
    $offset = $_POST['page']; 

    //공지사항 DB SEARCH
	//$boardid = "NOTI";
    //$table = "DYB_BOARD_".$boardid;
    //$query = 'where 1=1  and  com_fid = 0 order by uid desc LIMIT '.$init.', '.$offset; 
    //$result	= $db->select( $table, $query);
    
    $query = 'SELECT subject, signdate, uid, \'DOWN\' AS boardinfo FROM DYB_BOARD_DOWN WHERE com_fid = 0 
		    union all 
			SELECT subject, signdate, uid, \'SCHOOL\' AS boardinfo FROM DYB_BOARD_SCHOOL WHERE com_fid = 0 
			union all 
			SELECT subject, signdate, uid, \'CON\' AS boardinfo FROM DYB_BOARD_CON WHERE com_fid = 0 
			union all 
			SELECT subject, signdate, uid, \'SER\' AS boardinfo FROM DYB_BOARD_SER WHERE com_fid = 0 
			union all 
			SELECT subject, signdate, uid, \'NOTI\' AS boardinfo FROM DYB_BOARD_NOTI WHERE com_fid = 0 
			order by signdate desc LIMIT '.$init.', '.$offset;

    if($result = mysql_query($query)){
        $notice_int = "0";
        $o = array();
        while($bbs_row = mysql_fetch_object($result)) {
            $notice_int++;
            $t = new stdclass();
            $subject =iconv("EUC-KR","UTF-8",$bbs_row->subject);
            $subject = $tools->strCut($subject, 44);
            $boardid = iconv("EUC-KR","UTF-8", $bbs_row->boardinfo);
            $wdate =substr($bbs_row->signdate, 0, 10);
            //$SQL = "select dateDIFF(now(),'".$wdate."') as diff from dual";
            //$date_row = mysql_fetch_object(mysql_query($SQL));
    
            $t->uid = $bbs_row->uid;
            $t->subject = $subject;
            $t->boardid = $boardid;
            $t->wdate = $wdate;
            $o[] = $t;
    
            unset($t);        
        }
    }else{
        $o = array( 0 => 'empty');
    }

    echo json_encode($o); 
?>