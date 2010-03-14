<?php
function oggi($db)
{
	$sql = "select current_date";
	try {
		$stm = $db->query($sql);
		$r = $stm->fetch(PDO::FETCH_BOTH);
		return $r['date'];
	}
	catch(PDOException $e) {
		echo $e->getMessage();
		exit;
	}
}
?>
