<?php
function ricevuta_testata($db, $r)
{
	$id_ric = $r['id_ricevuta'];
	$sql2 = "select * from mostra_cliente_ricevuta($id_ric)"; 
	try {
		$stm2 = $db->query($sql2);
		$num2 = $stm2->rowCount();
		if ($num2 < 1) {
			echo '<p class="error">Non sono presenti clienti nel DB.</p>';
			include('include/footer.html');
			exit();
		}

	}
	catch(PDOException $e) {
		echo $e->getMessage();
	}

	$s = 'readonly="readonly" ';

	$result = '<fieldset>';

	$result .= '<legend>Ricevuta n&deg; '.$r['codice_scuola'].' - '.$r['numero_ricevuta'].':</legend>';

	$result .= 'Cliente: ';

    $r2 = $stm2->fetch(PDO::FETCH_BOTH);

	$result .= $r2['cognome'] . ' ' . $r2['nome'] .' - ' .  $r2['codice_fiscale'];
	$result .= '<br />';

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
