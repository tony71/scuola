<?php
function singolo_studente($r, $readonly=true, $prov)
{
	if ($readonly == true) {
		$s = 'readonly="readonly" ';
	}
	else {
		$s = '';
	}
		
	include('singola_persona.php');
	$result = singola_persona($r, $readonly, $prov);

	$result .= '<fieldset>';
	$result .= '<legend>Dati Studente</legend>';

	$result .= '<label for="matricola">Matricola:</label>';
	$result .= '<input type="text" name="matricola" id="matricola" size="10" maxlength="10" value="' . (isset($r) ? $r['matricola_studente'] : '') . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="cognome_breve">Cognome Breve:</label>';
	$result .= '<input type="text" name="cognome_breve" id="cognome_breve" size="15" maxlength="30" value="' . (isset($r) ? $r['cognome_breve'] : '') . '" ' . $s . ' />';

	$result .= '<label for="nome_breve">Nome Breve:</label>';
	$result .= '<input type="text" name="nome_breve" id="nome_breve" size="15" maxlength="30" value="' . (isset($r) ? $r['nome_breve'] : '') . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="vaccinazioni"> Vaccinazioni:</label>';
	$result .= '<input type="checkbox" name="vaccinazioni" id="vaccinazioni" value="vaccinazioni" ';
	$result .= (isset($r) && ($r['vaccinazioni'] == true) ? 'checked="checked" ' : '');
	$result .= ($readonly == true ? 'disabled="disabled" ' : '');
	$result .= ' />';

	$result .= '<label for="anni_scuola_materna">Anni Scuola Materna:</label>';
	$result .= '<input type="text" name="anni_scuola_materna" id="anni_scuola_materna" size="2" maxlength="2" value="' . (isset($r) ? $r['anni_scuola_materna'] : '') . '" ' . $s . ' />';

	$result .= '<label for="certificato_medico"> Certificato Medico:</label>';
	$result .= '<input type="checkbox" name="certificato_medico" id="certificato_medico" value="certificato_medico" ';
	$result .= (isset($r) && ($r['certificato_medico'] == true) ? 'checked="checked" ' : '');
	$result .= ($readonly == true ? 'disabled="disabled" ' : '');
	$result .= ' />';

	$result .= '<label for="hc">HC:<label>';
	$result .= '<input type="checkbox" name="hc" id="hc" value="hc" ';
	$result .= (isset($r) && ($r['hc'] == true) ? 'checked="checked" ' : '');
	$result .= ($readonly == true ? 'disabled="disabled" ' : '');
	$result .= ' />';

	$result .= '<label for="caso_speciale">Caso Speciale:</label>';
	$result .= '<input type="checkbox" name="caso_speciale" id="caso_speciale" value="caso_speciale" ';
	$result .= (isset($r) && ($r['caso_speciale'] == true) ? 'checked="checked" ' : '');
	$result .= ($readonly == true ? 'disabled="disabled" ' : '');
	$result .= ' />';

	$result .= '<br />';

	$result .= '<div>';
	$result .= '<label for="motivazione_cs">Motivazione caso speciale:</label>';
	$result .= '<br />';
	$result .= '<textarea name="motivazione_cs" id="motivazione_cs" rows="2" cols="73" ' . $s . '>';
	$result .= (isset($r) ? $r['motivazione_cs'] : '') . '</textarea>';
	$result .= '</div>';

	$result .= '<div>';
	$result .= '<label for="controindicazioni_mensa">Controindicazioni Mensa:</label>';
	$result .= '<br />';
	$result .= '<textarea name="controindicazioni_mensa" id="controindicazioni_mensa" rows="2" cols="73" ' . $s . '>';
	$result .= (isset($r) ? $r['controindicazioni_mensa'] : '') . '</textarea>';
	$result .= '</div>';

	$result .= '<div>';
	$result .= '<label for="note">Note:</label>';
	$result .= '<br />';
	$result .= '<textarea name="note" id="note" rows="2" cols="73" ' . $s . '>';
	$result .= (isset($r) ? $r['note'] : '') . '</textarea>';
	$result .= '</div>';

	$result .= '</fieldset>';

	return $result;
}

?>
