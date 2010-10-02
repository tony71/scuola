<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	// $table .= '<th align="left"><b>Dettagli</b></th>';
	$table .= '<th align="left"><b>Stampa</b></th>';
	/******
	for ($i = 1; $i < $noFields; $i++) {
		$meta = $result->getColumnMeta($i);
		$field = $meta["name"];
		$table .= '<th align="left">'.$field.'</th>';
	}
	*******/
	$table .= '<th align="left">Numero</th>';
	$table .= '<th align="left">Importo</th>';
	$table .= '<th align="left">Data</th>';
	$table .= '<th align="left">Tipo</th>';
	$table .= '<th align="left">Scuola</th>';
	$table .= '<th align="left">A.S.</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		// $table .= '<td align="left"><a href="dettagli_ricevuta.php?id_ricevuta=' . $r['id_ricevuta'] . '">Dettagli</a></td>';
		$table .= '<td align="left"><a href="stampa_ricevuta.php?id_ricevuta=' . $r['id_ricevuta'] . '" target="_blank">Stampa</a></td>';
		/****
		// foreach ($r as $column) {
		for ($i = 1; $i < $noFields; ++$i) {
			$table .= '<td align="left">'.$r[$i].'</td>';
		}
		****/
		$table .= '<td align="left">'.$r['numero_ricevuta'].'</td>';
		$table .= '<td align="left">'.$r['importo_totale'].'</td>';
		$table .= '<td align="left">'.$r['data_ricevuta'].'</td>';
		$table .= '<td align="left">'.$r['tipo_pagamento'].'</td>';
		$table .= '<td align="left">'.$r['codice_scuola'].'</td>';
		$table .= '<td align="left">'.$r['anno_scolastico'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
