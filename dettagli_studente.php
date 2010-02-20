<?php
$page_title = 'Dettagli Studente';
include('include/header.html');

if ((isset($_GET[id])) && (is_numeric($_GET[id]))) {
	$id = $_GET[id];
}
elseif ((isset($_POST[id])) && (is_numeric($_POST[id]))) {
	$id = $_POST[id];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}
echo "<h1>Dettagli Studente $id</h1>";

require_once('include/db_connection.php');
$sql = "select * from vista_studenti where id=$id";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti studenti nel DB.</p>';
		include('include/footer.html');
		exit();
	}
	
	include('include/singolo_studente.php');
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo singolo_studente($r, true);
	$matricola = $r['matricola'];
	include('include/tab_studente.html');
}
catch(PDOException $e) {
        echo $e->getMessage();
}
include('include/footer.html');
?>
