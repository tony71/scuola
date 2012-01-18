<?php
function result_as_table($result, $tableFeatures="", $id_cliente)
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left" style="width:50px;"><b>Default</b></th>';
	$table .= '<th align="left" style="width:150;">Cognome</th>';
	$table .= '<th align="left" style="width:150;">Nome</th>';
	$table .= '<th align="left" style="width:150;">Codice Fiscale</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="center"><input type="radio" name="id_persona" value="'.$r['id_persona'].'" ';
		$table .= ( $id_cliente == $r['id_persona'] ? $r['is_default'] : '') . ' /></td>';
		$table .= '<td align="left">'.$r['cognome'].'</td>';
		$table .= '<td align="left">'.$r['nome'].'</td>';
		$table .= '<td align="left">'.$r['codice_fiscale'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	
	return $table;
}
?>
