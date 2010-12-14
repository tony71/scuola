<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";

/*	$table .= '<th align="left">Nome</th>';
	$table .= '<th align="left">Cognome</th>';
	$table .= '<th align="left">Parentela</th>';
	$table .= '<th align="left">Sesso</th>'; */
	$table .= '<th align="left" style="width:80px;">Elimina</th>';
	$table .= '<th align="left" style="width:80px;">Modifica</th>';
	$table .= '<th align="left" style="width:150px;">Commento</th>';
	$table .= '<th align="left" style="width:200px;">Contatto</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
/*		$table .= '<td align="left">'.$r['nome'].'</td>';
		$table .= '<td align="left">'.$r['cognome'].'</td>';
		$table .= '<td align="center">'.$r['tipo_parentela'].'</td>';
		$table .= '<td align="center">'.$r['sesso'].'</td>'; */
		$table .= '<td align="left"><a href="elimina_contatto.php?id_persona=' . $r['id_persona'] . '&contatto='.$r['contatto'].'&commento='.$r['commento'].'">Elimina</a></td>';
		$table .= '<td align="left"><a href="modifica_contatto.php?id_persona=' . $r['id_persona'] . '&contatto='.$r['contatto'].'&commento='.$r['commento'].'">Modifica</a></td>';
		$table .= '<td align="left">'.$r['commento'].'</td>';
		$table .= '<td align="left">'.$r['contatto'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
