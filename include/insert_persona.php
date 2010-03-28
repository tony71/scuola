<?php
        // Dati tabella persone
	include('dati_post_persona.php');

        $sql = "SELECT inserisci_persona (";
        $sql .= ":tipo_parentela";
        $sql .= ", :nome";
        $sql .= ", :cognome";
        $sql .= ", :sesso";
        $sql .= ", :id_famiglia";
        $sql .= ", :professione";
        $sql .= ", :data_nascita";
        $sql .= ", :codice_fiscale";
        $sql .= ", :via";
        $sql .= ", :numero_civico";
        $sql .= ", :citta";
        $sql .= ", :cap";
        $sql .= ", :quartiere";
        $sql .= ", :stato_nascita";
        $sql .= ", :provincia_nascita";
        $sql .= ", :comune_nascita";
        $sql .= ", :provincia_residenza";
        $sql .= ", :comune_residenza";
        $sql .= ", ARRAY[";
	$first = TRUE;
	foreach($_POST['cittadinanza'] as $key => $value) {
		if ($first == FALSE) {
			$sql .= ', ';
		}
		$sql .= "'".$value."'";
		$first = FALSE;
	}
        $sql .= "])";


        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":tipo_parentela", $tipo_parentela);
                $stm->bindParam(":nome", $nome);
                $stm->bindParam(":cognome", $cognome);
                $stm->bindParam(":sesso", $sesso);
                $stm->bindParam(":id_famiglia", $id_famiglia);
                $stm->bindParam(":professione", $professione);
                $stm->bindParam(":data_nascita", $data_nascita);
                $stm->bindParam(":codice_fiscale", $codice_fiscale);
                $stm->bindParam(":via", $via);
                $stm->bindParam(":numero_civico", $numero_civico);
                $stm->bindParam(":citta", $citta);
                $stm->bindParam(":cap", $cap);
                $stm->bindParam(":quartiere", $quartiere);
                $stm->bindParam(":stato_nascita", $stato_nascita);
                $stm->bindParam(":provincia_nascita", $provincia_nascita);
                $stm->bindParam(":comune_nascita", $comune_nascita);
                $stm->bindParam(":provincia_residenza", $provincia_residenza);
                $stm->bindParam(":comune_residenza", $comune_residenza);

                $stm->execute();
		$r = $stm->fetch(PDO::FETCH_BOTH);
		$_POST['id'] = $r['inserisci_persona'];
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		exit;
        }
?>
