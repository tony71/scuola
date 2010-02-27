<?php
if (isset($_POST['submitted']) && ($_POST['submit'] == 'Registra')) {
	$trimmed = array_map('trim', $_POST);
	$sql = 'SELECT aggiorna_curriculum (';
	$sql .= ':matricola, ';
	$sql .= ':data, ';
	$sql .= ':scuola, ';
	$sql .= ':anno, ';
	$sql .= ':classe, ';
	$sql .= ':sezione, ';
	$sql .= ':indirizzo, ';
	$sql .= ':stato)';
	
	require_once('include/db_connection.php');

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(':matricola', $trimmed['matricola'], PDO::PARAM_STR, 10);
                $stm->bindParam(':data', $trimmed['data']);
                $stm->bindParam(':scuola', $trimmed['scuola']);
                $stm->bindParam(':anno', $trimmed['anno']);
                $stm->bindParam(':classe', $trimmed['classe']);
                $stm->bindParam(':sezione', $trimmed['sezione']);
                $stm->bindParam(':indirizzo', $trimmed['indirizzo']);
                $stm->bindParam(':stato', $trimmed['stato']);

                $stm->execute();
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

$page_title = 'Aggiorna Curriculum';
include('include/header.html');

require_once('include/db_connection.php');

if (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
else {
}

try {
	$sql = "select nome, cognome from vista_studenti where matricola=:matricola";
	$stm = $db->prepare($sql);
	$stm->bindParam(":matricola", $matricola, PDO::PARAM_STR, 10);
	$stm->execute();
	$m = $stm->fetch(PDO::FETCH_BOTH);

	echo '<h1>Aggiorna Curriculum per ' . $m['cognome'] . ', ' . $m['nome'] . '</h1>';

	$sql = 'select now()';
	$stm = $db->query($sql);
	$m = $stm->fetch(PDO::FETCH_BOTH);
	$data_attuale = $m['now'];
}
catch(PDOException $e) {
       	echo $e->getMessage();
}

?>

<form action="aggiungi_curriculum.php" method="post">
	<fieldset>
		<legend>Matricola</legend>
		<input type="text" name="matricola" value="<?php echo $matricola; ?>" readonly="readonly" />
	</fieldset>
	<fieldset>
		<legend>Data Evento</legend>
		<input type="text" name="data" value="<?php echo $data_attuale; ?>" />
	</fieldset>
	<fieldset>
		<legend>Scuola</legend>
		<select name="scuola">
			<?php
			require_once('include/db_connection.php');
			include('include/select_scuole_tutte.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Anno scolastico</legend>
		<select name="anno">
			<?php
			require_once('include/db_connection.php');
			include('include/select_anno.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Classe</legend>
		<select name="classe">
			<?php
			require_once('include/db_connection.php');
			include('include/select_classe.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Sezione</legend>
		<select name="sezione">
			<?php
			require_once('include/db_connection.php');
			include('include/select_sezione.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Indirizzo</legend>
		<select name="indirizzo">
			<?php
			require_once('include/db_connection.php');
			include('include/select_indirizzo.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Stato Studente</legend>
		<select name="stato">
			<?php
			require_once('include/db_connection.php');
			include('include/select_stato_studente.php');
			?>
		</select>
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
