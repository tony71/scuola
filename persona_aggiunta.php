<?php
$page_title = 'Persona Aggiunta';

require_once('include/db_connection.php');

if (isset($_POST['id_persona'])) {
	$id_persona = $_POST['id_persona'];
}
else if (isset($_GET['id_persona'])) {
	$id_persona = $_GET['id_persona'];
}
else {
}

try {
	$sql = "select * from persone where id=$id_persona";
	$stm = $db->query($sql);
	$p = $stm->fetch(PDO::FETCH_BOTH);
}
catch(PDOException $e) {
	echo $e->getMessage();
	exit;
}

include('include/header.html');

echo "<h1>Aggiunto/a ".$p['cognome'].", ".$p['nome']." nel DB</h1>";

echo '<form action="aggiungi_persona.php" method="post">';
echo '<p><input type="submit" name="submit" value="OK" /></p>';
echo '</form>';

include('include/footer.html');
?>
