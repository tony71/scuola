<?php
$page_title = 'Dettagli Studente';
include('include/header.html');

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	echo '<p class="error">This page has been accessed in error.</p>';
	include('include/footer.html');
	exit();
}

echo "<h1>Dettagli Studente $matricola</h1>";


require_once('include/db_connection.php');
$sql = "select * from vista_studenti_senza_curriculum where matricola_studente='$matricola'";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num == 1) {
		echo '<p class="error"><a href="aggiungi_curriculum.php?matricola='.$matricola.'">Attenzione: Aggiungi Curriculum</a></p>';
	}
}
catch(PDOException $e) {
        echo $e->getMessage();
}

$sql = "select distinct id_persona,matricola_studente";
$sql .= ",nome,cognome,nome_breve,cognome_breve";
$sql .= ",sesso,id_famiglia,tipo_parentela";
$sql .= ",data_nascita,luogo_nascita,cittadinanza";
$sql .= ",codice_fiscale,vaccinazioni,note";
$sql .= ",controindicazioni_mensa";
$sql .= ",consegnato_modulo,certificato_medico,anni_scuola_materna";
$sql .= ",caso_speciale,motivazione_cs,hc";
$sql .= ",via,numero_civico,citta";
$sql .= ",id_provincia,provincia,cap,quartiere";
$sql .= ",professione";
$sql .=" from vista_studenti_cv where matricola_studente='$matricola'";
try {
	$stm = $db->query($sql);
	$num = $stm->rowCount();
	if ($num != 1) {
		echo '<p class="error">Non sono presenti studenti nel DB.</p>';
		include('include/footer.html');
		exit();
	}
	
	include('include/singolo_studente.php');
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$sql = 'select * from province order by provincia';
	$stm = $db->query($sql);
	echo singolo_studente($r, true, $stm);
	$matricola = $r['matricola_studente'];
	$id = $r['id_persona'];
	include('include/tab_studente.html');
}
catch(PDOException $e) {
        echo $e->getMessage();
}
include('include/footer.html');
?>
