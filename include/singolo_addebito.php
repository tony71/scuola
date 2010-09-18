<?php
function singolo_addebito($db, $r, $readonly=true)
{
	if ($readonly == true) {
		$s = 'readonly="readonly" ';
	}
	else {
		$s = '';
	}
		

	$result = '<fieldset>';

	$result .= '<legend>Dati</legend>';

	require_once('html_input_text.php');
	$result .= html_input_text($db, 'importo', 'addebiti', (isset($r) ? $r['importo'] : ''), $readonly);
	$result .= html_input_text($db, 'causale', 'addebiti', (isset($r) ? $r['causale'] : ''), $readonly);
	$result .= html_input_text($db, 'data_scadenza', 'addebiti', (isset($r) ? $r['data_scadenza'] : ''), $readonly);
	$result .= '<br />';
	$result .= '<label for="anno_scolastico">Anno Scolastico:</label>';
	$result .= '<select name="anno_scolastico" id="anno_scolastico"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_anno.php');
	$result .= isset($r['anno_scolastico']) ? '' : '<option></option>';
	$result .= select_anno_scolastico($db, $r['anno_scolastico']);
	$result .= '</select>';

	$result .= '</fieldset>';

	return $result;
}
?>
