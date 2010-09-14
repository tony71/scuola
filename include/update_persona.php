<?php
        // Dati tabella persone
	include('dati_post_persona.php');

        $sql = "UPDATE persone SET ";
        $sql .= "tipo_parentela=:tipo_parentela";
        $sql .= ", nome=:nome";
        $sql .= ", cognome=:cognome";
        $sql .= ", sesso=:sesso";
        $sql .= ", id_famiglia=:id_famiglia";
        $sql .= ", professione=:professione";
        $sql .= ", data_nascita=:data_nascita";
        $sql .= ", luogo_nascita=:luogo_nascita";
        // $sql .= ", cittadinanza=:cittadinanza";
        $sql .= ", codice_fiscale=:codice_fiscale";
        $sql .= ", via=:via";
        $sql .= ", numero_civico=:numero_civico";
        $sql .= ", citta=:citta";
        $sql .= ", id_provincia=:id_provincia";
        $sql .= ", cap=:cap";
        $sql .= ", quartiere=:quartiere";
        $sql .= ", stato_nascita=:stato_nascita";
        $sql .= ", provincia_nascita=:provincia_nascita";
        $sql .= ", comune_nascita=:comune_nascita";
        $sql .= ", provincia_residenza=:provincia_residenza";
        $sql .= ", comune_residenza=:comune_residenza";
        $sql .= " WHERE id_persona=:id";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":tipo_parentela", $tipo_parentela);
                $stm->bindParam(":nome", $nome);
                $stm->bindParam(":cognome", $cognome);
                $stm->bindParam(":sesso", $sesso);
                $stm->bindParam(":id_famiglia", $id_famiglia);
                $stm->bindParam(":professione", $professione);
                $stm->bindParam(":data_nascita", $data_nascita);
                $stm->bindParam(":luogo_nascita", $luogo_nascita);
                // $stm->bindParam(":cittadinanza", $cittadinanza);
                $stm->bindParam(":codice_fiscale", $codice_fiscale);
                $stm->bindParam(":via", $via);
                $stm->bindParam(":numero_civico", $numero_civico);
                $stm->bindParam(":citta", $citta);
                $stm->bindParam(":id_provincia", $id_provincia);
                $stm->bindParam(":cap", $cap);
                $stm->bindParam(":quartiere", $quartiere, PDO::PARAM_STR, 2);
                $stm->bindParam(":stato_nascita", $stato_nascita);
                $stm->bindParam(":provincia_nascita", $provincia_nascita);
                $stm->bindParam(":comune_nascita", $comune_nascita);
                $stm->bindParam(":provincia_residenza", $provincia_residenza);
                $stm->bindParam(":comune_residenza", $comune_residenza);

                $stm->bindParam(":id", $id);

                $stm->execute();

		ob_start();
		$stm->debugDumpParams();
		$buffer = ob_get_contents();
		ob_end_clean();
		error_log($buffer);
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$sql = "DELETE FROM cittadinanze WHERE id_persona=:id";
        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":id", $id);

                $stm->execute();

		ob_start();
		$stm->debugDumpParams();
		$buffer = ob_get_contents();
		ob_end_clean();
		error_log($buffer);
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }

	$sql = "INSERT INTO cittadinanze(id_persona, codice_sidi) VALUES (:id, :codice_sidi)";

	foreach($_POST['cittadinanza'] as $key => $value) {
        	try {
	                $stm = $db->prepare($sql);

        	        $stm->bindParam(":id", $id);
        	        $stm->bindParam(":codice_sidi", $value);

                	$stm->execute();

			ob_start();
			$stm->debugDumpParams();
			$buffer = ob_get_contents();
			ob_end_clean();
			error_log($buffer);
        	}
		catch(PDOException $e) {
                	echo '<p class="error">' . $e->getMessage(). '</p>';
        	}
	}
?>
