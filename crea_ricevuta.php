<?php
$page_title = 'Crea Ricevuta';
include('include/header.html');

require_once('include/db_connection.php');

$sql = 'select crea_ricevuta(ARRAY[';
$first = TRUE;
foreach($_POST['id_addebito'] as $key => $value) {
	if ($first == FALSE) {
		$sql .= ', ';
	}
	$sql .= $value;
	$first = FALSE;
}
$sql .= '])';

if (isset($_POST['submitted'])) {
	try {
	$stm = $db->query($sql);
	$row = $stm->fetch(PDO::FETCH_BOTH);
	$id_ricevuta = $row['0'];

	$sql = "select * from ricevute where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	$ricevuta = $stm->fetch(PDO::FETCH_BOTH);

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'modifica_ricevuta.php?id_ricevuta=' . $id_ricevuta;
	header("Location: http://$host$uri/$extra");

	include('include/ricevuta_testata.php');
	echo ricevuta_testata($ricevuta);

	$sql = "select * from vista_ricevute_riga where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	include('include/ricevuta_righe.php');
	list($table, $id_addebiti, $importi_riga) = tabella_ricevuta_righe($stm);
	echo $table;
	
/*	
	echo '<a href="modifica_ricevuta.php?id_ricevuta='.$id_ricevuta.'&id_addebiti='.urlencode(serialize($_POST['id_addebito'])).'&importi_riga='.urlencode(serialize($importi_riga)).'">Modifica Ricevuta</a>';
	echo '<div class="navigation"><ul><li><a href="modifica_ricevuta.php?id_ricevuta='.$id_ricevuta.'">Modifica Ricevuta</a></li>';
	echo '<li><a href="stampa_ricevuta.php?id_ricevuta='.$id_ricevuta.'" target="_blank">Stampa Ricevuta</a></li></ul></div>'; */
	}
	catch(PDOException $e) {
       		echo $e->getMessage();
	}
}

include('include/footer.html');
?>
