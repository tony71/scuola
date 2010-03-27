<?php
require_once('include/db_connection.php');

if (isset($_GET['esito'])) {
	$esito = $_GET['esito'];
}
elseif (isset($_POST['esito'])) {
	$esito = $_POST['esito'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

if (isset($_GET['as'])) {
	$as = $_GET['as'];
}
elseif (isset($_POST['as'])) {
	$as = $_POST['as'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

if ($esito == "positivo") {
	$sql = "select * from promuovi('$matricola', '$as')";
}
elseif ($esito == "negativo") {
	$sql = "select * from boccia('$matricola', '$as')";
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	exit();
}

try {
	$stm = $db->query($sql);
	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'curriculum.php?matricola=' . $matricola;
	header("Location: http://$host$uri/$extra");
}
catch(PDOException $e) {
        echo $e->getMessage();
}
?>
