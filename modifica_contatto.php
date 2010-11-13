<?php

require_once('include/db_connection.php');

if (isset($_GET['id_persona'])) {
	$id_persona = $_GET['id_persona'];
}
elseif (isset($_POST['id_persona'])) {
	$id_persona = $_POST['id_persona'];
}
else {
	echo '<p class="error">Mancano dati per visualizzare qualcosa di sensato</p>';
	include('include/footer.html');
	exit();
}

if (isset($_GET['contatto'])) {
	$contatto = $_GET['contatto'];
}
elseif (isset($_POST['contatto'])) {
	$contatto = $_POST['contatto'];
}
else {
	echo '<p class="error">Mancano dati per visualizzare qualcosa di sensato</p>';
	include('include/footer.html');
	exit();
}

if (isset($_GET['commento'])) {
	$commento = $_GET['commento'];
}
elseif (isset($_POST['commento'])) {
	$commento = $_POST['commento'];
}
else {
	echo '<p class="error">Mancano dati per visualizzare qualcosa di sensato</p>';
	include('include/footer.html');
	exit();
}

if (isset($_POST['submitted'])) {
	include('include/update_contatto.php');
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'contatti.php?id_persona=' . $id_persona;
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Modifica Conattto';
include('include/header.html');

echo "<h1>Modifica Contatto</h1>";

$sql = "select * from contatti_persona where id_persona=$id_persona and contatto='$contatto' and commento='$commento'";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti contatti nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/singolo_contatto.php');
	echo '<form action="modifica_contatto.php" method="post">';
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo singolo_contatto($db, $r, false);
	echo '<p><input type="submit" name="submit" value="Salva" />';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id_persona" value="'.$id_persona.'" />';
	echo '<input type="hidden" name="old_contatto" value="'.$contatto.'" />';
	echo '<input type="hidden" name="old_commento" value="'.$commento.'" />';
	echo '<a href="contatti.php?id_persona=' . $id_persona . ' " >Annulla</a></p>';
	echo '</form>';
	
}
catch(PDOException $e) {
	echo $e->getMessage();
	syslog(LOG_INFO, $e->getMessage());
}


include('include/footer.html');
?>
