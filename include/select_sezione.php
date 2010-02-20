<?php

try {
	$sql = 'select distinct sezione from classi order by sezione asc';
	$stm = $db->query($sql);
	while ($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$option = '<option value="';
		$option .= $r['sezione'];
		$option .= '">';
		$option .= $r['sezione'];
		$option .= ' </option>';
		echo $option;
	}
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

