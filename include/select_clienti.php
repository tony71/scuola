<?php

function select_clienti($db, $matricola)
{
	$result = '';
	try {
		$sql = "select * from cerca_clienti('$matricola') where is_default='checked'";
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
