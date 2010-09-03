<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left"><b>Seleziona</b></th>';
	/******
	for ($i = 1; $i < $noFields; $i++) {
		$meta = $result->getColumnMeta($i);
		$field = $meta["name"];
		$table .= '<th align="left">'.$field.'</th>';
	}
	*******/
	$table .= '<th align="left">Causale</th>';
	$table .= '<th align="left">Tipo</th>';
	$table .= '<th align="left">Importo</th>';
	$table .= '<th align="left">Pagato</th>';
	$table .= '<th align="left">Residuo</th>';
	$table .= '<th align="left">Data Scadenza</th>';
	$table .= '<th align="left">A. S.</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="center"><input type="checkbox" name="id_addebito[]" value="'.$r['id_addebito'].'" /></td>';
		/****
		// foreach ($r as $column) {
		for ($i = 1; $i < $noFields; ++$i) {
			$table .= '<td align="left">'.$r[$i].'</td>';
		}
		****/
		$table .= '<td align="left">'.$r['causale'].'</td>';
		$table .= '<td align="left">'.$r['descrizione_tipo'].'</td>';
		$table .= '<td align="left">'.$r['importo'].'</td>';
		$table .= '<td align="left">'.$r['saldo'].'</td>';
		$table .= '<td align="left">'.$r['importo_residuo'].'</td>';
		$table .= '<td align="left">'.$r['data_scadenza'].'</td>';
		$table .= '<td align="left">'.$r['anno_scolastico'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
