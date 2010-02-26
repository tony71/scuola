<?php
$page_title = 'Aggiungi Persona';
include('include/header.html');

echo "<h1>Aggiungi Persona</h1>";

require_once('include/db_connection.php');

if (isset($_POST['submitted'])) {
	include('include/insert_persona.php');
}

try {
	include('include/singola_persona.php');
	echo '<form action="aggiungi_persona.php" method="post">';
	echo singola_persona(null, false);
	echo '<p><input type="submit" name="submit" value="Submit" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '</form>';
}
catch(PDOException $e) {
	echo $e->getMessage();
}

include('include/footer.html');
?>
