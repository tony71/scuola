<?php

require_once('include/db_connection.php');

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	echo '<p class="error">Mancano dati per visualizzare qualcosa di sensato</p>';
	include('include/footer.html');
	exit();
}

if (isset($_POST['submitted'])) {
	$sql = "select id_persona from studenti where matricola_studente='$matricola'";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$id = $r['id_persona'];
	include('include/update_persona.php');

	include('include/update_studente.php');
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'dettagli_studente.php?matricola=' . $matricola;
	header("Location: http://$host$uri/$extra");

}

$javascript = 'javascript/comuni.js';
$page_title = 'Modifica Studente';
include('include/header.html');

echo "<h1>Modifica Studente $matricola</h1>";

$sql = "select * from vista_studenti where matricola_studente='$matricola' limit 1";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti studenti nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/singolo_studente.php');
	echo '<form action="modifica_studente.php" method="post">';
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo singolo_studente($r, false, $db);
	echo '<p><input type="submit" name="submit" value="Salva" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id" value="' . $matricola .'" />';
	echo '</form>';
	
}
catch(PDOException $e) {
	echo $e->getMessage();
}

echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';

include('include/footer.html');
?>
