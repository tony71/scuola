<?php
// require_once('db_connection.php');

function select_nazione($db, $id_nazione)
{
$result = '';
try {
	$sql = "select * from codici_sidi order by denominazione_stato_sidi";
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['codice_sidi'];
		$option .= '"';
		$option .= (isset($id_nazione) && ($id_nazione == $r['codice_sidi']) ? ' selected="yes"' : '');
		$option .= '>';
		$option .= $r['denominazione_stato_sidi'];
		$option .= ' </option>';
		$result .= $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

return $result;
}
?>
