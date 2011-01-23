<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left" style="width:50px;"><b>Selez.</b></th>';
	$table .= '<th align="left" style="width:90px;">Data</th>';
	$table .= '<th align="left" style="width:600px;">Commento</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="center"><input type="checkbox" name="id_evento[]" value="'.$r['id_evento'].'" /></td>';
		$table .= '<td align="left">'.$r['data'].'</td>';
		$table .= '<td align="left"><a href="modifica_evento.php?id_evento='.$r['id_evento'].'">'.$r['commento'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	
	return $table;
}
?>
