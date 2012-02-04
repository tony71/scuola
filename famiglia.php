<?php
require_once('include/db_connection.php');

$page_title = 'Benvenuti a Scuola';
include('include/header.html');

if (isset($_GET['id_famiglia'])) {
	$id_fam = $_GET['id_famiglia'];
}
else {
}

	$sql = "select * from cerca_famiglia('".$id_fam."')";
	$sql .= " order by cognome, nome";
	try {
		$stm = $db->query($sql);
		$num = $stm->rowCount();
		if ($num > 0) {
			echo '<h1>Nominativi trovati: '. $num . '</h1>';
			require('dettagli_famiglia.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
		}
		else {
			echo '<p class="error">Non trovo nominativi nel DB.</p>';
		}
		$titolo ='Nominativi';
		$filename = 'studenti.xls';
		// echo '<a href="genera_excel.php?sql='.$sql.'&titolo='.$titolo.'&filename='.$filename.'" target="_blank">Excel</a>';
		echo '<form action="genera_excel.php" method="post">';
		echo '<input type="submit" name="submit" value="Excel" />';
		echo '<input type="hidden" name="sql" value="'.$sql.'" />';
		echo '<input type="hidden" name="title" value="'.$titolo.'" />';
		echo '<input type="hidden" name="filename" value="'.$filename.'" />';
		echo '<input type="hidden" name="submitted" value="TRUE" />';
		echo '</form>';
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

include('include/footer.html');
?>
