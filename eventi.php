<?php

require_once('include/db_connection.php');

$page_title = 'Eventi Studente';
include('include/header.html');
/*
if (isset($_GET['id_persona']) && is_numeric($_GET['id_persona'])) {
	$id_persona = $_GET['id_persona'];
}
elseif (isset($_POST['id_persona']) && is_numeric($_POST['id_persona'])) {
	$id_persona = $_POST['id_persona'];
}
else {
	echo '<p class="error">Hai aperto questa pagina per errore? (id_persona).</p>';
	include('include/footer.html');
	exit();
}
*/
if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	/*
	echo '<p class="error">This page has been accessed in error (matricola).</p>';
	include('include/footer.html');
	exit();
	*/
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

if (isset($_POST['elimina'])) 
{
	$sql = 'select elimina_evento(ARRAY[';
	$first = TRUE;
	foreach($_POST['id_evento'] as $key => $value) {
		if ($first == FALSE) {
			$sql .= ', ';
		}
		$sql .= $value;
		$first = FALSE;
	}
	$sql .= '])';
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
	echo '<h1>Eventi di ' . $r['nome_breve'] . ' ' . $r['cognome_breve'] . '</h1>';
	
	$sql = "select * from eventi_studente where matricola_studente='$matricola' order by data";
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num == 0) {
		echo '<p class="error">Non sono presenti eventi per questo studente.</p>';
		/*
		echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';
		include('include/footer.html');
		exit();
		*/
	}
	else {
		include('include/tabella_eventi.php');

		$form = '<form action="eventi.php" method="post">';
		$form .= result_as_table($stm, true);
		$form .= '<input type="submit" name="elimina" value="Elimina Evento" class="brg" />';
		$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
		$form .= '</form>';
	}
}
catch(PDOException $e) {
        echo $e->getMessage();
}

$form .= '<form action="aggiungi_evento.php" method="post">';
$form .= '<input type="submit" name="nuovo_evento" value="Crea Nuovo Evento" class="brg" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '<input type="hidden" name="matricola" value="'.$matricola.'" />';
$form .= '</form>';


echo $form;

echo '<a href="dettagli_studente.php?matricola=' . $matricola . '">Torna a Dettagli Studente</a>';

include('include/footer.html');
?>
