<?php
	$filename=$_POST['filename'];
	// header ("Content-Type: application/vnd.ms-excel");
	header ("Content-Type: text/xml");
	header ("Content-Disposition: inline; filename=$filename");
	require_once('include/db_connection.php');
	$query = pg_escape_string($_POST['sql']);
	try {
		$sql = "select xmlroot(query_to_xml('$query'::text, true, false, 'Prova'),version '1.0', standalone yes)";
		$stm = $db->query($sql);
		$r = $stm->fetch(PDO::FETCH_BOTH);
		echo $r[0];
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
?>
