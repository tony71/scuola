<?php
require_once('include/db_connection.php');
$id_ricevuta = $_GET['id_ricevuta'];
$sql = "select matricola_studente from vista_ricevute2 where id_ricevuta=$id_ricevuta";
try {
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$matricola = $r['matricola_studente'];
}
catch(PDOException $e) {
       	echo $e->getMessage();
}
$sql = "select cancella_ricevuta($id_ricevuta)";
try {
	$stm = $db->query($sql);
}
catch(PDOException $e) {
       	echo $e->getMessage();
}
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'ricevute.php?matricola=' . $matricola;
header("Location: http://$host$uri/$extra");
?>

