<?php
function result_as_table($result, $tableFeatures="", $link)
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	/**********************************************************************************
	$table .= '<th align="left"><a href="'.$link.'&sort=matricola">Matricola</a></th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=nome">Nome</a></th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=cognome">Cognome</a></th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=saldo">Saldo a Oggi</a></th>';
	**********************************************************************************/
	$table .= '<th align="left">Matricola</th>';
	$table .= '<th align="left">Nome</th>';
	$table .= '<th align="left">Cognome</th>';
	$table .= '<th align="left">Saldo a Oggi</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left"><a href="addebiti.php?matricola=' . $r['matricola_studente'] . '">'.$r['matricola_studente'].'</a></td>';
		$table .= '<td align="left">'.$r['nome'].'</td>';
		$table .= '<td align="left">'.$r['cognome'].'</td>';
		$table .= '<td align="left">'.$r['saldo_a_oggi'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
