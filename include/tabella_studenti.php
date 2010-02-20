<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	$table .= '<th align="left"><b>Dettagli</b></th>';
	$table .= '<th align="left"><b>Modifica</b></th>';
	$table .= '<th align="left"><b>Cancella</b></th>';
	/******
	for ($i = 1; $i < $noFields; $i++) {
		$meta = $result->getColumnMeta($i);
		$field = $meta["name"];
		$table .= '<th align="left">'.$field.'</th>';
	}
	*******/
	$table .= '<th align="left">Matricola</th>';
	$table .= '<th align="left">Nome</th>';
	$table .= '<th align="left">Cognome</th>';
	$bg = '#eeeeee';
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$bg = ($bg=='#eeeeee' ? '#ffffff' : '#eeeeee');
		$table .= '<tr bgcolor="' . $bg . '">';
		$table .= '<td align="left"><a href="dettagli_studente.php?id=' . $r['id'] . '">Dettagli</a></td>';
		$table .= '<td align="left"><a href="modifica_studente.php?id=' . $r['id'] . '">Modifica</a></td>';
		$table .= '<td align="left"><a href="elimina_studente.php?id=' . $r['id'] . '">Elimina</a></td>';
		/****
		// foreach ($r as $column) {
		for ($i = 1; $i < $noFields; ++$i) {
			$table .= '<td align="left">'.$r[$i].'</td>';
		}
		****/
		$table .= '<td align="left">'.$r['matricola'].'</td>';
		$table .= '<td align="left">'.$r['nome'].'</td>';
		$table .= '<td align="left">'.$r['cognome'].'</td>';
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
