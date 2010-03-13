<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";

	$table .= '<th align="left">A.S.</th>';
	$table .= '<th align="left">Data Inizio</th>';
	$table .= '<th align="left">Data Fine</th>';
	$table .= '<th align="left">Stato</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left">'.$r['anno_scolastico'].'</td>';
		$table .= '<td align="left">'.$r['data_inizio'].'</td>';
		$table .= '<td align="left">'.$r['data_fine'].'</td>';
		$table .= '<td align="left">'.$r['stato_studente'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
