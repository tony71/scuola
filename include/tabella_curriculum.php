<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";

	$table .= '<th align="left">A.S.</th>';
	$table .= '<th align="left">Classe</th>';
	$table .= '<th align="left">Sezione</th>';
	$table .= '<th align="left">Indirizzo</th>';
	$table .= '<th align="left">Scuola</th>';
	$table .= '<th align="left">Esito</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left">'.$r['anno_scolastico'].'</td>';
		$table .= '<td align="center">'.$r['classe'].'</td>';
		$table .= '<td align="left">'.$r['sezione'].'</td>';
		$table .= '<td align="left">'.$r['indirizzo'].'</td>';
		$table .= '<td align="left">'.$r['denominazione'].'</td>';
		$table .= '<td align="left">'.$r['esito'].'</td>';
		$table .= '<td align="left"><a href="setta_esito.php?esito=positivo&matricola='.$r['matricola_studente'].'&as='.$r['anno_scolastico'].'">Promuovi</a></td>';
		$table .= '<td align="left"><a href="setta_esito.php?esito=negativo&matricola='.$r['matricola_studente'].'&as='.$r['anno_scolastico'].'">Boccia</a></td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
