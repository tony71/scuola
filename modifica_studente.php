<?php
$page_title = 'Modifica Studente';
include('include/header.html');

if (isset($_GET[matricola])) {
	$matricola = $_GET[matricola];
}
elseif (isset($_POST[matricola])) {
	$matricola = $_POST[matricola];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}
echo "<h1>Modifica Studente $id</h1>";

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	include('include/update_persona.php');
	include('include/update_studente.php');
}

$sql = "select * from vista_studenti where matricola='$matricola'";
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
	echo singolo_studente($r, false);
	echo '<p><input type="submit" name="submit" value="Submit" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id" value="' . $id .'" />';
	echo '</form>';
}
catch(PDOException $e) {
	echo $e->getMessage();
}
include('include/footer.html');
?>
