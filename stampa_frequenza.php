<?php
if (function_exists('PDF_new')) {
	// echo "PDFlib is available.<br />\n";
} else {
	echo "PDFlib is not available.<br />\n";
}

if (extension_loaded('pdf')) {
	// echo "PDFlib is available.<br />\n";
} else {
	echo "PDFlib is not available.<br />\n";
}

if (isset($_GET['matricola'])) {
	$matricola = $_GET['matricola'];
}
elseif (isset($_POST['matricola'])) {
	$matricola = $_POST['matricola'];
}
else {
	die("Error: Non trovo matricola studente");
}

require_once('include/db_connection.php');

try {
	$doc = new PDFLib();


	if ($doc->begin_document("","") == 0) {
		echo "Error";
		die("Error: " . $doc->get_errmsg());
	}
	$doc->set_info("Creator", "stampa_frequenza.php");
	$doc->set_info("Author", "tony");
	$doc->set_info("Title", "Certificato Frequenza");

	// Per far si che &euro; stampi il simbolo di euro
	// NON FUNZIONA :-(
	// $doc->set_parameter("charref", "true");

	// Formato A4
	$doc->begin_page_ext(595, 842, "");
	
	// inizio HEADER

	// $top_right = "./images/pdf/top_right.jpeg";
	$top_right = "sds.jpg";
	$image = $doc->load_image("jpeg", $top_right, "");
	if (!$image) {
		die("Error: " . $doc->get_errmsg());
	}
	$doc->fit_image($image, 450, 740, "scale 0.6");
	$doc->close_image($image);

	$font = $doc->load_font("Times-Roman", "winansi", "");
	$doc->setfont($font, 10.0);
	$doc->fit_textline("Scuola Primaria Parificata Paritaria \"San Domenico Savio\"", 100, 760, "position={left bottom}");
	$doc->fit_textline("Via Paisiello 37 - 10154 Torino - Tel. 011 2304 111 - Fax 011 2304 166", 100, 750, "position={left bottom}");
	$doc->fit_textline("e-mail: primaria@michelerua.it - sito web: www.michelerua.it/primaria",100, 740, "position={left bottom}");
	// fine HEADER

	/*******************************************************
	$font = $doc->load_font("Helvetica", "winansi", "");
	$doc->setfont($font, 24.0);
	$doc->fit_textline("Hello!&euro;",50,400, "position={left bottom}");
	*********************************************************/

	$doc->setfont($font, 15.0);
	$txt = "Torino, ";
	require('include/oggi.php');
	$txt .= oggi($db);
	$doc->fit_textline($txt, 50, 620, "position={left bottom}");
	$doc->fit_textline("Prot. num. ", 50, 600, "position={left bottom}");
	$doc->fit_textline("Oggetto: dichiarazione di iscrizione e frequenza.", 50, 540, "position={left bottom}");
	$doc->fit_textline("La sottoscritta suor Maria Giuseppina Iasottile,", 50, 500, "position={left bottom}");
	$doc->fit_textline("in qualita' di Coordinatrice delle Attivita' Educative e Didattiche", 50, 480, "position={left bottom}");
	$doc->fit_textline("della Scuola Primaria Parificata Paritaria \"San Domenico Savio\",", 50, 460, "position={left bottom}");
	$doc->fit_textline("DICHIARA", 300, 440, "position={left bottom}");
	$txt = "che l'alunno/a ";
	$doc->fit_textline($txt, 50, 420, "position={left bottom}");
	$txt = "nato/a a ";
	$doc->fit_textline($txt, 50, 400, "position={left bottom}");
	$txt = "il ";
	$doc->fit_textline($txt, 50, 380, "position={left bottom}");
	$txt = "risulta iscritto/a e frequenta regolarmente la classe ";
	$doc->fit_textline($txt, 50, 360, "position={left bottom}");
	$txt = "presso la nostra scuola, nell'anno scolastico ";
	$doc->fit_textline($txt, 50, 340, "position={left bottom}");
	$doc->fit_textline("Si rilascia il presente certificato su richiesta della famiglia,", 50, 300, "position={left bottom}");
	$doc->fit_textline("per gli usi consentiti dalla legge.", 50, 280, "position={left bottom}");
	$doc->fit_textline("La Coordinatrice delle Attività Educative e Didattiche", 200, 200, "position={right bottom}");
	$doc->fit_textline("(Maria Giuseppina Iasottile)", 200, 180, "position={right bottom}");


	$doc->end_page_ext("");

	$doc->end_document("");

	$buf = $doc->get_buffer();
	$len = strlen($buf);

	header("Content-type: application/pdf");
	header("Content-Length: $len");
	header("Content-Disposition: inline; filename=hello.pdf");
	print $buf;
}
catch (PDFlibException $e) {
	echo "Error";
	die("PDFlib exception occurred in hello sample:\n" .
	"[" . $e->get_errnum() . "] " . $e->get_apiname() . ": " .
	$e->get_errmsg() . "\n");
}
catch(PDOException $e) {
	echo $e->getMessage();
}
catch (Exception $e) {
	echo "Error";
	die($e);
}
$doc = 0;
?>
