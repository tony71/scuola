<?php
function result_as_table($result, $tableFeatures="", $link)
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left">N.</th>';
	$table .= '<th align="left">G/F</th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=nome">Nome</th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=cognome">Cognome</th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=data">Data di Nascita</th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=comune">Comune di Nascita</th>';
	$table .= '<th align="left"><a href="'.$link.'&sort=matricola">Matricola</th>';
	$bg = '#fff';
	$i = 1;
		
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		
		if ( is_null($r['matricola_studente']) ) {
			$mi = 'famiglia.php?id_famiglia='.$r['id_famiglia'];
			}
		else {	
			$mi = 'dettagli_studente.php?matricola='.$r['matricola_studente'];
			}
			
		$bg = ($bg=='#ddd' ? '#fff' : '#ddd');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left"><a href="'. $mi .'">' . $i . '</a></td>';
		$table .= '<td align="left">' . $r['tipo_parentela'] . '</td>';
		$table .= '<td align="left"><a href="'. $mi .'">' . $r['nome'] . '</a></td>';
		$table .= '<td align="left"><a href="'. $mi .'">' . $r['cognome'] . '</a></td>';
		$table .= '<td align="left">'.$r['data_nascita'].'</td>';
		$table .= '<td align="left">'.$r['comune_nascita'].'</td>';
		$table .= '<td align="left"><a href="'. $mi .'">' . $r['matricola_studente'] . '</a></td>';
		$table .= "</tr>\n";
		$i++;
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
