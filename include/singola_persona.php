<?php
function singola_persona($r, $readonly=true, $db, $tmp_file)
{
	if ($readonly == true) {
		$s = 'readonly="readonly" ';
	}
	else {
		$s = '';
	}
		

	$result = '<fieldset>';

	$result .= '<legend>Dati Anagrafici</legend>';

	/*
	$result .= '<label for="nome" class="required">Nome:</label>';
	$result .= '<input type="text" name="nome" id="nome" size="15" maxlength="50" value="' . (isset($r) ? $r['nome'] : '') . '" ' . $s . ' />';
	*/
	require_once('html_input_text.php');
	$result .= '<img src="'.$tmp_file.'" align="right"/>';

	$result .= html_input_text($db, 'cognome', 'persone', (isset($r) ? pg_escape_string($r['cognome']) : ''), $readonly);
	$result .= html_input_text($db, 'nome', 'persone', (isset($r) ? pg_escape_string($r['nome']) : ''), $readonly);
	$result .= '<br />';
	$result .= html_input_text($db, 'sesso', 'persone', (isset($r) ? $r['sesso'] : ''), $readonly);
	$result .= html_input_text($db, 'id_famiglia', 'persone', (isset($r) ? pg_escape_string($r['id_famiglia']) : ''), $readonly);
	$result .= html_input_text($db, 'tipo_parentela', 'persone', (isset($r) ? $r['tipo_parentela'] : ''), $readonly);
	$result .= '<br />';
	$result .= html_input_text($db, 'professione', 'persone', (isset($r) ? $r['professione'] : ''), $readonly);

	/*
	$result .= '<label for="cognome" class="required">Cognome:</label>';
	$result .= '<input type="text" name="cognome" id="cognome" size="15" maxlength="50" value="' . (isset($r) ? $r['cognome'] : '') . '" ' . $s . ' />';

	$result .= '<label for="sesso" class="required">Sesso:</label>';
	$result .= '<input type="text" name="sesso" id="sesso" size="1" maxlength="1" value="' . (isset($r) ? $r['sesso'] : '') . '" ' . $s . ' />';

	$result .= '<label for="id_famiglia" class="required">Famiglia:</label>';
	$result .= '<input type="text" name="id_famiglia" id="id_famiglia" size="5" maxlength="50" value="' . (isset($r) ? $r['id_famiglia'] : '') . '" ' . $s . ' />';

	$result .= '<label for="tipo_parentela" class="required">Tipo Parentela:</label>';
	$result .= '<input type="text" name="tipo_parentela" id="tipo_parentela" size="1" maxlength="1" value="' . (isset($r) ? $r['tipo_parentela'] : '') . '" ' . $s . ' />';
	*/

	$result .= '<br />';
	
	$result .= html_input_text($db, 'data_nascita', 'persone', (isset($r) ? $r['data_nascita'] : ''), $readonly);
	$result .= html_input_text($db, 'codice_fiscale', 'persone', (isset($r) ? $r['codice_fiscale'] : ''), $readonly);
	/*
	$result .= '<label for="codice_fiscale">Codice Fiscale:</label>';
	$result .= '<input type="text" name="codice_fiscale" id="codice_fiscale" size="16" maxlength="16" value="' . (isset($r) ? $r['codice_fiscale'] : '') . '" ' . $s . ' />';

	$result .= '<label for="professione">Professione:</label>';
	$result .= '<input type="text" name="professione" id="professione" size="16" maxlength="100" value="' . (isset($r) ? $r['professione'] : '') . '" ' . $s . ' />';
	*/

	$result .= '<br />';

	/*
	$result .= '<label for="data_nascita">Data di Nascita:</label>';
	$result .= '<input type="text" name="data_nascita" id="data_nascita" size="10" maxlength="10" value="' . (isset($r) ? $r['data_nascita'] : '') . '" ' . $s . ' />';
	*/

	$result .= '<label for="provincia_nascita">Provincia di Nascita:</label>';
	$result .= '<select name="provincia_nascita" id="provincia_nascita"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= ' onChange="showComuni(this)">';
	require_once('select_provincia.php');
	$result .= isset($r['sigla_provincia_nascita']) ? '' : '<option></option>';
	$p_n = isset($r['sigla_provincia_nascita']) ? $r['sigla_provincia_nascita'] : 'TO';
	$result .= select_provincia($db, $p_n);
	$result .= '</select>';

	$result .= '<br />';

	$result .= '<label for="comune_nascita">Comune di Nascita:</label>';
	$result .= '<select name="comune_nascita" id="comune_nascita"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_comune.php');
	$result .= isset($r['sigla_comune_nascita']) ? '' : '<option></option>';
	if (isset($r['sigla_comune_nascita'])) {
		$result .= select_comune($db, $r['sigla_comune_nascita'], $p_n);
	}
	else {
		$result .= select_comune($db, 'L219', $p_n);
	}
	$result .= '</select>';

	$result .= '<br />';

	$result .= '<label for="stato_nascita">Stato Estero di Nascita:</label>';
	$result .= '<select name="stato_nascita" id="stato_nascita"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_nazione.php');
	$result .= isset($r['sigla_stato_nascita']) ? '' : '<option></option>';
	$result .= select_nazione($db, $r['sigla_stato_nascita']);
	$result .= '</select>';

	$result .= '<br />';

	if (isset($r['sigle_stati_cittadinanza'])) {
		$str = trim($r['sigle_stati_cittadinanza'], '{}');
		$ssc = explode(',', $str);
	}
	$result .= '<label for="prima_cittadinanza">Prima Cittadinanza:</label>';
	$result .= '<select name="cittadinanza[]" id="prima_cittadinanza"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_nazione.php');
	$result .= isset($ssc[0]) ? '' : '<option></option>';
	$result .= select_nazione($db, $ssc[0]);
	$result .= '</select>';

	$result .= '<br />';

	$result .= '<label for="seconda_cittadinanza">Seconda Cittadinanza:</label>';
	$result .= '<select name="cittadinanza[]" id="seconda_cittadinanza"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_nazione.php');
	$result .= isset($ssc[1]) ? '' : '<option></option>';
	$p = isset($ssc[1]) ? $ssc[1] : null;
	$result .= select_nazione($db, $p);
	$result .= '</select>';

	$result .= '<br />';
	// $result .= '<label for="luogo_nascita">Luogo di Nascita:</label>';
	// $result .= '<input type="text" name="luogo_nascita" id="luogo_nascita" size="15" maxlength="30" value="' . (isset($r) ? $r['luogo_nascita'] : '') . '" ' . $s . ' />';

	// $result .= '<label for="cittadinanza">Cittadinanza:</label>';
	// $result .= '<input type="text" name="cittadinanza" id="cittadinanza" size="15" maxlength="30" value="' . (isset($r) ? $r['cittadinanza'] : '') . '" ' . $s . ' />';

	$result .= '</fieldset>';

	$result .= '<fieldset>';

	$result .= '<legend>Dati Residenza</legend>';

	$result .= '<label for="via">Indirizzo:</label>';
	$result .= '<input type="text" name="via" id="via" size="50" maxlength="60" value="' . (isset($r) ? $r['via'] : '') . '" ' . $s . ' />';

	$result .= '<label for="numero_civico">N&deg;:</label>';
	$result .= '<input type="text" name="numero_civico" id="numero_civico" size="5" maxlength="10" value="' . (isset($r) ? $r['numero_civico'] : '') . '" ' . $s . ' />';

	$result .= '<label for="cap">CAP</label>';
	$result .= '<input type="text" name="cap" id="cap" size="5" maxlength="5" value="' . (isset($r) ? $r['cap'] : '') . '" ' . $s . ' />';

	$result .= '<label for="quartiere">Quartiere:</label>';
	$result .= '<input type="text" name="quartiere" id="quartiere" size="2" maxlength="2" value="' . (isset($r) ? $r['quartiere'] : '') . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="provincia_residenza">Provincia:</label>';
	$result .= '<select name="provincia_residenza" id="provincia_residenza"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= ' onChange="showComuni(this)">';
	require_once('select_provincia.php');
	$result .= isset($r['sigla_provincia_residenza']) ? '' : '<option></option>';
	$p_r = isset($r['sigla_provincia_residenza']) ? $r['sigla_provincia_residenza'] : 'TO';
	$result .= select_provincia($db, $p_r);
	$result .= '</select>';

	$result .= '<br />';

	$result .= '<label for="comune_residenza">Comune:</label>';
	$result .= '<select name="comune_residenza" id="comune_residenza"';
	$result .= ($readonly == true ? ' disabled="disabled"' : '');
	$result .= '>';
	require_once('select_comune.php');
	$result .= isset($r['sigla_comune_residenza']) ? '' : '<option></option>';
	if (isset($r['sigla_comune_residenza'])) {
		$result .= select_comune($db, $r['sigla_comune_residenza'], $r['sigla_provincia_residenza']);
	}
	else {
		$result .= select_comune($db, 'L219', $p_r);
	}
	$result .= '</select>';

/*	$result .= '<label for="citta">Citta</label>';
	$result .= '<input type="text" name="citta" id="citta" size="15" maxlength="40" value="' . (isset($r) ? $r['citta'] : '') . '" ' . $s . ' />';
*/
	$result .= '</fieldset>';

	return $result;
}
?>
