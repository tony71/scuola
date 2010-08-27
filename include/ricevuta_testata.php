<?php
function ricevuta_testata($r)
{
	$s = 'readonly="readonly" ';

	$result = '<fieldset>';

	$result .= '<legend>Ricevuta n&deg; '.$r['codice_scuola'].' - '.$r['numero_ricevuta'].':</legend>';

	$result .= '<label for="importo">Importo:</label>';
	$result .= '<input type="text" name="importo" id="importo" size="10" maxlength="10" value="' . $r['importo_totale'] . '" ' . $s . ' />';

	$result .= '<label for="data">Data:</label>';
	$result .= '<input type="text" name="data" id="data" size="30" maxlength="30" value="' . $r['data_ricevuta'] . '" ' . $s . ' />';

	$result .= '<br />';

	$result .= '<label for="tipo_pagamento">Tipo Pagamento:</label>';
	$result .= '<input type="text" name="tipo_pagamento" id="tipo_pagamento" size="1" maxlength="1" value="' . $r['tipo_pagamento'] . '"  />';

	$result .= '</fieldset>';

	return $result;
}
?>
