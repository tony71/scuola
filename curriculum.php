<?php
$page_title = 'Curriculum Studente';
include('include/header.html');

if (isset($_GET[matricola])) {
	$matricola = $_GET[matricola];
}
elseif (isset($_POST[matricola])) {
	$matricola = $_POST[matricola];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}

require_once('include/db_connection.php');
$sql = "select distinct nome,cognome from vista_studenti_cv where matricola_studente='$matricola'";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti studenti nel DB.</p>';
		include('include/footer.html');
		exit();
	}
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo '<h1>Curriculum di ' . $r['cognome'] . ', ' . $r['nome'] . '</h1>';
	
	$sql = "select anno_scolastico, classe, sezione, indirizzo, denominazione  from vista_studenti_cv where matricola_studente='$matricola'";
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num == 0) {
		echo '<p class="error">Non sono presenti curriculum nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/tabella_curriculum.php');
	echo result_as_table($stm, true);
}
catch(PDOException $e) {
        echo $e->getMessage();
}

echo '<br /><div align="center">';
$form = '<form action="aggiungi_curriculum.php" method="post">';
$form .= '<input type="submit" name="nuovo_curriculum" value="Aggiorna Curriculum" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
$form .= '</form>';
echo $form;

echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';

include('include/footer.html');
?>
