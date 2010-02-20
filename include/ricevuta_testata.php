<?php
function ricevuta_testata($r)
{
	$s = 'readonly="readonly" ';

	$result = '<fieldset>';

	$result .= '<legend>Testata:</legend>';

	$result .= '<label for="numero_ricevuta">Numero Ricevuta:</label>';
	$result .= '<input type="text" name="numero_ricevuta" id="numero_ricevuta" size="15" maxlength="15" value="' . $r['numero_ricevuta'] . '" ' . $s . ' />';

	$result .= '<label for="importo">Importo:</label>';
	$result .= '<input type="text" name="importo" id="importo" size="10" maxlength="10" value="' . $r['importo_totale'] . '" ' . $s . ' />';

	$result .= '<label for="data">Data:</label>';
	$result .= '<input type="text" name="data" id="data" size="30" maxlength="30" value="' . $r['data_ricevuta'] . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="tipo_pagamento">Tipo Pagamento:</label>';
	$result .= '<input type="text" name="tipo_pagamento" id="tipo_pagamento" size="1" maxlength="1" value="' . $r['tipo_pagamento'] . '"  />';

	$result .= '<label for="codice_scuola">Codice Scuola:</label>';
	$result .= '<input type="text" name="codice_scuola" id="codice_scuola" size="2" maxlength="2" value="' . $r['codice_scuola'] . '" ' . $s . ' />';

	$result .= '</fieldset>';

	return $result;
}
?>
