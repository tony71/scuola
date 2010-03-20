<?php
        // Dati tabella persone
        $tipo_parentela = $_POST['tipo_parentela'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $sesso = $_POST['sesso'];
        $id_famiglia = $_POST['id_famiglia'];
        $professione = (empty($_POST['professione']) ? NULL : $_POST['professione']);
        $data_nascita = (empty($_POST['data_nascita']) ? NULL : $_POST['data_nascita']);
        $luogo_nascita = (empty($_POST['luogo_nascita']) ? NULL : $_POST['luogo_nascita']);
        $cittadinanza = (empty($_POST['cittadinanza']) ? NULL : $_POST['cittadinanza']);
        $codice_fiscale = (empty($_POST['codice_fiscale']) ? NULL : $_POST['codice_fiscale']);
        $via = (empty($_POST['via']) ? NULL : $_POST['via']);
        $numero_civico = (empty($_POST['numero_civico']) ? NULL : $_POST['numero_civico']);
        $citta = (empty($_POST['citta']) ? NULL : $_POST['citta']);
        $id_provincia = (empty($_POST['id_provincia']) ? NULL : $_POST['id_provincia']);
        $cap = (empty($_POST['cap']) ? NULL : $_POST['cap']);
        $quartiere = (empty($_POST['quartiere']) ? NULL : $_POST['quartiere']);

        $sql = "INSERT INTO persone (";
        $sql .= "tipo_parentela";
        $sql .= ", nome";
        $sql .= ", cognome";
        $sql .= ", sesso";
        $sql .= ", id_famiglia";
        $sql .= ", professione";
        $sql .= ", data_nascita";
        $sql .= ", luogo_nascita";
        $sql .= ", cittadinanza";
        $sql .= ", codice_fiscale";
        $sql .= ", id_persona";
        $sql .= ", via";
        $sql .= ", numero_civico";
        $sql .= ", citta";
        $sql .= ", id_provincia";
        $sql .= ", cap";
        $sql .= ", quartiere";
        $sql .= ") VALUES (";
        $sql .= ":tipo_parentela";
        $sql .= ", :nome";
        $sql .= ", :cognome";
        $sql .= ", :sesso";
        $sql .= ", :id_famiglia";
        $sql .= ", :professione";
        $sql .= ", :data_nascita";
        $sql .= ", :luogo_nascita";
        $sql .= ", :cittadinanza";
        $sql .= ", :codice_fiscale";
        $sql .= ", DEFAULT";
        $sql .= ", :via";
        $sql .= ", :numero_civico";
        $sql .= ", :citta";
        $sql .= ", :id_provincia";
        $sql .= ", :cap";
        $sql .= ", :quartiere";
        $sql .= ") RETURNING id_persona";

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
                $stm->bindParam(":cittadinanza", $cittadinanza);
                $stm->bindParam(":codice_fiscale", $codice_fiscale);

                $stm->bindParam(":via", $via);
                $stm->bindParam(":numero_civico", $numero_civico);
                $stm->bindParam(":citta", $citta);
                $stm->bindParam(":id_provincia", $id_provincia);
                $stm->bindParam(":cap", $cap);
                $stm->bindParam(":quartiere", $quartiere);

                $stm->execute();
		$r = $stm->fetch(PDO::FETCH_BOTH);
		$_POST['id'] = $r['id_persona'];
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
		exit;
        }
?>
