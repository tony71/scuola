<?php
$page_title = 'Contatti Studente';
include('include/header.html');

if (isset($_GET[id_persona]) && is_numeric($_GET[id_persona])) {
	$id_persona = $_GET[id_persona];
}
elseif (isset($_POST[id_persona]) && is_numeric($_GET[id_persona])) {
	$id_persona = $_POST[id_persona];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}

require_once('include/db_connection.php');
$sql = "select nome,cognome from persone where id=$id_persona";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti persone nel DB.</p>';
		include('include/footer.html');
		exit();
	}
	$r = $stm->fetch(PDO::FETCH_BOTH);
	echo '<h1>Contatti di ' . $r['cognome'] . ', ' . $r['nome'] . '</h1>';
	
	$sql = "select * from contatti_famiglia($id_persona) where id_persona=$id_persona order by cognome, nome";
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num == 0) {
		echo '<p class="error">Non sono presenti contatti nel DB.</p>';
		include('include/footer.html');
		exit();
	}

	include('include/tabella_contatti.php');
	echo result_as_table($stm, true);
}
catch(PDOException $e) {
        echo $e->getMessage();
}

echo '<br /><div align="center">';
$form = '<form action="aggiungi_contatto.php" method="post">';
$form .= '<input type="submit" name="nuovo_contatto" value="Nuovo Contatto" />';
$form .= '<input type="hidden" name="submitted" value="TRUE" />';
$form .= '<input type="hidden" name="id_persona" value="'.$id_persona.'" />';
$form .= '</form>';
echo $form;

include('include/footer.html');
?>
