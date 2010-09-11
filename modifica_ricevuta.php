<?php

require_once('include/db_connection.php');

/************************
echo '<br />';
echo urldecode($_GET['id_addebiti']);
$addebiti = unserialize(urldecode($_GET['id_addebiti']));
foreach($addebiti as $k => $v) {
	echo '<br />';
	echo $k .' - '.$v;
}
$importi_riga = unserialize(urldecode($_GET['importi_riga']));
foreach($importi_riga as $k => $v) {
	echo '<br />';
	echo $k .' - '.$v;
}
****************************/
if ((isset($_GET['id_ricevuta'])) && (is_numeric($_GET['id_ricevuta']))) {
	$id_ricevuta = $_GET['id_ricevuta'];
}
elseif ((isset($_POST['id_ricevuta'])) && (is_numeric($_POST['id_ricevuta']))) {
	$id_ricevuta = $_POST['id_ricevuta'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}


if (isset($_POST['submitted'])) {
	if (isset($_GET['matricola'])) {
		$matricola = $_GET['matricola'];
	}
	elseif (isset($_POST['matricola'])) {
		$matricola = $_POST['matricola'];
	}
	else {
		echo '<p class="error">Uhm... Non dovresti accedere cos&igrave; a questa pagina...</p>';
		include('include/footer.html');
		exit();
	}
	if (($_POST['submit']) == "Annulla") {
		$sql = "select cancella_ricevuta($id_ricevuta)";
		try { $stm = $db->query($sql); }
		catch(PDOException $e) {
			echo $e->getMessage();
			exit();
		}
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'addebiti.php?matricola=' . $matricola;
		header("Location: http://$host$uri/$extra");
	}
	include('include/update_ricevuta_testata.php');
	include('include/update_ricevuta_riga.php');
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'addebiti.php?matricola=' . $matricola;
	header("Location: http://$host$uri/$extra");
	
}

$page_title = 'Modifica Ricevuta';
include('include/header.html');


echo "<h1>Modifica Ricevuta</h1>";

$sql = "select * from vista_ricevute where id_ricevuta=$id_ricevuta";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti ricevute nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/ricevuta_testata.php');
	echo '<form action="modifica_ricevuta.php" method="post">';
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo ricevuta_testata($r);

	$sql = "select * from ricevute_riga where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	include('include/ricevuta_righe.php');
	list($table, $id_addebiti, $importi_riga) = tabella_ricevuta_righe($stm);
	echo $table;
	$matricola = $r['matricola_studente'];
	echo '<p><input type="submit" name="submit" value="Salva" 
	onClick="window.open(\'http://pico/scuola/stampa_ricevuta.php?id_ricevuta='.$r['id_ricevuta'].')" /> ';
	echo '<input type="submit" name="submit" value="Annulla" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id_ricevuta" value="' . $id_ricevuta .'" />';
	echo '<input type="hidden" name="matricola" value="'.$matricola.'" />';
	echo '</form>';
	
}
catch(PDOException $e) {
	echo $e->getMessage();
}

include('include/footer.html');
?>
