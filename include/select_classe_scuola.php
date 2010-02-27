<?php

try {
	$sql = "select distinct codice_meccanografico, denominazione, codice_meccanografico || '-' || denominazione as scuola from classi a natural join scuole b order by codice_meccanografico";
	$stm = $db->query($sql);
	$cm = $stm->fetchAll();
	foreach ($cm as $val) {
		$cod = $val['codice_meccanografico'];
		$sc = htmlspecialchars($val['scuola']);
		echo '<optgroup label="' . $sc . '">';

		$sql = "select * from classi where codice_meccanografico='$cod' order by anno, sezione";
		$stm = $db->query($sql);
		while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
			$option = '<option value="';
			$option .= $r['id'];
			$option .= '">';
			$option .= $r['anno'] . ' ' . $r['sezione'] . ' ' . $r['indirizzo'];
			$option .= ' </option>';
			echo $option;
		}

		echo '</optgroup>';
	}

}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

