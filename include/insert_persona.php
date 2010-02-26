<?php
        // Dati tabella persone
        $tipo_parentela = $_POST['tipo_parentela'];
        $nome = $_POST['nome'];
        $cognome = $_POST['cognome'];
        $sesso = $_POST['sesso'];
        $id_famiglia = $_POST['id_famiglia'];
        $professione = $_POST['professione'];
        $data_nascita = $_POST['data_nascita'];
        $luogo_nascita = $_POST['luogo_nascita'];
        $cittadinanza = $_POST['cittadinanza'];
        $codice_fiscale = $_POST['codice_fiscale'];
        $via = $_POST['via'];
        $numero_civico = $_POST['numero_civico'];
        $citta = $_POST['citta'];
        $id_provincia = $_POST['id_provincia'];
        $cap = $_POST['cap'];
        $quartiere = $_POST['quartiere'];

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
        $sql .= ", id";
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
        $sql .= ") RETURNING id";

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
		$r = $stm->fetchAll();
		print_r($r);
        }
        catch(PDOException $e) {
                echo '<p class="error">' . $e->getMessage(). '</p>';
        }
?>
