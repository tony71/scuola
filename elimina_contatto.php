<?php
require_once('include/db_connection.php');
$id_persona = $_GET['id_persona'];
$contatto = $_GET['contatto'];
$commento = $_GET['commento'];
$sql = "DELETE FROM contatti_persona WHERE id_persona=$id_persona AND contatto='$contatto' AND commento='$commento'";
try {
	$stm = $db->query($sql);
}
catch(PDOException $e) {
       	echo $e->getMessage();
}
$host  = $_SERVER['HTTP_HOST'];
$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
$extra = 'contatti.php?id_persona=' . $id_persona;
header("Location: http://$host$uri/$extra");
?>

