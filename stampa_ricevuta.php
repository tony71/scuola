<?php
if (function_exists('PDF_new')) {
	// echo "PDFlib is available.<br />\n";
} else {
	echo "PDFlib is not available.<br />\n";
}

if (extension_loaded('pdf')) {
	// echo "PDFlib is available.<br />\n";
} else {
	echo "Manca la libreria PDFlib.<br />\n";
}

if ((isset($_GET['id_ricevuta'])) && (is_numeric($_GET['id_ricevuta']))) {
	$id_ricevuta = $_GET['id_ricevuta'];
}
elseif ((isset($_POST['id_ricevuta'])) && (is_numeric($_POST['id_ricevuta']))) {
	$id_ricevuta = $_POST['id_ricevuta'];
}
else {
	die("Error: Non trovo id_ricevuta");
}

require_once('include/db_connection.php');

try {
	$euro = chr(128)." ";
	$ricevuta = new PDFLib();


	if ($ricevuta->begin_document("","") == 0) {
		echo "Error";
		die("Error: " . $ricevuta->get_errmsg());
	}
	$ricevuta->set_info("Creator", "stampa_ricevuta.php");
	$ricevuta->set_info("Author", "Oratorio Salesiano Michele Rua");
	$ricevuta->set_info("Title", "Ricevuta");

	// Per far si che &euro; stampi il simbolo di euro
	// NON FUNZIONA :-(
	// $ricevuta->set_parameter("charref", "true");

	// Formato A4
	$ricevuta->begin_page_ext(595, 842, "");
	
	// inizio HEADER
	$ricevuta->rect(50, 670, 495, 130);
	$ricevuta->stroke();

	// $top_left = "./images/pdf/top_left.jpeg";
	$top_left = "top_left.jpeg";
	// $top_right = "./images/pdf/top_right.jpeg";
	$top_right = "top_right.jpeg";
	$image = $ricevuta->load_image("jpeg", $top_left, "");
	if (!$image) {
		die("Errore: " . $ricevuta->get_errmsg());
	}
	$ricevuta->fit_image($image, 51, 740, "scale 0.5");
	$ricevuta->close_image($image);

	$image = $ricevuta->load_image("jpeg", $top_right, "");
	if (!$image) {
		die("Errore: " . $ricevuta->get_errmsg());
	}
	$ricevuta->fit_image($image, 500, 740, "scale 0.6");
	$ricevuta->close_image($image);

	$font = $ricevuta->load_font("Times-Italic", "winansi", "");
	$ricevuta->setfont($font, 20.0);
	$ricevuta->fit_textline("Oratorio Salesiano",326,780,"position={right bottom}");
	$ricevuta->setfont($font, 10.0);
	$ricevuta->fit_textline("Scuola dell'Infanzia",150,720,"position={center bottom}");
	$ricevuta->fit_textline("Scuola Primaria",300,720,"position={center bottom}");
	$ricevuta->fit_textline("Scuola Secondaria",450,720,"position={center bottom}");
	$ricevuta->fit_textline("Paritaria",150,710,"position={center bottom}");
	$ricevuta->fit_textline("Parificata Paritaria",300,710,"position={center bottom}");
	$ricevuta->fit_textline("di Primo Grado Paritaria",450,710,"position={center bottom}");

	$font = $ricevuta->load_font("Times-BoldItalic", "winansi", "");
	$ricevuta->setfont($font, 20.0);
	$ricevuta->fit_textline("Michele Rua",330,780,"position={left bottom}");
	$ricevuta->setfont($font, 10.0);
	$ricevuta->fit_textline("\"Mamma Margherita\"",150,700,"position={center bottom}");
	$ricevuta->fit_textline("\"San Domenico Savio\"",300,700,"position={center bottom}");
	$ricevuta->fit_textline("\"Michele Rua\"",450,700,"position={center bottom}");

	$font = $ricevuta->load_font("Times-Roman", "winansi", "");
	$ricevuta->setfont($font, 10.0);
	$ricevuta->fit_textline("Via Paisiello 37, Torino - Tel. 011 2304 111 - Fax 011 2304 166", 300, 760, "position={center bottom}");
	$ricevuta->fit_textline("e-mail info@michelerua.it - www.michelerua.it",300, 750, "position={center bottom}");
	$ricevuta->fit_textline("c.f. e p. IVA 01802240018", 300, 740, "position={center bottom}");
	// fine HEADER

	// inizio FOOTER
	$font = $ricevuta->load_font("Helvetica", "winansi", "");
	$ricevuta->setfont($font, 9.0);
	$ricevuta->fit_textline("Operazioni esenti da IVA, ai sensi dell'art. 10 del D.P.R. 26 ottobre 1972, n. 633 e successive modificazioni", 300, 40, "position={center bottom}");
	$ricevuta->setfont($font, 14.0);
	$ricevuta->fit_textline("Distinti saluti.", 50, 130, "position={left bottom}");
	$ricevuta->fit_textline("Oratorio Salesiano Michele Rua", 545, 100, "position={right bottom}");
	$ricevuta->fit_textline("Ufficio Amministrazione", 545, 80, "position={right bottom}");
	// fine FOOTER

	/********************************************************
	$font = $ricevuta->load_font("Helvetica", "unicode", "");
	$ricevuta->setfont($font, 24.0);
	// $ricevuta->fit_textline("Hello!&euro;",50,400, "position={left bottom}");
	$ricevuta->fit_textline("Hello!",50,400, "position={left bottom}");
	*************************************************************/

	$font = $ricevuta->load_font("Helvetica", "winansi", "");
	$ricevuta->setfont($font, 13.0);
	
	$sql = "select * from vista_ricevute_new where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	$r = $stm->fetch(PDO::FETCH_BOTH);
	$sql = "select * from mostra_cliente_ricevuta($id_ricevuta)";
	$stm = $db->query($sql);
	$r2 = $stm->fetch(PDO::FETCH_BOTH);
	$txt = "Ricevuta del ";
	$ricevuta->fit_textline($txt, 290, 620, "position={left bottom}");
	$txt = $r['data_it'];
	$txt .= "     n. ";
	$txt .= $r['codice_scuola'];
	$txt .= "-";
	$txt .= $r['numero_ricevuta'];
	
	$nr = $r['codice_scuola']."-".$r['numero_ricevuta'];

	$font = $ricevuta->load_font("Helvetica-Bold", "winansi", "");
	$ricevuta->setfont($font, 13.0);

	$ricevuta->fit_textline($txt, 370, 620, "position={left bottom}");

	$font = $ricevuta->load_font("Helvetica", "winansi", "");
	$ricevuta->setfont($font, 13.0);

	$txt = "Genitore      ".$r2['cognome']." ".$r2['nome']." - C.F. ".$r2['codice_fiscale'];
	$ricevuta->fit_textline($txt, 50, 580, "position={left bottom}");

	$txt = "Allievo/a     ";
	$ricevuta->fit_textline($txt, 50, 540, "position={left bottom}");

	$font = $ricevuta->load_font("Helvetica-Bold", "winansi", "");
	$ricevuta->setfont($font, 13.0);
	$txt = $r['cognome']." ".$r['nome']." - C.F. ".$r['codice_fiscale'];
	$ricevuta->fit_textline($txt, 120, 540, "position={left bottom}");

	$font = $ricevuta->load_font("Helvetica", "winansi", "");
	$ricevuta->setfont($font, 13.0);

	$txt = $r['denominazione']." - "."matricola  ".$r['matricola_studente'];
	$ricevuta->fit_textline($txt, 50, 520, "position={left bottom}");

	$txt = "Si dichiara di ricevere la somma di ";
	$ricevuta->fit_textline($txt, 50, 480, "position={left bottom}");

	//$txt .= "Euro".$r['importo_totale_it'];
	$txt = $euro.$r['importo_totale_it'];
	
	$font = $ricevuta->load_font("Helvetica-Bold", "winansi", "");
	$ricevuta->setfont($font, 13.0);
	$ricevuta->fit_textline($txt, 260, 480, "position={left bottom}");

	$font = $ricevuta->load_font("Helvetica", "winansi", "");
	$ricevuta->setfont($font, 13.0);

	$txt = "per il pagamento di quanto sotto meglio descritto:";
	$ricevuta->fit_textline($txt, 50, 460, "position={left bottom}");

	$sql = "select * from vista_ricevute_riga where id_ricevuta=$id_ricevuta";
	$stm = $db->query($sql);
	$y = 430;
	while($r = $stm->fetch(PDO::FETCH_BOTH)) {
		$txt = $euro.$r['importo_riga_it'];
		$ricevuta->fit_textline($txt, 50, $y, "position={left bottom}");
		$txt = $r['nuova_causale'];
		// $txt .= ' (' . $r['descrizione_tipo'] . ')';
		$ricevuta->fit_textline($txt, 150, $y, "position={left bottom}");
		$txt = 'a.s. ' . $r['anno_scolastico'];
		$ricevuta->fit_textline($txt, 545, $y, "position={right bottom}");
		$y -= 20;
	}

	$ricevuta->end_page_ext("");

	$ricevuta->end_document("");

	$buf = $ricevuta->get_buffer();
	$len = strlen($buf);

	header("Content-type: application/pdf");
	header("Content-Length: $len");
	$nome_file = "Ricevuta-".$nr.".pdf";
	header("Content-Disposition: inline; filename=$nome_file");
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
$ricevuta = 0;
?>
