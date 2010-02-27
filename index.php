<?php
$page_title = 'Benvenuti a Scuola';
include('include/header.html');

if (isset($_POST['submitted'])) {
	$nominativo = $_POST['nominativo'];
}
elseif (isset($_GET['nominativo'])) {
	$nominativo = $_GET['nominativo'];
}
else {
}

if (isset($_POST['scuola'])) {
	$scuola = $_POST['scuola'];
}
elseif (isset($_GET['scuola'])) {
	$scuola = $_GET['scuola'];
}
if ($scuola == 'Tutte') {
	unset($scuola);
}

if (isset($_POST['anno'])) {
	$anno = $_POST['anno'];
}
elseif (isset($_GET['anno'])) {
	$anno = $_GET['anno'];
}
if ($anno == 'Tutti') {
	unset($anno);
}

if (isset($_POST['classe'])) {
	$classe = $_POST['classe'];
}
elseif (isset($_GET['classe'])) {
	$classe = $_GET['classe'];
}
if ($classe == 'Tutte') {
	$classe = 'null';
}

if (isset($_POST['sezione'])) {
	$sezione = $_POST['sezione'];
}
elseif (isset($_GET['sezione'])) {
	$sezione = $_GET['sezione'];
}
if ($sezione == 'Tutte') {
	unset($sezione);
}

if (isset($_POST['indirizzo'])) {
	$indirizzo = $_POST['indirizzo'];
}
elseif (isset($_GET['indirizzo'])) {
	$indirizzo = $_GET['indirizzo'];
}
if ($indirizzo == 'Tutti') {
	unset($indirizzo);
}

if (isset($_POST['stato'])) {
	$stato = $_POST['stato'];
}
elseif (isset($_GET['stato'])) {
	$stato = $_GET['stato'];
}
if ($stato == 'Tutti') {
	unset($stato);
}

$num = 0;

if (isset($_POST['submitted'])) {
	require_once('include/db_connection.php');
	$sql = "select * from cerca_studenti('$nominativo','$scuola','$anno',$classe,'$sezione','$indirizzo','$stato')";
	$sql .= " order by cognome, nome";
	try {
		$stm = $db->query($sql);
		$num = $stm->rowCount();
		if ($num > 0) {
			echo '<h1>Studenti trovati: '. $num . '</h1>';
			require('include/tabella_studenti.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
		}
		else {
			echo '<p class="error">Non trovo studenti nel DB.</p>';
		}
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
}
else {
?>

<form action="index.php" method="post">
	<fieldset>
		<legend>Nome o Cognome</legend>
		<input type="text" name="nominativo" />
	</fieldset>
	<fieldset>
		<legend>Scuola</legend>
		<select name="scuola">
			<option name="tutte">Tutte </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_scuole.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Anno scolastico</legend>
		<select name="anno">
			<option name="tutti">Tutti </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_anno.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Classe</legend>
		<select name="classe">
			<option name="tutte">Tutte </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_classe.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Sezione</legend>
		<select name="sezione">
			<option name="tutte">Tutte </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_sezione.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Indirizzo</legend>
		<select name="indirizzo">
			<option name="tutti">Tutti </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_indirizzo.php');
			?>
		</select>
	</fieldset>
	<fieldset>
		<legend>Stato Studente</legend>
		<select name="stato">
			<option name="tutti">Tutti </option>
			<?php
			require_once('include/db_connection.php');
			include('include/select_stato_studente.php');
			?>
		</select>
	</fieldset>
	<input type="submit" name="submit" value="Cerca" />
	<input type="hidden" name="submitted" value="TRUE" />
</form>
<?php
}
include('include/footer.html');
?>
