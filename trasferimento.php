<?php
require_once('include/db_connection.php');

if (isset($_POST['submitted']) && ($_POST['submit'] == 'Registra')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'SELECT * from stato_studente_trasferito (';
	$sql .= ':matricola, ';
	$sql .= ':data)';
	

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(':matricola', $trimmed['matricola'], PDO::PARAM_STR, 10);
                $stm->bindParam(':data', $trimmed['data']);

                $stm->execute();
		$r = $stm->fetch(PDO::FETCH_BOTH);
		if ($r['stato_studente_trasferito'] == false) {
                	echo '<p class="error">Errore</p>';
			exit;
		}
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		exit;
        }

	$host  = $_SERVER['HTTP_HOST'];
	$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
	$extra = 'dettagli_studente.php?matricola=' . $trimmed['matricola'];
	header("Location: http://$host$uri/$extra");
}

$page_title = 'Trasferimento';
include('include/header.html');

if (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
else {
}

try {
	$sql = "select nome, cognome from vista_studenti where matricola_studente=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Trasferisci ' . $m['cognome'] . ', ' . $m['nome'] . '</h1>';
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

<form action="trasferimento.php" method="post">
	<fieldset>
		<legend>Matricola</legend>
		<input type="text" name="matricola" value="<?php echo $matricola; ?>" readonly="readonly" />
	</fieldset>
	<fieldset>
		<legend>Data Evento</legend>
		<input type="text" name="data" value="<?php echo date("d-m-Y"); ?>" />
	</fieldset>
	<div align="center">
		<input type="submit" name="submit" value="Registra" />
		<a href="curriculum.php?matricola=<?php echo $matricola; ?>">Back</a>
	</div>
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
include('include/footer.html');
?>
