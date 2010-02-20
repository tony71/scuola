<?php
        // Dati tabella studenti
        $matricola = $_POST['matricola'];
        $nome_breve = $_POST['nome_breve'];
        $cognome_breve = $_POST['cognome_breve'];

        $vaccinazioni = "false";
	if (isset($_POST['vaccinazioni'])) {
        	$vaccinazioni = "true";
	}

	unset($note);
	if (isset($_POST['note'])) {
		if (strlen($_POST['note']) != 0) {
        		$note = $_POST['note'];
		}
	}

	unset($controindicazioni_mensa);
	if (isset($_POST['controindicazioni_mensa'])) {
		if (strlen($_POST['controindicazioni_mensa']) != 0) {
        		$controindicazioni_mensa = $_POST['controindicazioni_mensa'];
		}
	}

	unset($giudizio1);
	if (isset($_POST['giudizio1'])) {
		if (strlen($_POST['giudizio1']) != 0) {
        		$giudizio1 = $_POST['giudizio1'];
		}
	}

	unset($giudizio2);
	if (isset($_POST['giudizio2'])) {
		if (strlen($_POST['giudizio2']) != 0) {
        		$giudizio2 = $_POST['giudizio2'];
		}
	}

        $consegnato_modulo = "false";
	if (isset($_POST['consegnato_modulo'])) {
        	$consegnato_modulo = "true";
	}

        $certificato_medico = "false";
	if (isset($_POST['certificato_medico'])) {
        	$certificato_medico = "true";
	}

	if (isset($_POST['anni_scuola_materna']) and is_numeric($_POST['anni_scuola_materna'])) {
		$anni_scuola_materna = $_POST['anni_scuola_materna'];
	}
	else {
		unset($anni_scuola_materna);
	}

        $caso_speciale = "false";
	if (isset($_POST['caso_speciale'])) {
        	$caso_speciale = "true";
	}

	unset($motivazione_cs);
	if (isset($_POST['motivazione_cs'])) {
		if (strlen($_POST['motivazione_cs']) != 0) {
        		$motivazione_cs = $_POST['motivazione_cs'];
		}
	}

        $hc = "false";
	if (isset($_POST['hc'])) {
        	$hc = "true";
	}

        $stato = $_POST['stato'];

        $sql = "UPDATE studenti SET ";
	$sql .= "matricola=:matricola, ";
	$sql .= "nome_breve=:nome_breve, ";
	$sql .= "cognome_breve=:cognome_breve, ";
	$sql .= "vaccinazioni=:vaccinazioni, ";
	$sql .= "note=:note, ";
	$sql .= "controindicazioni_mensa=:controindicazioni_mensa, ";
	$sql .= "giudizio1=:giudizio1, ";
	$sql .= "giudizio2=:giudizio2, ";
	$sql .= "consegnato_modulo=:consegnato_modulo, ";
	$sql .= "certificato_medico=:certificato_medico, ";
	$sql .= "anni_scuola_materna=:anni_scuola_materna, ";
	$sql .= "caso_speciale=:caso_speciale, ";
	$sql .= "motivazione_cs=:motivazione_cs, ";
	$sql .= "hc=:hc, ";
	$sql .= "stato=:stato ";
	$sql .= "WHERE id_persona=:id_persona ";

        try {
                $stm = $db->prepare($sql);

                $stm->bindParam(":matricola", $matricola);
                $stm->bindParam(":nome_breve", $nome_breve);
                $stm->bindParam(":cognome_breve", $cognome_breve);
                $stm->bindParam(":vaccinazioni", $vaccinazioni);
                $stm->bindParam(":note", $note);
                $stm->bindParam(":controindicazioni_mensa", $controindicazioni_mensa);
                $stm->bindParam(":giudizio1", $giudizio1);
                $stm->bindParam(":giudizio2", $giudizio2);
                $stm->bindParam(":consegnato_modulo", $consegnato_modulo);
                $stm->bindParam(":certificato_medico", $certificato_medico);
                $stm->bindParam(":anni_scuola_materna", $anni_scuola_materna, PDO::PARAM_INT);
                $stm->bindParam(":caso_speciale", $caso_speciale);
                $stm->bindParam(":motivazione_cs", $motivazione_cs);
                $stm->bindParam(":hc", $hc);
                $stm->bindParam(":stato", $stato);

                $stm->bindParam(":id_persona", $id);

                $stm->execute();
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
?>
