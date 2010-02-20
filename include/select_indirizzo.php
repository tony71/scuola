<?php

try {
	$sql = 'select distinct indirizzo from classi order by indirizzo asc';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['indirizzo'];
		$option .= '">';
		$option .= $r['indirizzo'];
		$option .= ' </option>';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

