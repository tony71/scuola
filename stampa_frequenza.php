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
	$doc->fit_image($image, 500, 740, "scale 0.6");
	$doc->close_image($image);

	$font = $doc->load_font("Times-Roman", "winansi", "");
	$doc->setfont($font, 10.0);
	$doc->fit_textline("Scuola Primaria Parificata Paritaria \"San Domenico Savio\"", 150, 760, "position={left bottom}");
	$doc->fit_textline("Via Paisiello 37 - 10154 Torino - Tel. 011 2304 111 - Fax 011 2304 166", 150, 750, "position={left bottom}");
	$doc->fit_textline("e-mail: primaria@michelerua.it - sito web: www.michelerua.it/primaria",150, 740, "position={left bottom}");
	// fine HEADER

	/*******************************************************
	$font = $doc->load_font("Helvetica", "winansi", "");
	$doc->setfont($font, 24.0);
	$doc->fit_textline("Hello!&euro;",50,400, "position={left bottom}");
	*********************************************************/

	/*
	$sql = "select * from vista_ricevute where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$txt = "Ricevuta del ";
	$txt .= $r['data_it'];
	$txt .= "     n.o ";
	$txt .= $r['codice_scuola'];
	$txt .= " / ";
	$txt .= $r['numero_ricevuta'];
	$doc->fit_textline($txt, 150, 620, "position={left bottom}");

	$txt = "Allievo / a     ";
	$txt .= $r['cognome'];
	$doc->fit_textline($txt, 150, 600, "position={left bottom}");

	$txt = "                      ";
	$txt .= $r['nome'];
	$doc->fit_textline($txt, 150, 580, "position={left bottom}");

	$txt = $r['denominazione'];
	$doc->fit_textline($txt, 150, 560, "position={left bottom}");

	$txt = "Si dichiara di ricevere la somma di ";
	$txt .= $r['importo_totale_it'];
	$doc->fit_textline($txt, 50, 520, "position={left bottom}");

	$txt = "per il pagamento di quanto sotto meglio descritto:";
	$doc->fit_textline($txt, 50, 500, "position={left bottom}");

	$sql = "select * from vista_ricevute_riga where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	$y = 480;
	while($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$txt = $r['importo_riga_it'];
		$txt .= ' ' . $r['causale'];
		$txt .= ' (' . $r['descrizione_tipo'] . ')';
		$doc->fit_textline($txt, 50, $y, "position={left bottom}");
		$txt = ' a.s. ' . $r['anno_scolastico'];
		$doc->fit_textline($txt, 545, $y, "position={right bottom}");
		$y -= 20;
	}
	*/

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
