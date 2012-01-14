<?php

require_once('include/db_connection.php');

$page_title = 'Clienti Studente';
include('include/header.html');

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	$sql = "select matricola_studente from studenti where id_persona=$id_persona";
	try {
		$stm = $db->query($sql);
		$num = $stm->rowCount();
		if ($num != 1) {
			echo '<p class="error">Non sono presenti persone nel DB.</p>';
			echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';
			include('include/footer.html');
			exit();
		}
		$r = $stm->fetch(PDO::FETCH_BOTH);
		$matricola = $r['matricola_studente'];
	
	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}
}

if (isset($_POST['salva'])) 
{
	$sql = 'select salva_clienti(ARRAY[';
	$first = TRUE;
	foreach($_POST['id_persona'] as $key => $value) {
		if ($first == FALSE) {
			$sql .= ', ';
		}
		$sql .= $value;
		$first = FALSE;
	}
	$sql .= "],'" . $matricola . "')";
	$stm = $db->query($sql);
}

$sql = "select nome_breve,cognome_breve from studenti where matricola_studente='$matricola'";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Uhm... studente non trovato.</p>';
		echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';
		include('include/footer.html');
		exit();
	}
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo '<h1>Clienti di ' . $r['nome_breve'] . ' ' . $r['cognome_breve'] . '</h1>';
	
	$sql = "select * from cerca_clienti('$matricola')";
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num == 0) {
		echo '<p class="error">Non sono presenti clienti per questo studente.</p>';
	}
	else {
		include('include/tabella_clienti.php');

		$form = '<form action="clienti.php" method="post">';
		$form .= result_as_table($stm, true);
		$form .= '<input type="submit" name="salva" value="Salva" class="brg" />';
		$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
		$form .= '</form>';
	}
}
catch(PDOException $e) {
        echo $e->getMessage();
}

echo $form;

echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';

include('include/footer.html');
?>
