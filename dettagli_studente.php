<?php
require_once('include/db_connection.php');

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
$sql .= ",data_nascita,sigla_provincia_nascita,sigla_comune_nascita";
$sql .= ",sigla_stato_nascita";
$sql .= ",codice_fiscale,vaccinazioni,note";
$sql .= ",controindicazioni_mensa";
$sql .= ",consegnato_modulo,certificato_medico,anni_scuola_materna";
$sql .= ",caso_speciale,motivazione_cs,hc";
$sql .= ",via,numero_civico,citta";
$sql .= ",sigla_provincia_residenza,provincia_residenza,cap,quartiere";
$sql .= ",sigla_comune_residenza,sigle_stati_cittadinanza";
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
	$ss = singolo_studente($r, true, $db);
	$matricola = $r['matricola_studente'];
	$id = $r['id_persona'];
	include('include/tab_studente.html');
	echo $ss;
}

catch(PDOException $e) {
        echo $e->getMessage();
}
include('include/footer.html');
?>
