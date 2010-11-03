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
$num = 0;

$sort = (isset($_GET['sort'])) ? $_GET['sort'] : 'default';

switch ($sort) {
	case 'nome':
		$order_by = 'nome asc';
		break;
	case 'cognome':
		$order_by = 'cognome asc';
		break;
	case 'data':
		$order_by = 'data_nascita asc';
		break;
	case 'comune':
		$order_by = 'comune_nascita asc';
		break;
	case 'matricola':
		$order_by = 'matricola_studente asc';
		break;
	case 'default':
		$order_by = 'cognome, nome';
		break;
	default:
		$order_by = 'cognome, nome';
		$sort = 'default';
		break;
}

if (isset($_POST['submitted']) or isset($_GET['submitted'])) {
	$nominativo = pg_escape_string($nominativo);
	$sql = "select * from cerca_studente('$nominativo')";
	$sql .= " order by $order_by";
	try {
		$stm = $db->query($sql);
		$num = $stm->rowCount();
		if ($num > 1) {
			echo '<h1>Nominativi trovati: '. $num . '</h1>';
			require('include/tabella_persone.php');
			echo result_as_table($stm, 'align="center" cellspacing="5" cellpadding="5" width="75%"', "main_index.php?nominativo=$nominativo&submitted=TRUE");
		}
		else 
		{
			if ($num == 1) {
				$host  = $_SERVER['HTTP_HOST'];
				$uri   = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
				$r     = $stm->fetch(PDO::FETCH_BOTH);
				$extra = 'dettagli_studente.php?matricola='.$r['matricola_studente'];
				header("Location: http://$host$uri/$extra");
			}
			else 
			{ 
				echo '<p class="error">Non trovo nominativi nel DB.</p>'; 
			}
		}
		$titolo ='Nominativi';
		$filename = 'studenti.xls';
		// echo '<a href="genera_excel.php?sql='.$sql.'&titolo='.$titolo.'&filename='.$filename.'" target="_blank">Excel</a>';
		echo '<form action="genera_excel.php" method="post">';
		echo '<input type="submit" name="submit" value="Esporta in Excel" />';
		echo '<input type="hidden" name="sql" value="'.$sql.'" />';
		echo '<input type="hidden" name="title" value="'.$titolo.'" />';
		echo '<input type="hidden" name="filename" value="'.$filename.'" />';
		echo '<input type="hidden" name="submitted" value="TRUE" />';
		echo '</form>';
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
}
else {
?>
<div id="main_search">
<form action="main_index.php" method="post">
	<fieldset>
		<label>Ricerca Studenti per Cognome</label>
		<input type="text" name="nominativo" class="rg" />
	</fieldset>
	<input type="submit" name="submit" value="Cerca" class="brg" />
	<input type="hidden" name="submitted" value="TRUE" />
</form>
</div>
<?php
}
include('statistiche.php');
include('include/footer.html');
?>
