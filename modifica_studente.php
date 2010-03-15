<?php

require_once('include/db_connection.php');

$page_title = 'Modifica Studente';
include('include/header.html');

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}
echo "<h1>Modifica Studente $matricola</h1>";


if (isset($_POST['submitted'])) {
	$sql = "select id_persona from studenti where matricola='$matricola'";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$id = $r['id_persona'];
	include('include/update_persona.php');

	include('include/update_studente.php');
}

$sql = "select * from vista_studenti_cv where matricola_studente='$matricola' limit 1";
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
	$sql = 'select * from province order by provincia';
	$stm = $db->query($sql);
	echo singolo_studente($r, false, $stm);
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
