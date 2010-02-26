<?php
function singola_persona($r, $readonly=true)
{
	if ($readonly == true) {
		$s = 'readonly="readonly" ';
	}
	else {
		$s = '';
	}
		

	$result = '<fieldset>';

	$result .= '<legend>Dati Personali:</legend>';

	$result .= '<label for="nome">Nome:</label>';
	$result .= '<input type="text" name="nome" id="nome" size="15" maxlength="50" value="' . (isset($r) ? $r['nome'] : '') . '" ' . $s . ' />';

	$result .= '<label for="cognome">Cognome:</label>';
	$result .= '<input type="text" name="cognome" id="cognome" size="15" maxlength="50" value="' . (isset($r) ? $r['cognome'] : '') . '" ' . $s . ' />';

	$result .= '<label for="sesso">Sesso:</label>';
	$result .= '<input type="text" name="sesso" id="sesso" size="1" maxlength="1" value="' . (isset($r) ? $r['sesso'] : '') . '" ' . $s . ' />';

	$result .= '<label for="id_famiglia">Famiglia:</label>';
	$result .= '<input type="text" name="id_famiglia" id="id_famiglia" size="5" maxlength="50" value="' . (isset($r) ? $r['id_famiglia'] : '') . '" ' . $s . ' />';

	$result .= '<label for="tipo_parentela">Tipo Parentela:</label>';
	$result .= '<input type="text" name="tipo_parentela" id="tipo_parentela" size="1" maxlength="1" value="' . (isset($r) ? $r['tipo_parentela'] : '') . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="codice_fiscale">Codice Fiscale:</label>';
	$result .= '<input type="text" name="codice_fiscale" id="codice_fiscale" size="16" maxlength="16" value="' . (isset($r) ? $r['codice_fiscale'] : '') . '" ' . $s . ' />';

	$result .= '<label for="professione">Professione:</label>';
	$result .= '<input type="text" name="professione" id="professione" size="16" maxlength="100" value="' . (isset($r) ? $r['professione'] : '') . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="data_nascita">Data di Nascita:</label>';
	$result .= '<input type="text" name="data_nascita" id="data_nascita" size="10" maxlength="10" value="' . (isset($r) ? $r['data_nascita'] : '') . '" ' . $s . ' />';

	$result .= '<label for="luogo_nascita">Luogo di Nascita:</label>';
	$result .= '<input type="text" name="luogo_nascita" id="luogo_nascita" size="15" maxlength="30" value="' . (isset($r) ? $r['luogo_nascita'] : '') . '" ' . $s . ' />';

	$result .= '<label for="cittadinanza">Cittadinanza:</label>';
	$result .= '<input type="text" name="cittadinanza" id="cittadinanza" size="15" maxlength="30" value="' . (isset($r) ? $r['cittadinanza'] : '') . '" ' . $s . ' />';

	$result .= '</fieldset>';

	$result .= '<fieldset>';

	$result .= '<legend>Domicilio:</legend>';

	$result .= '<label for="via">Via:</label>';
	$result .= '<input type="text" name="via" id="via" size="15" maxlength="50" value="' . (isset($r) ? $r['via'] : '') . '" ' . $s . ' />';

	$result .= '<label for="numero_civico">Numero Civico:</label>';
	$result .= '<input type="text" name="numero_civico" id="numero_civico" size="5" maxlength="10" value="' . (isset($r) ? $r['numero_civico'] : '') . '" ' . $s . ' />';

	$result .= '<label for="citta">Citta</label>';
	$result .= '<input type="text" name="citta" id="citta" size="15" maxlength="40" value="' . (isset($r) ? $r['citta'] : '') . '" ' . $s . ' />';

	$result .= '<label for="id_provincia">Provincia</label>';
	$result .= '<input type="text" name="id_provincia" id="id_provincia" size="5" maxlength="10" value="' . (isset($r) ? $r['id_provincia'] : '') . '" ' . $s . ' />';

	$result .= '<label for="cap">CAP</label>';
	$result .= '<input type="text" name="cap" id="cap" size="5" maxlength="5" value="' . (isset($r) ? $r['cap'] : '') . '" ' . $s . ' />';

	$result .= '<label for="quartiere">Quartiere:</label>';
	$result .= '<input type="text" name="quartiere" id="quartiere" size="2" maxlength="2" value="' . (isset($r) ? $r['quartiere'] : '') . '" ' . $s . ' />';

	$result .= '</fieldset>';

	return $result;
}
?>
