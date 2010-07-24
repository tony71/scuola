<?php

try {
	$sql = 'select codice_meccanografico, denominazione from scuole where codice_scuola is not null';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<input type="checkbox" value="';
		$option .= $r['codice_meccanografico'];
		$option .= '" name="';
		$option .= $r['codice_meccanografico'] .'" />';
		$option .= $r['codice_meccanografico'] . ' - ' . $r['denominazione'].'<br />';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>
