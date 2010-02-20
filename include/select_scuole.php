<?php

try {
	$sql = 'select codice_meccanografico, denominazione from scuole where codice_scuola is not null';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['codice_meccanografico'];
		$option .= '">';
		$option .= $r['codice_meccanografico'] . ' - ' . $r['denominazione'];
		$option .= ' </option>';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>
