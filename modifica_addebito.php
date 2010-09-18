<?php

require_once('include/db_connection.php');

if (isset($_GET['id_addebito'])) {
	$id_addebito = $_GET['id_addebito'];
}
elseif (isset($_POST['id_addebito'])) {
	$id_addebito = $_POST['id_addebito'];
}
else {
	echo '<p class="error">Mancano dati per visualizzare qualcosa di sensato</p>';
	include('include/footer.html');
	exit();
}
try {
	$sql = "select matricola from addebiti where id_addebito=$id_addebito";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$matricola = $r['matricola'];
}
catch(PDOException $e) {
	echo $e->getMessage();
	syslog(LOG_INFO, $e->getMessage());
}

if (isset($_POST['submitted'])) {

	include('include/update_addebito.php');
	
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'addebiti.php?matricola=' . $matricola;
	header("Location: http://$host$uri/$extra");

}

$page_title = 'Modifica Addebito';
include('include/header.html');

echo "<h1>Modifica Addebito $id_addebito</h1>";

$sql = "select * from addebiti where id_addebito=$id_addebito limit 1";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti addebiti nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/singolo_addebito.php');
	echo '<form action="modifica_addebito.php" method="post">';
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo singolo_addebito($db, $r, false);
	echo '<p><input type="submit" name="submit" value="Salva" /></p>';
	echo '<input type="hidden" name="submitted" value="TRUE" />';
	echo '<input type="hidden" name="id_addebito" value="'.$id_addebito.'" />';
	echo '</form>';
	
}
catch(PDOException $e) {
	echo $e->getMessage();
	syslog(LOG_INFO, $e->getMessage());
}

echo '<a href="addebiti.php?matricola=' . $matricola . '">Torna agli Addebiti</a>';

include('include/footer.html');
?>
