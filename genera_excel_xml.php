<?php
	$filename=$_POST['filename'];
	// header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Type: text/xml");
	header ("Content-Disposition: inline; filename=$filename");
	require_once('include/db_connection.php');
	$sql = $_POST['sql'];
	try {
		$stm = $db->query('CREATE TEMP TABLE tmp AS '.$sql);
		$sql = "select xmlroot(table_to_xml('tmp'::regclass, true, false, 'Prova'),version '1.0', standalone yes)";
		$stm = $db->query($sql);
		$r = $stm->fetch(PDO::FETCH_BOTH);
		echo $r[0];
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
