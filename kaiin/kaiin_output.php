<?php

	require_once('../common/common.php');
	require_once('../class/Kaiin_db.php');

	try {
			
		$kaiin_db = new Kaiin_db();
		
		$recs = $kaiin_db->get_kaiins();
		
		//CSV文字列生成
	    $csvstr = "";
	    foreach ($recs as $i => $rec) {
	    	$csvstr .= implode($rec, ',') . "\n";
	    }
	    
	    //CSV出力
	    $fileNm = sprintf('kaiins.csv');
	    header('Content-Type: text/csv');
	    header('Content-Disposition: attachment; filename='.$fileNm);
	    echo mb_convert_encoding($csvstr, "SJIS", "UTF-8"); //Shift-JISに変換したい場合のみ

	} catch (Exception $e) {
		print 'system error !!!';
		print $e;
		exit();
	} 
?>