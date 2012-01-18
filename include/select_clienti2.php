<?php

function select_clienti2($db, $matricola)
{
	try {
		$sql = "select * from cerca_clienti('$matricola')";
		$stm = $db->query($sql);
	}
	catch(PDOException $e) {
       		echo $e->getMessage();
		syslog(LOG_INFO, $e->getMessage());
	}

	require_once('tabella_clienti_radio.php');
	return result_as_table($stm);
}

?>
