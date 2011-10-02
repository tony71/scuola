<?php
require_once('include/db_connection.php');
$id_addebito = $_GET['id_addebito'];
$sql = "select matricola from addebiti where id_addebito=$id_addebito";
try {
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$matricola = $r['matricola'];
}
catch(PDOException $e) {
       	echo $e->getMessage();
}
$sql = "select sospendi_addebito($id_addebito)";
try {
	$stm = $db->query($sql);
}
catch(PDOException $e) {
       	echo $e->getMessage();
}
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'addebiti.php?matricola=' . $matricola;
header("Location: http://$host$uri/$extra");
?>

