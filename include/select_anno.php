<?php

try {
	$sql = 'select anno from anni_scolastici order by anno desc';
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
