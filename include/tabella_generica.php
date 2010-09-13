<?php
function result_as_table($result, $tableFeatures="")
{
	$table = "<table $tableFeatures>\n\n";
	$noFields = $result->columnCount();
	$table .= "<tr>\n";
	for ($i = 0; $i < $noFields; $i++) {
		$meta = $result->getColumnMeta($i);
		$field = $meta["name"];
		$table .= '<th>'.$field.'</th>';
	}
	$table .= "</tr>\n";
	while ($r = $result->fetch(PDO::FETCH_BOTH)) {
		$table .= '<tr>';
		// foreach ($r as $column) {
		for ($i = 0; $i < $noFields; ++$i) {
			$table .= '<td>'.htmlentities($r[$i]).'</td>';
		}
		$table .= "</tr>\n";
	}
	$table .= "</table>\n\n";
	return $table;
}
?>
