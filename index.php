<?php
$page_title = 'Benvenuti a Scuola';
include('include/header.html');
?>

<h1>Content Header</h1>
	<p>Primo paragrafo</p>
	<p>Secondo paragrafo</p>
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
<?php
include('include/footer.html');
?>
