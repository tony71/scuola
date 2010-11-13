<?php
require_once('db_connection.php');

$matricola = $_POST['matricola'];
$tmp_file = $_FILES['userfile']['tmp_name'];

$binary = file_get_contents($tmp_file);
$base64 = base64_encode($binary);

$sql = "select id_persona from studenti where matricola_studente='$matricola'";
try {
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$id_persona = $r['id_persona'];
}
catch(PDOException $e) {
	echo $e->getMessage();
}
$sql = "update persone set foto='$base64' where id_persona=$id_persona";
try {
	$stm = $db->query($sql);
}
catch(PDOException $e) {
	echo $e->getMessage();
}

$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = '../dettagli_studente.php?matricola=' . $matricola;
header("Location: http://$host$uri/$extra");
?>
