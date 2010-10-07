<?php
require_once('include/db_connection.php');

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
/*$first = TRUE;
foreach($scuola as $key => $value) {
	if ($first == FALSE) {
		$lista_scuole .= ', ';
	}
	$lista_scuole .= "'" . $value . "'";
	$first = FALSE;
}
*/
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

if (isset($_POST['data'])) {
	$data = $_POST['data'];
}
elseif (isset($_GET['data'])) {
	$data = $_GET['data'];
}
if (empty($data)) {
	$data = 'NULL';
}
else {
	$data = "'".$data."'";
}

if (isset($_POST['amministrazione'])) {
	$amministrazione = $_POST['amministrazione'];
}
elseif (isset($_GET['amministrazione'])) {
	$amministrazione = $_GET['amministrazione'];
}

$num = 0;

if (isset($_POST['submitted'])) {
	if ($amministrazione == 'giornalieri') {
		try {
			$sql = "select * from crea_report_giornaliero_ricevuta($data,'$scuola')  order by tipo, cognome, nome";
			$stm = $db->query($sql);
			$titolo = 'Report giornaliero '.$scuola;
			$filename = 'Report-giornaliero.xls';
			echo '<form action="genera_excel.php" method="post">';
			echo '<input type="submit" name="submit" value="Esporta in Excel" />';
			echo '<input type="hidden" name="sql" value="'.$sql.'" />';
			echo '<input type="hidden" name="title" value="'.$titolo.'" />';
			echo '<input type="hidden" name="filename" value="'.$filename.'" />';
			echo '<input type="hidden" name="submitted" value="TRUE" />';
			echo '</form>';
			require_once('include/tabella_generica.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	else if ($amministrazione == 'mensili') {
		try {
			$sql = "select * from crea_report_mensile_ricevuta($data,'$scuola')  order by data, tipo";
			$stm = $db->query($sql);
			$titolo = 'Report mensile '.$scuola;
			$filename = 'Report-mensile.xls';
			echo '<form action="genera_excel.php" method="post">';
			echo '<input type="submit" name="submit" value="Esporta in Excel" />';
			echo '<input type="hidden" name="sql" value="'.$sql.'" />';
			echo '<input type="hidden" name="title" value="'.$titolo.'" />';
			echo '<input type="hidden" name="filename" value="'.$filename.'" />';
			echo '<input type="hidden" name="submitted" value="TRUE" />';
			echo '</form>';
			require_once('include/tabella_generica.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"');
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	else if ($amministrazione == 'arretrati') {
		try {
			$sql = "select * from vista_report_arretrati  order by cognome, nome";
			$stm = $db->query($sql);
			$titolo = 'Report arretrati';
			$filename = 'Report-arretrati.xls';
			echo '<form action="genera_excel.php" method="post">';
			echo '<input type="submit" name="submit" value="Esporta in Excel" />';
			echo '<input type="hidden" name="sql" value="'.$sql.'" />';
			echo '<input type="hidden" name="title" value="'.$titolo.'" />';
			echo '<input type="hidden" name="filename" value="'.$filename.'" />';
			echo '<input type="hidden" name="submitted" value="TRUE" />';
			echo '</form>';
			require_once('include/tabella_arretrati.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"', null);
		}
		catch(PDOException $e) {
			echo $e->getMessage();
		}
	}
	else {
		$sql = "select * from cerca_studenti('$nominativo','$scuola','$anno',$classe,'$sezione','$indirizzo','$stato',$data)";
		$sql .= " order by cognome, nome";
		try {
			$stm = $db->query($sql);
			$num = $stm->rowCount();
			if ($num > 0) {
				echo '<h1>Studenti trovati: '. $num . '</h1>';
				$titolo ='Report';
				$filename = 'report.xls';
				// echo '<a href="genera_excel.php?sql='.$sql.'&titolo='.$titolo.'&filename='.$filename.'" target="_blank">Excel</a>';
				echo '<form action="genera_excel.php" method="post">';
				echo '<input type="submit" name="submit" value="Esporta in Excel" />';
				echo '<input type="hidden" name="sql" value="'.$sql.'" />';
				echo '<input type="hidden" name="title" value="'.$titolo.'" />';
				echo '<input type="hidden" name="filename" value="'.$filename.'" />';
				echo '<input type="hidden" name="submitted" value="TRUE" />';
				echo '</form>';
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
}
else {
?>

<form action="crea_elenchi.php" method="post">
	<fieldset>
		<legend>Studente</legend>
		<label>Nome o Cognome</label>
		<input type="text" name="nominativo" />
		<label>Anno scolastico</label>
		<select name="anno">
			<option name="tutti">Tutti </option>
			<?php include('include/select_anno.php'); echo select_anno_scolastico($db); ?>
		</select>
		<br />
		<label>Stato Studente</label>
		<select name="stato">
			<option name="tutti">Tutti </option>
			<?php
			include('include/select_stato_studente.php');
			?>
		</select>
		<label>Data</label>
		<!-- <input type="text" name="data" value="<?php require('include/oggi.php'); echo oggi($db); ?>" />-->
		<input type="text" name="data" value="" />
	</fieldset>
	
	<fieldset>
		<legend>Scuola</legend>
		<select name="scuola">
			<?php include('include/select_scuole.php'); ?>
		</select>
	</fieldset>
	
	<fieldset>
		<legend>Classe</legend>
		<label>Anno</label>
		<select name="classe">
			<option name="tutte">Tutte</option>
			<?php include('include/select_classe.php'); ?>
		</select>
		<label>Sezione</label>
		<select name="sezione">
			<option name="tutte">Tutte</option>
			<?php
			include('include/select_sezione.php');
			?>
		</select>
		<label>Indirizzo</label>
		<select name="indirizzo">
			<option name="tutti">Tutti</option>
			<?php
			include('include/select_indirizzo.php');
			?>
		</select>

	</fieldset>

	<fieldset>
		<legend>Amministrazione</legend>
		<label class="etichetta">Arretrati</label>
		<input type="radio" name="amministrazione" value="arretrati" />
		<label class="etichetta">Pagamenti giornalieri</label>
		<input type="radio" name="amministrazione" value="giornalieri" />
		<label class="etichetta">Pagamenti mensili</label>
		<input type="radio" name="amministrazione" value="mensili" />
	</fieldset>


	<input type="submit" name="submit" value="Crea Report" class="brg" />
	<input type="hidden" name="submitted" value="TRUE" />
</form>

<?php
}
include('include/footer.html');
?>
