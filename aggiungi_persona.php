<?php
$page_title = 'Aggiungi Persona';

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	include('include/insert_persona.php');
	$id_persona = $_POST['id'];
	$sql = "select * from persone where id_persona=$id_persona";
	$stm = $db->query($sql);
	$p = $stm->fetch(PDO::FETCH_BOTH);
	if ($_POST['submit'] == "Crea Studente") {
		include('include/insert_studente.php');
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'modifica_studente.php?matricola=' . $_POST['matricola'];
		header("Location: http://$host$uri/$extra");
	}
	else {
		$host  = $_SERVER['HTTP_HOST'];
		$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
		$extra = 'persona_aggiunta.php?id_persona=' . $id_persona;
		header("Location: http://$host$uri/$extra");
	}
}

include('include/header.html');

echo "<h1>Aggiungi Persona</h1>";

try {
	include('include/singola_persona.php');
	echo '<form action="aggiungi_persona.php" method="post">';
	echo singola_persona($p, false, $db);
	echo '<p><input type="submit" name="submit" value="Crea Persona" /></p>';
	echo '<p><input type="submit" name="submit" value="Crea Studente" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '</form>';
}
catch(PDOException $e) {
	echo $e->getMessage();
}

include('include/footer.html');
?>
