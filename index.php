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

if (isset($_POST['submitted'])) {
	require_once('include/db_connection.php');
	$sql = "select * from vista_studenti";
	if (isset($nominativo)) {
		$sql .= " where cognome like UPPER('%$nominativo%')";
		$sql .= " or UPPER(nome) like UPPER('%$nominativo%')";
	}
	$sql .= " order by cognome, nome";
	try {
		$stm = $db->query($sql);
		$num = $stm->rowCount();
		if ($num > 0) {
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
?>

<h1>Content Header</h1>
	<p>Primo paragrafo</p>
	<p>Secondo paragrafo</p>
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
include('include/footer.html');
?>
