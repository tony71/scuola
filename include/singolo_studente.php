<?php
function singolo_studente($r, $readonly=true)
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
	$result .= '<input type="text" name="nome" id="nome" size="15" maxlength="50" value="' . $r['nome'] . '" ' . $s . ' />';

	$result .= '<label for="cognome">Cognome:</label>';
	$result .= '<input type="text" name="cognome" id="cognome" size="15" maxlength="50" value="' . $r['cognome'] . '" ' . $s . ' />';

	$result .= '<label for="sesso">Sesso:</label>';
	$result .= '<input type="text" name="sesso" id="sesso" size="1" maxlength="1" value="' . $r['sesso'] . '" ' . $s . ' />';

	$result .= '<label for="id_famiglia">Famiglia:</label>';
	$result .= '<input type="text" name="id_famiglia" id="id_famiglia" size="5" maxlength="50" value="' . $r['id_famiglia'] . '" ' . $s . ' />';

	$result .= '<label for="tipo_parentela">Tipo Parentela:</label>';
	$result .= '<input type="text" name="tipo_parentela" id="tipo_parentela" size="1" maxlength="1" value="' . $r['tipo_parentela'] . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="nome_breve">Nome Breve:</label>';
	$result .= '<input type="text" name="nome_breve" id="nome_breve" size="15" maxlength="30" value="' . $r['nome_breve'] . '" ' . $s . ' />';

	$result .= '<label for="cognome_breve">Cognome Breve:</label>';
	$result .= '<input type="text" name="cognome_breve" id="cognome_breve" size="15" maxlength="30" value="' . $r['cognome_breve'] . '" ' . $s . ' />';

	$result .= '<label for="codice_fiscale">Codice Fiscale:</label>';
	$result .= '<input type="text" name="codice_fiscale" id="codice_fiscale" size="16" maxlength="16" value="' . $r['codice_fiscale'] . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="data_nascita">Data di Nascita:</label>';
	$result .= '<input type="text" name="data_nascita" id="data_nascita" size="10" maxlength="10" value="' . $r['data_nascita'] . '" ' . $s . ' />';

	$result .= '<label for="luogo_nascita">Luogo di Nascita:</label>';
	$result .= '<input type="text" name="luogo_nascita" id="luogo_nascita" size="15" maxlength="30" value="' . $r['luogo_nascita'] . '" ' . $s . ' />';

	$result .= '<label for="cittadinanza">Cittadinanza:</label>';
	$result .= '<input type="text" name="cittadinanza" id="cittadinanza" size="15" maxlength="30" value="' . $r['cittadinanza'] . '" ' . $s . ' />';

	$result .= '</fieldset>';

	$result .= '<label for="matricola">Matricola:</label>';
	$result .= '<input type="text" name="matricola" id="matricola" size="10" maxlength="10" value="' . $r['matricola'] . '" ' . $s . ' />';

	$result .= '<label for="vaccinazioni"> Vaccinazioni:</label>';
	$result .= '<input type="checkbox" name="vaccinazioni" id="vaccinazioni" value="vaccinazioni" ';
	if ($r['vaccinazioni'] == true) {
		$result .= 'checked="checked" ';
	}
	if ($readonly == true) {
		$result .= 'disabled="disabled" ';
	}
	$result .= ' />';

	$result .= '<label class="text_line" for="consegnato_modulo"> Consegnato Modulo:</label>';
	$result .= '<input type="checkbox" name="consegnato_modulo" id="consegnato_modulo" value="consegnato_modulo" ';
	if ($r['consegnato_modulo'] == true) {
		$result .= 'checked="checked" ';
	}
	if ($readonly == true) {
		$result .= 'disabled="disabled" ';
	}
	$result .= ' />';

	$result .= '<label for="certificato_medico"> Certificato Medico:</label>';
	$result .= '<input type="checkbox" name="certificato_medico" id="certificato_medico" value="certificato_medico" ';
	if ($r['certificato_medico'] == true) {
		$result .= 'checked="checked" ';
	}
	if ($readonly == true) {
		$result .= 'disabled="disabled" ';
	}
	$result .= ' />';

	$result .= '<label for="anni_scuola_materna"> Anni Scuola Materna:</label>';
	$result .= '<input type="text" name="anni_scuola_materna" id="anni_scuola_materna" size="2" maxlength="2" value="' . $r['anni_scuola_materna'] . '" ' . $s . ' />';

	$result .= '<div>';
	$result .= '<label for="controindicazioni_mensa">Controindicazioni Mensa:</label>';
	$result .= '<br />';
	$result .= '<textarea name="controindicazioni_mensa" id="controindicazioni_mensa" rows="3" cols="30" ' . $s . '>';
	$result .= $r['controindicazioni_mensa'] . '</textarea>';
	$result .= '</div>';

	$result .= '<div>';
	$result .= '<label for="note">Note:</label>';
	$result .= '<br />';
	$result .= '<textarea name="note" id="note" rows="3" cols="30" ' . $s . '>';
	$result .= $r['note'] . '</textarea>';
	$result .= '</div>';

	$result .= '<div class="giudizio">';
	$result .= '<label for="giudizio1">Giudizio 1:</label>';
	$result .= '<br />';
	$result .= '<textarea name="giudizio1" id="giudizio1" rows="3" cols="30" ' . $s . '>';
	$result .= $r['giudizio1'] . '</textarea>';
	$result .= '</div>';

	$result .= '<div class="giudizio">';
	$result .= '<label for="giudizio2">Giudizio 2:</label>';
	$result .= '<br />';
	$result .= '<textarea name="giudizio2" id="giudizio2" rows="3" cols="30" ' . $s . '>';
	$result .= $r['giudizio2'] . '</textarea>';
	$result .= '</div>';
	// $result .= '<div class="clear"></div>';

	$result .= '<br />';

	$result .= '<label for="caso_speciale"> Caso Speciale:</label>';
	$result .= '<input type="checkbox" name="caso_speciale" id="caso_speciale" value="caso_speciale" ';
	if ($r['caso_speciale'] == true) {
		$result .= 'checked="checked" ';
	}
	if ($readonly == true) {
		$result .= 'disabled="disabled" ';
	}
	$result .= ' />';

	$result .= '<div>';
	$result .= '<label for="motivazione_cs">Motivazione C.S.:</label>';
	$result .= '<br />';
	$result .= '<textarea name="motivazione_cs" id="motivazione_cs" rows="3" cols="30" ' . $s . '>';
	$result .= $r['motivazione_cs'] . '</textarea>';
	$result .= '</div>';

	$result .= '<label for="hc"> HC:<label>';
	$result .= '<input type="checkbox" name="hc" id="hc" value="hc" ';
	if ($r['hc'] == true) {
		$result .= 'checked="checked" ';
	}
	if ($readonly == true) {
		$result .= 'disabled="disabled" ';
	}
	$result .= ' />';

	$result .= '<label for="stato">Stato:</label>';
	$result .= '<input type="text" name="stato" id="stato" size="1" maxlength="" value="' . $r['stato'] . '" ' . $s . ' />';
	return $result;
}
