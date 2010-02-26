<?php
$page_title = 'Aggiungi Persona';
include('include/header.html');

echo "<h1>Aggiungi Persona</h1>";

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	include('include/insert_persona.php');
	$id = $_POST['id'];
	$sql = "select * from persone where id=$id";
	$stm = $db->query($sql);
	$p = $stm->fetch(PDO::FETCH_BOTH);
}

try {
	include('include/singola_persona.php');
	echo '<form action="aggiungi_persona.php" method="post">';
	$sql = "select * from province order by provincia";
	$stm = $db->query($sql);
	echo singola_persona($p, false, $stm);
	echo '<p><input type="submit" name="submit" value="Submit" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '</form>';
}
catch(PDOException $e) {
	echo $e->getMessage();
}

include('include/footer.html');
?>
