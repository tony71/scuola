<?php
$page_title = 'Benvenuti a Scuola';
include('include/header.html');
?>

<h1>Content Header</h1>
	<p>Primo paragrafo</p>
	<p>Secondo paragrafo</p>
<form>
	<fieldset>
		<legend>Nome o Cognome</legend>
		<input type="text" name="nominativo" />
	</fieldset>
</form>
<form>
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
</form>
<form>
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
</form>
<form>
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
</form>
<form>
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
</form>
<form>
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
</form>
<form>
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
</form>
<?php
include('include/footer.html');
?>
