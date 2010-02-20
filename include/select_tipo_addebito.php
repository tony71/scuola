<?php

try {
	$sql = 'select id_tipo_addebito, descrizione_tipo from tipo_addebito';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['id_tipo_addebito'];
		$option .= '">';
		$option .= $r['descrizione_tipo'];
		$option .= ' </option>';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>
