<?php
function tabella_ricevuta_righe($s, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$table .= "<tr>\n";
	$table .= '<th align="left">Causale</th>';
	$table .= '<th align="left">Importo</th>';
	$bg = '#eeeeee';
	while ($r = $s->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left"><input type="text" name="causale_riga[]" value="'.$r['causale'].'" /></td>';
		$table .= '<td align="left"><input type="text" name="importo_riga[]" value="'.$r['importo_riga'].'" /></td>';
		$table .= '<td align="left"><input type="hidden" name="id_addebito[]" value="'.$r['id_addebito'].'" readonly="readonly" /></td>';
		// $table .= '<td align="left">'.$r['id_addebito'].'</td>';
		$table .= "</tr>\n";

		$id_addebiti[] = $r['id_addebito'];
		$importi_riga[] = $r['importo_riga'];
	}
	$table .= "</table>\n\n";

	$result[] = $table;
	$result[] = $id_addebiti;
	$result[] = $importi_riga;

	return $result;
}
?>
