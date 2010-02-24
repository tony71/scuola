<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";

	$table .= '<th align="left">A.S.</th>';
	$table .= '<th align="left">Stato</th>';
	$table .= '<th align="left">Data Evento</th>';
	$table .= '<th align="left">Classe</th>';
	$table .= '<th align="left">Sezione</th>';
	$table .= '<th align="left">Indirizzo</th>';
	$table .= '<th align="left">Scuola</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left">'.$r['anno_scolastico'].'</td>';
		$table .= '<td align="left">'.$r['stato_studente'].'</td>';
		$table .= '<td align="center">'.$r['data_evento'].'</td>';
		$table .= '<td align="center">'.$r['classe'].'</td>';
		$table .= '<td align="left">'.$r['sezione'].'</td>';
		$table .= '<td align="left">'.$r['indirizzo'].'</td>';
		$table .= '<td align="left">'.$r['denominazione'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
