<?php
function singolo_contatto($db, $r, $readonly=true)
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
	$result .= html_input_text($db, 'contatto', 'contatti_persona', (isset($r) ? $r['contatto'] : ''), $readonly);
	$result .= html_input_text($db, 'commento', 'contatti_persona', (isset($r) ? $r['commento'] : ''), $readonly);
	$result .= '</fieldset>';

	return $result;
}
?>
