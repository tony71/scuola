<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left">N.</th>';
	// $table .= '<th align="left">Matricola</th>';
	$table .= '<th align="left">Nome</th>';
	$table .= '<th align="left">Cognome</th>';
	$table .= '<th align="left">Data di Nascita</th>';
	$table .= '<th align="left">Luogo di Nascita</th>';
	$bg = '#eeeeee';
	$i = 1;
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left"><a href="dettagli_studente.php?matricola='.$r['matricola'].'">' . $i . '</a></td>';
		// $table .= '<td align="left"><a href="dettagli_studente.php?matricola='.$r['matricola'].'">' . $r['matricola'] . '</a></td>';
		$table .= '<td align="left"><a href="dettagli_studente.php?matricola='.$r['matricola'].'">' . $r['nome'] . '</a></td>';
		$table .= '<td align="left"><a href="dettagli_studente.php?matricola='.$r['matricola'].'">' . $r['cognome'] . '</a></td>';
		$table .= '<td align="left">'.$r['data_nascita'].'</td>';
		$table .= '<td align="left">'.$r['luogo_nascita'].'</td>';
		$table .= "</tr>\n";
		$i++;
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
