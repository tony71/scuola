<?php

try {
	$sql = 'select distinct anno from classi order by anno asc';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['anno'];
		$option .= '">';
		$option .= $r['anno'];
		$option .= ' </option>';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

