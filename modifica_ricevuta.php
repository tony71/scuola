<?php
$page_title = 'Modifica Ricevuta';
include('include/header.html');

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
echo "<h1>Modifica Ricevuta $id_ricevuta</h1>";

if (isset($_POST['submitted'])) {
	include('include/update_ricevuta_testata.php');
	include('include/update_ricevuta_riga.php');
}

$sql = "select * from ricevute where id_ricevuta=$id_ricevuta";
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
	echo '<p><input type="submit" name="submit" value="Submit" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id_ricevuta" value="' . $id_ricevuta .'" />';
	echo '</form>';
}
catch(PDOException $e) {
	echo $e->getMessage();
}

include('include/footer.html');
?>
